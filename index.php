<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Form test</title>
		<link href="meyer_reset_css.css" rel="stylesheet" type="text/css" />
		<link href="960_24_col.css" rel="stylesheet" type="text/css" />
		<link href="styl.css" rel="stylesheet" type="text/css" />
		<!--[if IE]>
		  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>
    <body>
        <script>
        var generatedForm = false;
        </script>
		<?php
        define('CORE_PARAM_SEPARATOR', '::');
		require_once 'Core/Xml.php';
        require_once 'Validator/Simple.php';
		require_once 'Forms/Form.php';
		$default_array = array(
//			'inputę1' => array(
//				array('value' => 'asdfasdas'),
//				array('value' => 'asdfasdas 2')
//			),
            'to_jest_nie_istniejacy_input' => array(
                'value' => 'nie istnieje'
            ),
			'input1'	=> array('value' => 'asdfasdas'),
			'input2'	=> array('value' => 'ddddddddddddd1'),
			'input5'	=> array('value' => 34),
			'chka'		=> array(
                'checked' => 'checked',
                'class'   => 'chka_class'
            ),
            'chkb'		=> array(
                'value'   => 'asdasd'
            ),
            //przy dynamicznych trzeba zglosic chocby puste, ale wszystkie definicje
			'rada'		=> array(
				array(
                    'class' => 'first dupa', 
                    'value' => 5,
                    //'checked' => 'checked'
                ),
				array(
                    'class' => 'second', 
                    'checked' => 'checked'
                ),
				array(
                    'class' => 'last',
                )
			),
            'input_def' => array(
                array(
                    'value'     => 'a1',
                    'id'        => 'dynamic_def_input_1'
                ),
                array(
                    'value'     => 'a2',
                    'id'        => 'dynamic_def_input_2'
                ),
                array(
                    'value'     => 'a3',
                    'id'        => 'dynamic_def_input_3'
                ),
            ),
            'rad_def' => array(
                array(
                    'value'     => 'r1',
                    'id'        => 'dynamic_rad_def_1'
                ),
                array(
                    'value'     => 'r2',
                    'id'        => 'dynamic_rad_def_2',
                    'checked'   => 'checked'
                ),
                array(
                    'value'     => 'r3',
                    'id'        => 'dynamic_rad_def_3'
                ),
            )
		);
		$form = new Forms_Form('form_definition', $default_array);
        $ok = FALSE;
		if (@$_POST['incoming_form']) {
            echo '<script>generatedForm = true;</script>';
			$bool = $form->valid($_POST);
			if (!$bool) {
				echo '<pre>';
				var_dump($form->errorList);
				echo '</pre>';
			} else {
                $ok = TRUE;
            }
			//przetworzenie danych
			//uruchomienie metody add lub edit lub jakiejs innej
			//metody zwracaja kompletne zapytania do uzycia w obiektach odpowiednich baz danych
			//lub jako parametr jakiej ma uzyc metody bazy, bazy itp
		}
		//var_dump($_POST);
        if ($ok) {?>
        <div class="ok">
            formularz wypełniony poprawnie
        </div>
        <?php } elseif (!$ok && !empty($_POST)) { ?>
        <div class="err">
            formularz zawiera błędy
        </div>
        <?php } ?>
		<fieldset class="baza">
			<legend>
				test form
			</legend>
		<?php
		echo $form->displayForm();
		?>
		</fieldset>
		<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jquery-ui-1.8.24.custom.min.js"></script>
		<script type="text/javascript" src="js.js"></script>
    </body>
</html>