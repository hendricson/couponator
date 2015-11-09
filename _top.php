<?php
  
if (!defined("PATH_SEPARATOR"))
{
    define("PATH_SEPARATOR", getenv("COMSPEC")? ";" : ":");
}
define('CLASS_PATH', '/includes/classes/');

ini_set("include_path", '.'.PATH_SEPARATOR.dirname(__FILE__) . '/siteadmin/'.CLASS_PATH.PATH_SEPARATOR.dirname(__FILE__) . '/siteadmin/'.CLASS_PATH.'Model/Pear');

date_default_timezone_set("Europe/London");
define('NOW_TIME', time());

/** Init Libs */
include_once 'siteadmin/includes/config/main.php';
include_once 'siteadmin/includes/libs/functions.php';

ini_set('session.use_trans_sid'   ,'0');
ini_set('session.use_only_cookies','1');
ini_set('session.cookie_domain', '.'.DOMAIN);
ini_set('setting session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);

if (!empty($_REQUEST[SESSION_NAME]))
{
    session_id( $_REQUEST[SESSION_NAME] );
}

session_name(SESSION_NAME);
session_save_path(BPATH.'tmp/sessions');
if (!empty($_POST[SESSION_NAME]))
{
    session_id( $_POST[SESSION_NAME] );
}

session_start();  // Start session
if (isset($_COOKIE[SESSION_NAME]))
{
    setcookie(SESSION_NAME, $_COOKIE[SESSION_NAME], mktime() + 604800, PATH_ROOT, '.'.DOMAIN);
}

include 'Model/Pear/DB.php';
@PEAR::setErrorHandling(PEAR_ERROR_CALLBACK,'pear_error_callback');
try
{
    $glObj['gDb'] = @DB::connect(DB_TYPE.'://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME); // select db type
}
catch (Exception $exc)
{
    sc_error($exc);
}
$glObj['gDb'] -> setFetchMode(DB_FETCHMODE_ASSOC);
$glObj['gDb'] -> query('SET NAMES utf8');

$glObj['gVars'] = array();
$glObj['html'] = '';

$_SESSION['ip'] = getIP ();

if (!isset($_GET['type'])) $_GET['type'] = '';
if (!isset($_GET['mod'])) $_GET['mod'] = '';
if (!isset($_GET['what'])) $_GET['what'] = '';

$type = $_GET['type'];
$mod = $_GET['mod']; 

if (!empty($_REQUEST['limit']) && !empty($type) && !empty($mod)) $_SESSION[$type.'.'.$mod.'.limit'] = intval($_REQUEST['limit']);


?>