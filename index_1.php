<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Form test</title>
		<link href="meyer_reset_css.css" rel="stylesheet" type="text/css" />
		<link href="960_24_col.css" rel="stylesheet" type="text/css" />
		<link href="styl2.css" rel="stylesheet" type="text/css" />
        <link href="css/custom-theme/jquery-ui-1.8.24.custom.css" rel="stylesheet" type="text/css" />
		<link href="shCore.css" rel="stylesheet" type="text/css" />
		<link href="shThemeDefault.css" rel="stylesheet" type="text/css" />
		<!--[if IE]>
		  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>
    <body>
        <script>
            var selectedExample = null;
        </script>
        <header>
            <h1>
                Blue Form Generator
            </h1>
        </header>
        <?php
        define('CORE_PARAM_SEPARATOR', '::');
		require_once 'Core/Xml.php';
        require_once 'Validator/Simple.php';
		require_once 'Forms/Form.php';
        ?>
        <section id="main_content">
            <div id="tabs">
                <nav>
                    <ul>
                        <li>
                            <a href="#tab1">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#tab2">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="#tab3">
                                Examples
                            </a>
                        </li>
                        <li>
                            <a href="#tab4">
                                Contact
                            </a>
                        </li>
                    </ul>
                </nav>
                <div id="tab1">
                    <h2>
                        Form Generator library, based on xml definition file.
                    </h2>
                    <!--
                    ogolny opis biblioteki
                    jakies screeny z przykladami
                    -->
                    <a class="download" href="download.php">
                        Download
                        <br>
                        <span>
                            Version: 0.16.2
                        </span>
                    </a>
                    <div class="license">
                        <h2>
                            Software is based on WTFPL license
                        </h2>
                            <pre>           
DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                   Version 2, December 2004

Copyright (C) 2004 Sam Hocevar &lt;sam@hocevar.net&gt;

Everyone is permitted to copy and distribute verbatim or modified
copies of this license document, and changing it is allowed as long
as the name is changed.

           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

 0. You just DO WHAT THE FUCK YOU WANT TO.
</pre>
                    </div>
                </div>
                <div id="tab2">
                    <div id="doc_accordion">
                        <h3>
                            <a href="#">
                                Required files
                            </a>
                        </h3>
                        <div>
                            <h4>
                                There are few files required to use Forms package:
                            </h4>
                            <ul>
                                <li>
                                   Forms/Form.php - main Form class 
                                </li>
                                <li>
                                    Core/Xml.php - used to maniplulate xml 
                                    files (extends DOMDocument)
                                </li>
                                <li>
                                    Validator/Simple.php - library to 
                                    validate inputs
                                </li>
                                <li>
                                    some xml file with input definition 
                                    (xml/some_definition.xml)
                                </li>
                            </ul>
                            <p class="info">
                                All libraries don't has any private methods 
                                or properties and can be extended to use in 
                                different ways.
                            </p>
                            <a href="download.php" class="download">
                                Download
                                <br/>
                                <span>
                                    Version: 0.16.2
                                </span>
                            </a>
                        </div>
                        <h3>
                            <a href="#">
                                Base usage
                            </a>
                        </h3>
                        <div>
                            <h4>
                                Implementation of main files:
                            </h4>
                            <code>
                                <pre class="brush: php">
    <&quest;php
    define('CORE_PARAM_SEPARATOR', '::');
    require_once 'Core/Xml.php';
    require_once 'Validator/Simple.php';
    require_once 'Forms/Form.php';
    &quest;></pre>
                            </code>
                            <p class="info">
                                CORE_PARAM_SEPARATOR is constant that is used in 
                                some attributes, that can contains more than one
                                value.
                            </p>
                            <h4>
                                Starting of libary:
                            </h4>
                            <code>
                                <pre class="brush: php">
    $form = new Forms_Form('some_definition');</pre>
                            </code>
                            <span>
                                Create Form object with xml definition.
                                <br/><br/>
                                Can have second parameter with array of definitions.
                                Described in next step.
                            </span>
                            <code>
                                <pre class="brush: php">
    echo $form->displayForm();</pre>
                            </code>
                            <span>
                                Display complete form.
                            </span>
                            <code>
                                <pre class="brush: php">
    $form->valid($_POST);</pre>
                            </code>
                            <span>
                                Method valid() validate the form with given array.
                                Method returns boolean information about validation 
                                progress.
                                <br/>
                                FALSE form has some errors, TRUE form ok
                            </span>
                            <code>
                                <pre class="brush: php">
    $form->errorList;</pre>
                            </code>
                            <span>
                                Contains informations about input errors.
                            </span>
                            <code>
                                <pre class="brush: php">
