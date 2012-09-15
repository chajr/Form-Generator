<?php
/**
 * create form and handle all operations on created form
 * @author chajr <chajr@bluetree.pl>
 * @package form
 * @version 0.14.0
 * @copyright chajr/bluetree
 * @todo pobieranie danych z other_val
 * @todo dodac sterowanie ile razy dynamiczny input ma byc powtorzony, podane w definicji
 * 
 */
class Forms_Form 
{
	/**
     * contains informations about object errors
	 * @var string 
	 */
	public $error = NULL;
	/**
     * array of non used in HTML5 attributes
	 * @var array
	 */
	public $attributes = array(
		'valid_dependency', 
        'other_val', 
        'valid_type', 
        'js', 
        'minlength', 
        'check_val', 
        'check_field', 
        'escape', 
        'entities', 
        'dynamic'
	);
	/**
     * list of inputs with errors
	 * @var array
	 */
	public $errorList = array();
	/**
     * xml object with page to process
	 * @var xmlobject
	 */
	protected $_main;
	/**
     * contains xml object
	 * @var object 
	 */
	protected $_xml;
	/**
     * information that form will be validated
     * TRUE = yes, FALSE = no
	 * @var boolean 
	 */
	protected $_valid = TRUE;
	/**
     * if set to TRUE in form was some errors
	 * @var boolean 
	 */
	protected $_inputError = FALSE;
	/**
     * contains modified form to display
	 * @var object 
	 */
	protected $_display;
	/**
     * contais actually processing form element
	 * @var xmlobject 
	 */
	protected $_currentInput;
	/**
     * contains array of additional input definitions
	 * @var array 
	 */
	protected $_listDefinition;
	/**
     * contains array of all inputs
	 * @var array 
	 */
	protected $_allInputs;
	/**
     * containf number of radio index in _listDefinition array
	 * @var integer 
	 */
	protected $_radioIndexNumber = 0;
    /**
     * contains sended from form POST or GET data
     * @var type 
     */
    protected $_valueList = array();
	/**
	 * array of dynamic inputs and their correct names
	 * @var array 
	 */
    protected $_updateInputList = array();
	/**
     * create form object, check that xml definition exists, load definition
     * and gets main node from definition
	 * @param string $form form definition name
     * @param string $listDefinition other form definitions (overrides that from xml file)
     * @uses Forms_Form::$_listDefinition
	 * @uses Forms_Form::$error
	 * @uses Forms_Form::$_main
	 * @uses Forms_Form::$valid
     * @uses Forms_Form::$_xml
	 * @uses Core_Xml::$documentElement
	 * @uses Core_Xml::$err
	 * @uses Core_Xml::__construct()
	 * @uses Core_Xml::loadFile()
	 * @uses Core_Xml::getAttribute()
	 */
	public function __construct($form, $listDefinition = NULL)
	{
		$this->_listDefinition = $listDefinition;
		$definition = 'xml/' . $form . '.xml';
		if (!file_exists($definition)) {
			$this->error = 'definition_none_exist';
			return FALSE;
		}
		$this->_xml = new Core_Xml();
		$bool = $this->_xml->loadFile($definition, 0);
		if (!$bool) {
			$this->error = $this->_xml->err;
			return FALSE;
		}
		$this->_main = $this->_xml->documentElement;
		$valid = $this->_main->getAttribute('novalidate');
		if ($valid === 'novalidate') {
			$this->valid = FALSE;
		}
	}
	/**
     * display main form
     * to add and edit content with possible errors
	 * @return string html form structure to display
	 * @uses Forms_Form::$_display
     * @uses Forms_Form::$_xml
     * @uses Forms_Form::$_allInputs
     * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::_updateAttribute()
     * @uses Forms_Form::_transformText()
     * @uses Forms_Form::_transformNumber()
     * @uses Forms_Form::_transformEmail()
     * @uses Forms_Form::_transformColor()
     * @uses Forms_Form::_transformCheckbox()
     * @uses Core_Xml::getElementsByTagName()
     * @uses Core_Xml::saveFile()
	 * 
	 * @todo wyswietlenie pol dynamicznych wraz z wartosciami w przypadku bledu
	 * 
	 */
	public function displayForm()
	{
		$this->_display     = clone $this->_xml;
		$this->_allInputs   = $this->_display->getElementsByTagName('input');
		foreach ($this->_allInputs as $index => $this->_currentInput) {
			$this->_updateAttribute($index);
			$type = $this->_currentInput->getAttribute('type');
			switch ($type) {
				case'text': case'password': case'search': case'tel': case'url':
					$this->_transformText();
					break;
				case'number': case'hidden': case'range':
					$this->_transformNumber();
					break;
				case'email':
					$this->_transformEmail();
					break;
				case'color': case'date': case'datetime': case'datetime-local': case'time': case'week':
					$this->_transformColor();
					break;
				case'checkbox': case'radio':
					$this->_transformCheckbox();
					break;
				default:
					break;
			}
		}
        foreach($this->_updateInputList as $input) {
			$input['node']->setAttribute('name', $input['name']);
        }
		$form = $this->_display->saveFile(0, 1);
		$form = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $form);
		$form = preg_replace('#<!DOCTYPE root SYSTEM "[\\w/_-]+\.dtd">#ui', '', $form);
		return $form;
	}
	/**
     * validation inputs from form
     * first updates inputs with given in construct definition
     * checks dependences, is required, pattern, length, type, etc.
     * next with given input type if pattern and valid_type was empty
     * returns TRUE if all was ok, or validation is not required
	 * @param array $valueList post or get informations
	 * @return boolean
     * @uses Forms_Form::$_valid
     * @uses Forms_Form::$_allInputs
     * @uses Forms_Form::$_xml
     * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_inputError
     * @uses Forms_Form::$_main
     * @uses Forms_Form::$_valueList
     * @uses Forms_Form::_updateAttribute()
     * @uses Forms_Form::_checkDynamic()
     * @uses Forms_Form::_baseValidation()
     * @uses Forms_Form::_switchValid()
     * @uses Forms_Form::_updateErrorNode()
     * @uses Forms_Form::_addClass()
     * @uses Core_Xml::getElementsByTagName()
     * @uses Core_Xml::getAttribute()
     * 
	 * @todo mozliwa konwersja jezykowa kodow
	 */
	public function valid(array $valueList)
	{
		if (!$this->_valid) {
			return TRUE;
		}
        $this->_valueList = $valueList;
		$this->_allInputs = $this->_xml->getElementsByTagName('input');
		foreach ($this->_allInputs as $index => $this->_currentInput) {
			$name = $this->_currentInput->getAttribute('name');
			if (!$name) {
				continue;
			}
			$this->_updateAttribute($index);
			$valid = $this->_currentInput->getAttribute('formnovalidate');
			if ($valid === 'off') {
				continue;
			}
			if ($this->_checkDynamic()) {
				$name = preg_replace('#[\[\]]#', '', $name);
			} else {
				$value = trim($this->_valueList[$name]);
				$this->_baseValidation($value);
				$this->_switchValid($value, $name);
			}
//			if(preg_match('#^[\p{L}\\d_-]+\[\]$#iu', $name)){
//				$name = preg_replace('#[\[\]]#', '', $name);
//				if(!in_array($name, $this->dont_check)){
//					foreach($list->$name as $value){
//						$this->_baseValidation($value, $list);
//					}
//					$this->dont_check[] = $name;
//					$val = $list->$name;
//				}
//			}else{
				
//			}
			$this->_updateErrorNode($name);
		}
		if($this->_inputError){
			$this->_addClass($this->_main, 'form_error');
			return FALSE;
		}
		return TRUE;
	}
	/**
     * base input validation, same for all form inputs
     * if is set required and valid dependency then after fill parent input, checked input will be required
	 * @param mixed $value input value to check
	 * @return void
	 * @uses Forms_Form::_validDependency()
	 * @uses Forms_Form::_validRequire()
	 * @uses Forms_Form::_validPattern()
	 * @uses Forms_Form::_validLength()
	 * @uses Forms_Form::_validType()
	 * @uses Forms_Form::_validField()
	 */
	protected function _baseValidation($value)
	{
		
		//sprawdzanie atrybutu disabled, jesli disabled nie przetwarza pola
		
		$bool = $this->_validDependency();
		if ($bool) {
			return;
		}
		$bool = $this->_validRequire($value);
		if ($bool) {
			return;
		}
		$this->_validPattern($value);
		$this->_validLength($value);
		$this->_validType($value);
		$this->_validField();
	}
	/**
     * switch validation type based on input type
	 * @param mixed $value data to check
	 * @param string $name data name
	 * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_valueList
	 * @uses Forms_Form::_validText()
	 * @uses Forms_Form::_validNumber()
	 * @uses Forms_Form::_validEmail()
	 * @uses Forms_Form::_validColor()
	 * @uses Forms_Form::_validDate()
	 * @uses Forms_Form::_validDatetime()
	 * @uses Forms_Form::_validMonth()
	 * @uses Forms_Form::_validTelephone()
	 * @uses Forms_Form::_validTime()
	 * @uses Forms_Form::_validUrl()
	 * @uses Forms_Form::_validWeek()
	 * @uses Forms_Form::_validCheckbox()
	 * @uses Core_Xml::getAttribute()
	 */
	protected function _switchValid($value, $name)
	{
		if (isset($this->_valueList[$name]) && $value) {
			switch ($this->_currentInput->getAttribute('type')) {
				case'text': case 'hiden': case'password': case'search':
					$this->_validText($value);
					break;
				case'number': case'range':
					$this->_validNumber($value);
					break;
				case'email':
					$this->_validEmail($value);
					break;
				case'color':
					$this->_validColor($value);
					break;
				case'date':
					$this->_validDate($value);
					break;
				case'datetime': case'datetime-local':
					$this->_validDatetime($value);
					break;
				case'month':
					$this->_validMonth($value);
					break;
				case'tel':
					$this->_validTelephone($value);
					break;
				case'time':
					$this->_validTime($value);
					break;
				case'url':
					$this->_validUrl($value);
					break;
				case'week':
					$this->_validWeek($value);
					break;
				case'checkbox': case'radio':
					$this->_validCheckbox($value);
					break;
				default:
					break;
			}
		}
	}
	/**
     * validate text input
	 * @param mixed $value
	 */
	protected function _validText($value)
	{
		//input typu text ma pelna liste znakow i nie nie weryfikuje ich
	}
	/**
	 * checkbox validation
	 * @param mixed $value wartosc do sprawdzenia
	 * @uses Forms_Form::_validRange()
	 * @uses Forms_Form::_validStep()
	 */
	protected function _validCheckbox($value)
	{
		$this->_validRange($value);
		$this->_validStep($value);
	}
	/**
     * number input validation
     * checks if is set attribute pattern for input and valid_type was empty
	 * @param float $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Forms_Form::_validRange()
	 * @uses Forms_Form::_validStep()
	 */
	protected function _validNumber($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'numeric');
			if (!$bool) {
				$this->_setError($name, 'numeric');
			}
		}
		$this->_validRange($value);
		$this->_validStep($value);
	}
	/**
     * validate e-mail adress
     * checks only if pattern value was empty
	 * @param string $value wartosc do sprawdzenia
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 */
	protected function _validEmail($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern')) {
			$bool = Validator_Simple::valid($value, 'mail');
			if (!$bool) {
				$this->_setError($name, 'mail');
			}
		}
	}
	/**
     * validate url adress
     * checks only if pattern value was empty
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 */
	protected function _validUrl($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'url_full');
			if (!$bool) {
				$this->_setError($name, 'url_full');
			}
		}
	}
	/**
	 * validate color value
     * checks only if pattern value was empty
	 * @param mixed $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Forms_Form::_validRange()
	 */
	protected function _validColor($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern')) {
			$bool = Validator_Simple::valid($value, 'hex_color');
			if (!$bool) {
				$this->_setError($name, 'hex_color');
			}
		}
		$this->_validRange($value);
	}
	/**
     * validate date value
     * checks only if pattern and valid_type value was empty
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Forms_Form::_validDateRange()
	 */
	protected function _validDate($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'date');
			if (!$bool) {
				$this->_setError($name, 'date');
			}
		}
		$this->_validDateRange($value);
	}
	/**
     * validate date value with week number
     * checks only if pattern and valid_type value was empty
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Validator_Simple::range()
	 */
	protected function _validWeek($value)
	{
		$value  = str_replace('W', '', $value);
		$list   = explode('-', $value);
		$name   = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'week');
			if (!$bool) {
				$this->_setError($name, 'week');
			}
		}
		$min = $this->_currentInput->getAttribute('min');
		$max = $this->_currentInput->getAttribute('max');
		if ($min) {
			$min = explode('-', $min);
			$bool = Validator_Simple::range($list[0], $min[0], NULL);
			if (!$bool) {
				$this->_setError($name, 'range_min_year');
			}
			$bool = Validator_Simple::range($list[1], $min[1], NULL);
			if (!$bool) {
				$this->_setError($name, 'range_min_week');
			}
		}
		if ($max) {
			$max = explode('-', $max);
			$bool = Validator_Simple::range($list[0], NULL, $max[0]);
			if (!$bool) {
				$this->_setError($name, 'range_max_year');
			}
			$bool = Validator_Simple::range($list[1], NULL, $max[1]);
			if (!$bool ){
				$this->_setError($name, 'range_max_week');
			}
		}
	}
	/**
     * validate time value
     * checks only if pattern and valid_type value was empty
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Forms_Form::_validDateRange()
	 */
	protected function _validTime($value){
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'time');
			if (!$bool) {
				$this->_setError($name, 'time');
			}
		}
		$this->_validDateRange($value);
	}
	/**
     * validate month and year value
     * checks only if pattern and valid_type value was empty
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 * @uses Forms_Form::_validDateRange()
	 */
	protected function _validMonth($value)
	{
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
			!$this->_currentInput->getAttribute('valid_type')
		) {
			$bool = Validator_Simple::valid($value, 'month');
			if (!$bool) {
				$this->_setError($name, 'month');
			}
		}
		$this->_validDateRange($value);
	}
	/**
     * checks rnge for date and time values
	 * @param string $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::range()
	 */
	protected function _validDateRange($value)
	{
		$value  = strtotime($value);
		$name   = $this->_currentInput->getAttribute('name');
		if (!$value) {
			$this->_setError($name, 'date_range_conversion');
		}
		$max = $this->_currentInput->getAttribute('max');
		$max = strtotime($max);
		if ($max) {
			$bool = Validator_Simple::range($value, NULL, $max);
			if (!$bool) {
				$this->_setError($name, 'range_max');
			}
		}
		$min = $this->_currentInput->getAttribute('min');
		$min = strtotime($min);
		if ($min) {
			$bool = Validator_Simple::range($value, $min, NULL);
			if (!$bool) {
				$this->_setError($name, 'range_min');
			}
		}
	}
	/**
     * validate telephone number
     * checks only if pattern and valid_type value was empty
	 * @param mixed $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * @uses Forms_Form::_setError()
	 */
	protected function _validTelephone($value)
    {
		$name = $this->_currentInput->getAttribute('name');
		if (!$this->_currentInput->getAttribute('pattern') && 
            !$this->_currentInput->getAttribute('valid_type')
        ) {
			$bool = Validator_Simple::valid($value, 'phone');
			if (!$bool) {
				$this->_setError($name, 'phone');
			}
		}
	}
	/**
     * checks corelations between inputs
     * if checked input is filled, require checking other inputs
     * if return true input was empty and other inputs wont be checked
     * if false continue checking
	 * @param object $list
	 * @return boolean
	 * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_valueList
	 * @uses Core_Xml::getAttribute()
	 */
	protected function _validDependency()
    {
		
		//i co dalej z tym pierdolonym radio
		//sprawdza czy radio, jesli tak i jesli $radio_index_number = 0 pobiera wartosc atrybutu _validDependency
		//zapisuje wartosc w specjalnej zmiennej, tak aby mozna bylo go wiazac z innymi elementami radio
		//jesli $radio_index_number = 0 czysci wartosc zmiennej
		
		$dependency = $this->_currentInput->getAttribute('valid_dependency');
		if ($dependency) {
			$dependency     = explode(CORE_PARAM_SEPARATOR, $dependency);
			foreach ($dependency as $element) {
				if (!isset($this->_valueList[$element]) || 
                    !$this->_valueList[$element]
                ) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	/**
     * checks step for numeric fields
	 * @param float $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 * @uses simpleValid_calss::step()
	 */
	protected function _validStep($value)
    {
		$step = $this->_currentInput->getAttribute('step');
		if (($step || $step == 0) && $step !== '') {
			$name       = $this->_currentInput->getAttribute('name');
			$default    = $this->_currentInput->getAttribute('value');
			$check      = Validator_Simple::step($step, $value, $default);
			if (!$check) {
				$this->_setError($name, 'step');
			}
		}
	}
	/**
     * checks that input is required
     * if return true input is not required and wont check it
     * if false require checking input
     * if input is required, and value is empty sets error
	 * @param mixed $value
	 * @return boolean
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 */
	protected function _validRequire($value)
    {
		$name       = $this->_currentInput->getAttribute('name');
		$required   = $this->_currentInput->getAttribute('required');
		if ($required === 'required') {
			if ($value === '') {
				$this->_setError($name, 'required');
				return FALSE;
			}
		} elseif ($value === '') {
			return TRUE;
		}
		return FALSE;
	}
	/**
     * checks input value with given pattern
	 * @param mixed $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 */
	protected function _validPattern($value)
    {
		$name       = $this->_currentInput->getAttribute('name');
		$pattern    = $this->_currentInput->getAttribute('pattern');
		if ($pattern) {
			$bool = preg_match($pattern, $value);
			if (!$bool ){
				$this->_setError($name, 'pattern');
			}
		}
	}
	/**
     * checks maximum char lenght of input value, with or without entities and escape sequence
	 * @param mixed $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::charLenght()
	 */
	protected function _validLength($value)
    {
		$escape     = $this->_currentInput->getAttribute('escape');
		$entities   = $this->_currentInput->getAttribute('entities');
		$name       = $this->_currentInput->getAttribute('name');
		$min        = $this->_currentInput->getAttribute('minlength');
		$max        = $this->_currentInput->getAttribute('maxlength');
        if ($min || $max) {
            if ($escape) {
			$value = mysqli_escape_string($value);
            }
            if ($entities) {
                $value = htmlentities($value);
            }
            $minBool = Validator_Simple::charLenght($value, $min, NULL);
            $maxBool = Validator_Simple::charLenght($value, NULL, $max);
            if (!$minBool) {
                $this->_setError($name, 'minlength');
            }
            if (!$maxBool) {
                $this->_setError($name, 'maxlength');
            }
        }
	}
	/**
     * checks input validation type
	 * @param mixes $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::valid()
	 * 
	 * @todo w zaleznosci od typu sprawdzania sprawdza dodatkowe atrybuty (np jesli sprawdza date, uruchamia sprawdzenie zakresu dat) zabezpieczenie dla zwyklych inputow
	 * @todo zabezpieczenie gdy mozliwe podwojne sprawdzenie np zakresu
	 * 
	 */
	protected function _validType($value)
    {
		$name       = $this->_currentInput->getAttribute('name');
		$validType  = $this->_currentInput->getAttribute('valid_type');
		if ($validType) {
			$bool = Validator_Simple::valid($value, $validType);
			if (!$bool) {
				$this->_setError($name, 'valid_type');
			}
		}
	}
	/**
     * checks that values of fields are the same
     * search given field and checks value
     * depends of special parameter return true for same values, or different values
	 * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_valueList
	 * @uses Forms_Form::$_xml
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getElementsByTagName()
	 * @uses Core_Xml::getAttribute()
	 * 
	 * @todo sprawdzanie czy wartosc pola jest wieksza, mniejsza, itp
	 * 
	 */
	protected function _validField()
    {
		$name           = $this->_currentInput->getAttribute('name');
		$checkField     = $this->_currentInput->getAttribute('check_field');
		if ($checkField) {
			$type       = explode(CORE_PARAM_SEPARATOR, $checkField);
			$inputs     = $this->_xml->getElementsByTagName('input');
			foreach ($inputs as $index => $element) {
				if ($element->getAttribute('name') === $type[0]) {
					if ((bool)$type[1]) {
						if ($this->_valueList[$element->getAttribute('name')] === 
                            $this->_currentInput->getAttribute('value')
                        ) {
							$this->_setError($name, 'check_field_true::' . $type[0]);
						}
					} elseif (!(bool)$type[1]) {
						if($this->_valueList[$element->getAttribute('name')] !== 
                           $this->_currentInput->getAttribute('value')
                        ){
							$this->_setError($name, 'check_field_false::' . $type[0]);
						}
					}
				}
			}
		}
	}
	/**
     * checks range of numeric value
     * if value has ',' chenge it to '.'
	 * @param float $value
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::_setError()
	 * @uses Core_Xml::getAttribute()
	 * @uses Validator_Simple::range()
	 */
	protected function _validRange($value)
    {
		$value  = str_replace(',', '.', $value);
		$name   = $this->_currentInput->getAttribute('name');
		$max    = $this->_currentInput->getAttribute('max');
		if ($max) {
			$bool = Validator_Simple::range($value, NULL, $max);
			if (!$bool) {
				$this->_setError($name, 'range_max');
			}
		}
		$min = $this->_currentInput->getAttribute('min');
		if ($min) {
			$bool = Validator_Simple::range($value, $min, NULL);
			if (!$bool) {
				$this->_setError($name, 'range_min');
			}
		}
	}
	/**
     * make base input transformation, befor displaying it
     * removes unused, or incompatible with HTML5 attributes, nodes, error containres
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::$attributes
	 * @uses Core_Xml::$value
	 * @uses Core_Xml::$attributes
	 * @uses Core_Xml::$name
	 * @uses Core_Xml::$parentNode
	 * @uses Forms_Form::_removeAttribute()
	 * @uses Forms_Form::_searchErrorTag()
	 * @uses Core_Xml::removeChild()
	 */
	protected function _baseTransform()
    {
		$this->_removeAttribute($this->attributes);
		$toDelete = array();
		foreach ($this->_currentInput->attributes as $attribute) {
			if (trim($attribute->value) == '') {
				$toDelete[] = $attribute->name;
			}
		}
		$errorNode = $this->_searchErrorTag(1);
		if ($errorNode) {
			$parent = $errorNode->parentNode;
			$parent->removeChild($errorNode);
		}
		$this->_removeAttribute($toDelete);
	}
	/**
     * transform text inputs
     * makes base transformation, and removes incompatible attributes
	 * @uses Forms_Form::_baseTransform()
	 * @uses Forms_Form::_removeAttribute()
	 */
	protected function _transformText()
    {
		$this->_baseTransform();
		$wrongAttributes = array(
			'step', 'max', 'min'
		);
		$this->_removeAttribute($wrongAttributes);
	}
	/**
	 * transform numeric inputs
	 * @uses Forms_Form::_baseTransform()
	 */
	protected function _transformNumber()
    {
		$this->_baseTransform();
	}
	/**
	 * transform e-mail inputs
	 * @uses Forms_Form::_baseTransform()
	 * @uses Forms_Form::_removeAttribute()
	 */
	protected function _transformEmail()
    {
		$this->_baseTransform();
		$wrongAttributes = array(
			'step', 'max', 'min'
		);
		$this->_removeAttribute($wrongAttributes);
	}
	/**
     * transform color inputs
	 * transformuje pole koloru
	 * @uses Forms_Form::_baseTransform()
	 * @uses Forms_Form::_removeAttribute()
	 */
	protected function _transformColor()
    {
		$this->_baseTransform();
		$wrongAttributes = array(
			'step'
		);
		$this->_removeAttribute($wrongAttributes);
	}
	/**
	 * transform checkbox fields
	 * @uses Forms_Form::_baseTransform()
	 * @uses Forms_Form::_removeAttribute()
	 */
	protected function _transformCheckbox()
    {
		$this->_baseTransform();
		$wrongAttributes = array(
			'placeholder', 'autocomplete', 'list'
		);
		$this->_removeAttribute($wrongAttributes);
	}
    /**
     * updates checkbox attributes
     * @param string $name input name
     * @return array
     * @uses Forms_Form::$_radioIndexNumber
     * @uses Forms_Form::$_listDefinition
     * @uses Forms_Form::$_valueList
     */
    protected function _updateCheckboxAttribute($name) 
    {
        $this->_radioIndexNumber = 0;
        $input = $this->_listDefinition[$name];
        if (!empty($this->_valueList) && !$this->_valueList[$name]) {
            unset($input['checked']);
        }
        if ($this->_valueList[$name]) {
            $input['checked'] = 'checked';
        }
        return $input;
    }
    /**
     * updates ridiobutton attributes
     * @param string $name input name
     * @return array
     * @uses Forms_Form::$_radioIndexNumber
     * @uses Forms_Form::$_listDefinition
     * @uses Forms_Form::$_valueList
     * @uses Forms_Form::$_currentInput
     */
    protected function _updateRadioAttribute($name) 
    {
        unset($this->_listDefinition[$name]['value']);
        $input = $this->_listDefinition[$name][$this->_radioIndexNumber];
        $this->_currentInput->removeAttribute('checked');
        if ($this->_valueList[$name] === $this->_currentInput->getAttribute('value')) {
            $input['checked'] = 'checked';
            foreach ($this->_listDefinition[$name] as $number => $values) {
                if ($values['checked'] === 'checked') {
                    unset($this->_listDefinition[$name][$number]['checked']);
                }
            }
        }
        $this->_radioIndexNumber++;
        return $input;
    }
    /**
     * updates input attributes, and append dynamic inputs given in definition
     * @param string $name
     * @return array
     * @uses Forms_Form::$_radioIndexNumber
     * @uses Forms_Form::$_listDefinition
     * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_updateInputList
     * @uses Core_Xml::$parentNode
     * @uses Forms_Form::_checkDynamic()
     * @uses Core_Xml::cloneNode()
     */
    protected function _updateInputAttribute($name) 
    {
        $input = FALSE;
        if ($this->_checkDynamic()) {
            if ($this->_listDefinition[$name]) {
                $parentNode = $this->_currentInput->parentNode;
                foreach ($this->_listDefinition[$name][0] as $firstName => $firstValue) {
                    $this->_currentInput->setAttribute($firstName, $firstValue);
                }
                unset($this->_listDefinition[$name][0]);
                foreach ($this->_listDefinition[$name] as $inputDefinition) {
                    $newInput = $this->_currentInput->cloneNode();
                    foreach ($inputDefinition as $attributeName => $value) {
                        $newInput->setAttribute($attributeName, $value);
                    }
                    $newInput->removeAttribute('name');
                    $addedNode = $parentNode->appendChild($newInput);
                    $this->_updateInputList[] = array(
                        'name'      => $name,
						'node'		=> $addedNode
                    );
                }
            }
        } else {
            $this->_radioIndexNumber = 0;
            $input = $this->_listDefinition[$name];
        }
        return $input;
    }
	/**
     * updates input attributes compatible with given definition list
     * compleats with some contentwhen form has errors
     * or selects selected before checkboxes, radio buttons and select inputs
	 * @param integer $index index przetwarzanego elementu (dla elementow o takiej samej nazwie)
	 * @uses Forms_Form::$_currentInput
     * @uses Forms_Form::$_valueList
	 * @uses Forms_Form::$_radioIndexNumber
	 * @uses Forms_Form::$_listDefinition
	 * @uses Forms_Form::_removeAttribute()
     * @uses Forms_Form::_updateCheckboxAttribute()
     * @uses Forms_Form::_updateRadioAttribute()
     * @uses Forms_Form::_updateInputAttribute()
	 * @uses Core_Xml::getAttribute()
	 * @uses Core_Xml::setAttribute()
	 */
	protected function _updateAttribute($index)
    {
		$name = $this->_currentInput->getAttribute('name');
		if (isset($this->_listDefinition[$name])) {
            $input = FALSE;
            switch ($this->_currentInput->getAttribute('type')) {
                case 'checkbox':
                    $input = $this->_updateCheckboxAttribute($name);
                    break;
                case 'radio':
                    $input = $this->_updateRadioAttribute($name);
                    break;
                case 'textarea':
                    break;
                default:
                    $input = $this->_updateInputAttribute($name);
                    break;
            }
            if ($input) {
                foreach ($input as $key => $value) {
                    @$this->_currentInput->setAttribute($key, $value);
                }
                if (isset($this->_valueList[$name]) && 
                    $this->_currentInput->getAttribute('type') !== 'radio'
                ) {
                    $value = $this->_valueList[$name];
                    $this->_currentInput->setAttribute('value', $value);
                }
            }
		}
	}
	/**
     * search in form elements for errors
     * if true process definition for display, if false process main definition
	 * @param boolean $display definition type
	 * @return mixed return xml node or NULL if not error element found 
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::$_display
	 * @uses Forms_Form::$_xml
	 * @uses Core_Xml::getAttribute()
	 * @uses Core_Xml::getElementsByTagName()
	 * @uses Core_Xml::item()
	 * 
	 * @todo przerobic tagi errorow, rozpoznawanie po atrybucie a nie nazwie wezla
	 * 
	 */
	protected function _searchErrorTag($display = FALSE)
    {
		if ($this->_checkDynamic()) {
			$name = preg_replace('#[\[\]]#', '', $this->_currentInput->getAttribute('name'));
		} else {
			$name = $this->_currentInput->getAttribute('name');
		}
		$name = $name . '_error';
		if ($display) {
			$node = $this->_display->getElementsByTagName($name);
		} else {
			$node = $this->_xml->getElementsByTagName($name);
		}
		if ($node->item(0)) {
			return $node->item(0);
		}
		return NULL;
	}
	/**
     * removes unnecessary attributes given in list 
	 * @param array $array array of attributes to remove
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::removeAttribute()
	 * @access private
	 */
	protected function _removeAttribute(array $array)
    {
		foreach ($array as $name) {
			$this->_currentInput->removeAttribute($name);
		}
	}
	/**
	 * przetwarza element datalist
	 */
	protected function _checkList()
    {
		$datalist = $this->_xml->getElementsByTagName('datalist');
		foreach ($datalist as $index => $list) {
			
		}
	}
	/**
     * set input error, and error flag to true
	 * @param string $name
	 * @param string $errorType error code
	 * @uses Forms_Form::$_inputError
	 * @uses Forms_Form::$errorList
	 */
	protected function _setError($name, $errorType)
    {
		$this->_inputError = TRUE;
		$this->errorList[$name][] = $errorType;
	}
	/**
     * add given class to element class attribute
	 * @param $element node that will have given class
	 * @param string $newClass new class
	 * @uses Core_Xml::getAttribute()
	 * @uses Core_Xml::setAttribute()
	 */
	protected function _addClass($element, $newClass)
    {
		$class  = $element->getAttribute('class');
		$class .= ' ' . $newClass;
		$element->setAttribute('class', $class);
	}
	/**
     * search element that will contain informatuions about error, for given input
     * update form content with errors, that are tag codes ({;code;}), and must be transformed to text
	 * @param string $name input name
	 * @uses Forms_Form::$_listDefinition
     * @uses Forms_Form::$_valueList
	 * @uses Forms_Form::$_currentInput
	 * @uses Forms_Form::$errorList
	 * @uses Forms_Form::$_xml
	 * @uses Forms_Form::$_inputError
	 * @uses Core_Xml::$parentNode
	 * @uses Core_Xml::$nodeValue
	 * @uses Core_Xml::$attributes
	 * @uses Core_Xml::$nodeType
	 * @uses Core_Xml::$name
	 * @uses Core_Xml::$value
	 * @uses Forms_Form::addClass()
	 * @uses Forms_Form::_searchErrorTag()
	 * @uses Core_Xml::getAttribute()
	 * @uses Core_Xml::createElement()
	 * @uses Core_Xml::appendChild()
	 * @uses Core_Xml::setAttribute()
	 */
	protected function _updateErrorNode($name)
    {
        if ($this->_valueList[$name]) {
            $this->_listDefinition[$name]['value'] = $this->_valueList[$name];
        }
		$key = key_exists(
            $this->_currentInput->getAttribute('name'), 
            $this->errorList
        );
		if ($this->_inputError && $key) {
			$parent = $this->_currentInput->parentNode;
			$this->_addClass($parent, 'input_error');
			$errorNode = $this->_searchErrorTag();
			if ($errorNode) {
				$convertType = $errorNode->getAttribute('convert');
				if (!$convertType) {
					//continue;//???????
				}
				$errorCode = '';
				foreach ($this->errorList[$name] as $code) {
					$errorCode .= " {;$code;} ";
				}
				$innerHtml      = $errorNode->nodeValue;
				$nodes          = $errorNode->childNodes;
				$attributeList  = $errorNode->attributes;
				$parent         = $errorNode->parentNode;
				$new            = $this->_xml->createElement(
                    $convertType, $innerHtml . $errorCode
                );
				foreach ($nodes as $nod) {
					if ($nod->nodeType == 3) {
						continue;
					}
					$new->appendChild($nod);
				}
				foreach ($attributeList as $attribute) {
					if ($attribute->name === 'convert') {
						continue;
					}
					$new->setAttribute($attribute->name, $attribute->value);
				}
				$parent->appendChild($new);
			}
		}
	}
	/**
     * check that input is a dynamic input
     * return TRUE if is a dynamic
	 * @return boolean
	 * @uses Forms_Form::$_currentInput
	 * @uses Core_Xml::getAttribute()
	 */
	protected function _checkDynamic()
	{
		if (preg_match('#^[\p{L}\\d_-]+\[\]$#iu', 
				$this->_currentInput->getAttribute('name')
			)
		) {
			return TRUE;
		}
		return FALSE;
	}
}
?>