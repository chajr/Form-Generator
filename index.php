<?php
$currentVersion = file_get_contents('Forms/Form.php');
preg_match('# \* @version [0-9\.]*\n#', $currentVersion, $version);
$version = str_replace(' * @version ', '', $version);
?>
<?php 
require_once('doc/head.php');
?>
<section id="main_content">
    <div id="tabs">
<?php
require_once('doc/nav.php');
require_once('doc/main.php');
?>
<div id="tab2">
    <div id="doc_accordion">
        <?php require_once('doc/doc/phpdoc.php'); ?>
        <?php require_once('doc/doc/files.php'); ?>
        <?php require_once('doc/doc/base.php'); ?>
        <?php require_once('doc/doc/base_predefined.php'); ?>
        <?php require_once('doc/doc/xml.php'); ?>
        <?php require_once('doc/doc/form_options.php'); ?>
        <?php require_once('doc/doc/attributes.php'); ?>
        <?php require_once('doc/doc/dynamic.php'); ?>
        <?php require_once('doc/doc/errors.php'); ?>
        <?php require_once('doc/doc/error_elements.php'); ?>
    </div>
</div>
<div id="tab3">
    <div id="ex_accordion">
        <?php require_once('doc/examples/base.php'); ?>
        <?php require_once('doc/examples/login.php'); ?>
        <?php require_once('doc/examples/register.php'); ?>
        <?php require_once('doc/examples/other.php'); ?>
    </div>
</div>
<?php
require_once('doc/bugs.php');
require_once('doc/todo.php');
require_once('doc/contact.php');
?>
    </div>
</section>
<?php
require_once('doc/foot.php');
?>