array(10) {
    ["input4"]=>
      array(2) {
        [0]=>
        string(8) "required"
        [1]=>
        string(7) "pattern"
      }
}</pre>
                            </code>
                            <span>
                                Example errorList data
                            </span>
                            <h4>
                                Full example:
                            </h4>
                            <code>
                                <pre class="brush: php">
    <&quest;php
    $form = new Forms_Form('form_definition');
    if (!empty($_POST)) {
        $bool = $form->valid($_POST);
        if ($bool) {
            echo 'Form validated ok';
        } else {
            var_dump($form->errorList);
        }
    }
    &quest;></pre>
                            </code>
                        </div>
                        <h3>
                            <a href="#">
                                Base usage with predefined elements
                            </a>
                        </h3>
                        <div>
                            <p>
                                Every input attribute can be changed by list definition
                                given in Form constructor as second parameter.
                                <br/>
                                List definition can also create dynamic inputs by 
                                cloning defined in xml file element, each next element 
                                must have declaration in array. If you want 5
                                dynamic input you must declare in array 5 elements.
                                <br/>
                            </p>
                            <p class="info">
                                You can't create new inputs by that list definition.
                                All elements must be declare in xml file. 
                            </p>
                            <code>
                                <pre class="brush: php">
    $definition = array(
        'input1'	=> array('value' => 'some value'),
        'input2'	=> array(
            'value' => 'other value',
            'class' => 'input_class'
        ),
        'checkbox'    => array(
            'checked' => 'checked',
            'class'   => 'chka_class',
            'required'=> 'required'
        ),
        'input3'    => array(
            'disabled'   => 'disabled'
        )
    }
    $form = new Forms_Form('form_definition', $definition);</pre>
                            </code>
                            <span>
                                Override attributes given in xml definition.
                            </span>
                            <code>
                                <pre class="brush: php">
    $definition = array(
        'dynamic_input' => array(
            array(
                'value'     => '1',
                'id'        => 'dynamic_input_1'
            ),
            array(
                'value'     => '2',
                'id'        => 'dynamic_input_2'
            ),
            array(
                'value'     => '3',
                'id'        => 'dynamic_input_3'
            )
        )
    }
    $form = new Forms_Form('form_definition', $definition);</pre>
                            </code>
                            <span>
                                Create 3 dynamic inputs with given values and id.
                            </span>
                        </div>
                        <h3>
                            <a href="#">
                                Build xml definition
                            </a>
                        </h3>
                        <div>
                            <p>
                                In xml file you can create complete form code,
                                including all html elements that form will have.
                                Error containers, some descriptions and others 
                                needed in structure elements.
                                <br/>
                                Xml library process only inputs elements, 
                                and special blocks for errors.
                            </p>
                            <h4>
                                Base usage:
                            </h4>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;p&gt;
                &ltlabel&gt;
                    Base form
                &lt/label&gt;
                &lt;input type="text" name="first" required="required" valid_type="string"/&gt
                &lt;input type="text" name="second" required="required" valid_type="integer"/&gt
            &lt;/p&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                            <span>
                                Base form definition, working wits 2 inputs.<br/>
                                First input validate string, next numbers.
                            </span>
                            <h4>
                                With error information
                            </h4>
                            <div class="info">
                                Error element for input must consist from input name
                                with _error (&lt;input_name_error&gt;) and attribute 
                                that indicate type of element to be node converted.
                                In example convert="span" node will be converted
                                in span element.
                                <br/>
                                Error node can contains other html nodes.
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;p&gt;
                &ltlabel&gt;
                    Base form
                &lt/label&gt;
                &lt;input type="text" name="first" required="required" valid_type="string"/&gt
                &lt;input type="text" name="second" required="required" valid_type="integer"/&gt
                &lt;first_error convert="span"&gt;Error from first input&lt;/first_error&gt;
                &lt;second_error convert="span"&gt;Error from second input&lt;/second_error&gt;
            &lt;/p&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                            <span>
                                Error node will be contained special element
                                with error information like {;error_code;}.
                            </span>
                            <h4>
                                Dynamic checkbox
                            </h4>
                            <div class="info">
                                Must have special hidden input with name of input 
                                with _jsonData (main_input_jsonData), to check 
                                witch input must be selected when will be again 
                                displayed.
                            </div>
                            <div class="info">
                                Used in dynamic checkbox and radio buttons.
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;label&gt;
                dynamic checkbox
            &lt;/label&gt;
            &lt;input type="checkbox" height="20" width="7" name="chk[]" size="20" 
                value="1" id="" style="" class="" min="1" max="10"
            /&gt;
            &lt;input type="hidden" name="chk_jsonData" value="1"/&gt;
            &lt;chk_error convert="span"&gt;
                checkbox error
            &lt;/chk_error&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                        </div>
                        <h3>
                            <a href="#">
                                Forms_Form options
                            </a>
                        </h3>
                        <div>
                            <p>
                                User has possibility to configure library by giving
                                in constructor array of options.
                            </p>
                            <code>
                                <pre class="brush: php">
    $form = new Forms_Form('some_definition', $listDefinition, $optionsArray);</pre>
                            </code>
                            <span>
                                Adding options to library.
                            </span>
                            <code>
                                <pre class="brush: php">
    $optionsArray = array(
        'input_error_class'         => 'inputError',
        'input_parent_error_class'  => 'input_error',
        'form_error_class'          => 'form_error',
        'attributes_to_hide'        => array(),
        'use_error_node'            => TRUE,
        'pattern_symbol'            => '#',
        'validation_class'          => 'Validator_Simple'
    );</pre>
                            </code>
                            <span>
                                Options Array
                            </span>
                            <h4>
                                Options description:
                            </h4>
                            <ul>
                                <li>
                                    input_error_class - name of css class added 
                                    to input with error
                                </li>
                                <li>
                                    input_parent_error_class - name of css class
                                    added to input (with error) parent node
                                </li>
                                <li>
                                    form_error_class - name of css class added to
                                    form element when was an error
                                </li>
                                <li>
                                    attributes_to_hide - array of input attributes
                                    taht wont be displayed on form output
                                </li>
                                <li>
                                    use_error_node - if set to TRUE uses special 
                                    nodes for input error information
                                </li>
                                <li>
                                    pattern_symbol - char used to create preg_match
                                    valid pattern
                                </li>
                                <li>
                                    validation_class - name of class to be used 
                                    for validation. Factory method witch choose
                                    specific methods to validate
                                </li>
                            </ul>
                        </div>
                        <h3>
                            <a href="#">
                                Attributes
                            </a>
                        </h3>
                        <div>
                            <h4>
                                Input attributes description:
                            </h4>
                            <ul>
                                <li>
                                    maxlength - maximum given characters in value
                                </li>
                                <li>
                                    name - name of input, most important attribute
                                    each input is detected by this attribute value.
                                    if name has [] chars is defined as dynamic input.
                                    (name="input", name="dynamic[]")
                                </li>
                                <li>
                                    pattern - you can give regular expression 
                                    pattern to check value. Overrides other validation
                                    informations.
                                    (#[A-z]+#)
                                </li>
                                <li>
                                    required - input must be filled with some value, 
                                    or be checked is a radio or checkbox, or selected
                                    if is a select. if required attribute must have 
                                    "required" value.
                                </li>
                                <li>
                                    step - number step value
                                </li>
                                <li>
                                    value - input value
                                </li>
                                <li>
                                    minlength - minimum length of given chars
                                </li>
                                <li>
                                    valid_type - code with validation type of input.
                                    <div class="info">
                                        <div class="info">
                                            all codes used in Validator_Simple library
                                        </div>
                                        Example:
                                        <ul>
                                            <li>
                                                string - '#^[\p{L}]*$#u'
                                            </li>
                                            <li>
                                                'letters' - '#^[\p{L} _ ,.-]*$#u'
                                            </li>
                                            <li>
                                                'integer' - '#^[\\d]*$#',
                                            </li>
                                            <li>
                                                'num_chars' - '#^[\p{L}\\d\\.,_-]*$#u',
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    valid_dependency - dependencies from other inputs.
                                    as value you give other input name. If input 
                                    with valid_dependency set up is filled, input
                                    given in valid_dependency must be filled.
                                    <div class="info">
                                        You can add more than one field, separated 
                                        by given in constructor value separator
                                    </div>
                                </li>
                                <li>
                                    check_field - check value with other input.
                                    Basic used in define password on register
                                    form. First element is other input name, second
                                    is 0 or 1 that define error type. If is set to 1
                                    and values are same will return check_field_true
                                    error, if different no error. If is set to 0
                                    and fields are different will return check_field_false
                                    error, if same no error.
                                </li>
                                <li>
                                    escape - if set to TRUE value first use 
                                    mysqli_escape_string function on value, 
                                    then check their length
                                </li>
                                <li>
                                    entities - if set to TRUE value first use 
                                    htmlentities function on value, 
                                    then check their length
                                </li>
                                <li>
                                    max - used in numeric inputs to check maximum
                                    range of numeric field.<br/>
                                    (color as hex - #ffffff, date - 2012-12-12, 
                                    datetime - 2011-12-05 18:54)
                                </li>
                                <li>
                                    min - used in numeric inputs to check minimum
                                    range of numeric field.<br/>
                                    (color as hex - #ffffff, date - 2012-12-12, 
                                    datetime - 2011-12-05 18:54)
                                </li>
                                <li>
                                    other_val - name of method to return value.
                                    Example from databese or session.
                                </li>
                                <li>
                                    type - define type of input with HTML5. 
                                    Used in validation. If type is emial, check 
                                    if field is valid emial, if color check color
                                    given in hex format (#ffffff)
                                </li>
                            </ul>
                            <h4>
                                Form attributes description:
                            </h4>
                            <ul>
                                <li>
                                    novalidate - if attribute has value 
                                    novalidate="novalidate" all inputs in form 
                                    will be not validated
                                </li>
                            </ul>
                            <h4>
                                Error nodes attributes description:
                            </h4>
                            <ul>
                                <li>
                                    convert - type of node that node will be converted
                                </li>
                            </ul>
                        </div>
                        <h3>
                            <a href="#">
                                Dynamic inputs
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Errors description
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Usage of error elements
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                    </div>
                </div>
                <div id="tab3">
                    <div id="ex_accordion">
                        <h3>
                            <a href="#">
                                Base Example
                            </a>
                        </h3>
                        <div>
                            <?php 
                            $baseForm = new Forms_Form('base_example');
                            if (isset($_POST['form_type']) && $_POST['form_type'] === 'base_example') {
                                echo '<script>selectedExample = \'base_example\'</script>';
                                $bool = $baseForm->valid($_POST);
                                if (!$bool) {
                                    echo '<code><pre>';
                                    var_dump($baseForm->errorList);
                                    echo '</pre></code><span>list of errors</span>';
                                } else {
                                    echo '<div class="ok">
                                        form ok
                                    </div>';
                                }
                            }?>
                            <fieldset class="baza">
                                <legend>
                                    Base Example
                                </legend>
                                <?php
                                echo $baseForm->displayForm();
                                ?>
                            </fieldset>
                            <div class="button" rel="php_block">
                                Show PHP code
                            </div>
                            <div class="php_block">
                                <code>
                                    <pre class="brush: php">
    $baseForm = new Forms_Form('base_example');
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'base_example') {
        $bool = $baseForm->valid($_POST);
        if (!$bool) {
            echo '&lt;code&gt;&lt;pre&gt;';
            var_dump($baseForm->errorList);
            echo '&lt;/pre&gt;&lt;/code&gt;';
        } 
    }
    echo $baseForm->displayForm();</pre>
                                </code>
                                <span>
                                    php code
                                </span>
                            </div>
                            <div class="button" rel="xml_block">
                                Show XML code
                            </div>
                            <div class="xml_block">
                                <code>
                                    <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
    &lt;form method="post" action="" accept-charset="utf-8" target="_self"&gt;
        &lt;p&gt;
            &lt;input type="hidden" name="form_type" value="base_example"/&gt;
            &lt;label&gt;
                text input
            &lt;/label&gt;
            &lt;input type="text" name="input1" placeholder="Enter some text" 
                required="required" value="" minlength="2" valid_type="string" 
            /&gt;
            &lt;input1_error convert="span"&gt;Input 1 Error&lt;/input1_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;label&gt;
                number input
            &lt;/label&gt;
            &lt;input type="number" name="input2" placeholder="Enter some numbers" 
                required="required" value="" minlength="2" valid_type="integer" 
                max="50" maxlength="20" min="-50"
            /&gt;
            &lt;input2_error convert="span"&gt;Input 2 Error&lt;/input2_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;input type="submit" value="submit"/&gt;
        &lt;/p&gt;
    &lt;/form&gt;
                                    </pre>
                                </code>
                                <span>
                                    xml code
                                </span>
                            </div>
                        </div>
                        <h3>
                            <a href="#">
                                Login Form
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Register Form
                            </a>
                        </h3>
                        <div>
                            <?php 
                            $registerForm = new Forms_Form('register_form');
                            if (isset($_POST['form_type']) && $_POST['form_type'] === 'register_form') {
                                echo '<script>selectedExample = \'register_form\'</script>';
                                $bool = $registerForm->valid($_POST);
                                if (!$bool) {
                                    echo '<code><pre>';
                                    var_dump($registerForm->errorList);
                                    echo '</pre></code><span>list of errors</span>';
                                } else {
                                    echo '<div class="ok">
                                        form ok
                                    </div>';
                                }
                            }?>
                            <fieldset class="baza">
                                <legend>
                                    Register Form Example
                                </legend>
                                <?php
                                echo $registerForm->displayForm();
                                ?>
                            </fieldset>
                            <div class="button" rel="php_block">
                                Show PHP code
                            </div>
                            <div class="php_block">
                                <code>
                                    <pre class="brush: php">
    $registerForm = new Forms_Form('register_form');
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'register_form') {
        $bool = $registerForm->valid($_POST);
        if (!$bool) {
            echo '&lt;code&gt;&lt;pre&gt;';
            var_dump($registerForm->errorList);
            echo '&lt;/pre&gt;&lt;/code&gt;';
        } 
    }
    echo $registerForm->displayForm();</pre>
                                </code>
                                <span>
                                    php code
                                </span>
                            </div>
                            <div class="button" rel="xml_block">
                                Show XML code
                            </div>
                            <div class="xml_block">
                                <code>
                                    <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
    &lt;form method="post" action="" accept-charset="utf-8" target="_self"&gt;
        &lt;p&gt;
            &lt;input type="hidden" name="form_type" value="base_example"/&gt;
            &lt;label&gt;
                text input
            &lt;/label&gt;
            &lt;input type="text" name="input1" placeholder="Enter some text" 
                required="required" value="" minlength="2" valid_type="string" 
            /&gt;
            &lt;input1_error convert="span"&gt;Input 1 Error&lt;/input1_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;label&gt;
                number input
            &lt;/label&gt;
            &lt;input type="number" name="input2" placeholder="Enter some numbers" 
                required="required" value="" minlength="2" valid_type="integer" 
                max="50" maxlength="20" min="-50"
            /&gt;
            &lt;input2_error convert="span"&gt;Input 2 Error&lt;/input2_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;input type="submit" value="submit"/&gt;
        &lt;/p&gt;
    &lt;/form&gt;
                                    </pre>
                                </code>
                                <span>
                                    xml code
                                </span>
                            </div>
                        </div>
                        <h3>
                            <a href="#">
                                Dependencies
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Other input types
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Dynamic Inputs
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Dynamic Inputs with list definition
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                        <h3>
                            <a href="#">
                                Using Ajax
                            </a>
                        </h3>
                        <div>
                            
                        </div>
                    </div>
                </div>
                <div id="tab4">
                    
                </div>
            </div>
        </section>
        <footer>
            
        </footer>
		<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jquery-ui-1.8.24.custom.min.js"></script>
		<script type="text/javascript" src="XRegExp.js"></script>
		<script type="text/javascript" src="shCore.js"></script>
		<script type="text/javascript" src="shBrushPhp.js"></script>
		<script type="text/javascript" src="shBrushXml.js"></script>
		<script type="text/javascript" src="js2.js"></script>
        <a href="https://github.com/chajr/Form-Generator">
            <img style="position: absolute; top: 0; right: 0; border: 0;" 
                 src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png" 
                 alt="Fork me on GitHub"
            />
        </a>
    </body>
</html>