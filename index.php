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
		<?php
		require_once 'Core/Xml.php';
        require_once 'Validator/Simple.php';
		require_once 'Forms/Form.php';
		$default_array = array(
//			'inputę1' => array(
//				array('value' => 'asdfasdas'),
//				array('value' => 'asdfasdas 2')
//			),
			'input1'	=> array('value' => 'asdfasdas'),
			'input2'	=> array('value' => 'ddddddddddddd1'),
			'input5'	=> array('value' => 34),
			'chka'		=> array('checked' => 'checked'),
			'rada'		=> array(
				array('class' => 'first'),
				array('class' => 'second', 'checked' => 'checked'),
				array('class' => 'last')
			)
		);
		$form = new Forms_Form('form_definition', $default_array);
		if ($_POST['incoming_form']) {
			$bool = $form->valid($_POST);
			if (!$bool) {
				echo '<pre>';
				var_dump($form->errorList);
				echo '</pre>';
			}
			//przetworzenie danych
			//uruchomienie metody add lub edit lub jakiejs innej
			//metody zwracaja kompletne zapytania do uzycia w obiektach odpowiednich baz danych
			//lub jako parametr jakiej ma uzyc metody bazy, bazy itp
		}
		var_dump($_POST);
		?>
		<fieldset class="baza">
			<legend>
				test form
			</legend>
		<?php
		echo $form->displayForm();
		?>
		</fieldset>
		<script type="text/javascript" src="jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="js.js"></script>
    </body>
</html>