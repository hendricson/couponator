<?php
	//echo "_REQUEST=<pre>";print_r($_REQUEST);echo "</pre><hr>";//exit;
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
	define('IN_SITE', 1);
    include_once '_top.php';
    
    include_once 'Ctrl/Base.class.php';   
    include_once 'View/Base.class.php';
    include_once 'Ctrl/Init.class.php';

    new Ctrl_Init( $glObj, 'index' );
?>