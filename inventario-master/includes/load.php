<?php
// -----------------------------------------------------------------------
// START SESSION
// -----------------------------------------------------------------------
if (!isset($_SESSION)) session_start();
ob_start();

// -----------------------------------------------------------------------
// ENABLE CODE DEBUG WITH "TRUE" OR "FALSE"
// -----------------------------------------------------------------------
define('APP_DEBUG', false);
ini_set('display_errors', APP_DEBUG);
error_reporting(E_ALL | E_NOTICE | E_WARNING);

// -----------------------------------------------------------------------
// DEFINE DEFAULT TIMEZONE
// -----------------------------------------------------------------------
setlocale(LC_TIME, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Fortaleza');

// -----------------------------------------------------------------------
// DEFINE SEPERATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');

define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);


require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');
require_once(LIB_PATH_INC.'upload.php');
require_once(LIB_PATH_INC.'database.php');
require_once(LIB_PATH_INC.'sql.php');

?>
