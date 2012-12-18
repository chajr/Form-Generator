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
            <!--
            dodac logo generatora i bluetree, link na strone glowna
            dodac button on top
            -->
        </header>
        <?php
        define('CORE_PARAM_SEPARATOR', '::');
		require_once 'Core/Xml.php';
        require_once 'Validator/Simple.php';
		require_once 'Forms/Form.php';
        ?>