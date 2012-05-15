<?php
/**
 * you only need to include this file
 * please read example in example directory
 */
$CLASS_DIR = dirname(__FILE__);
$WEB_DIR = dirname(dirname(__FILE__));
require_once $CLASS_DIR.DIRECTORY_SEPARATOR.'config.php';
require_once $CLASS_DIR.DIRECTORY_SEPARATOR.'function.inc.php';
require_once $CLASS_DIR.DIRECTORY_SEPARATOR.'kxClient.php';
require_once $CLASS_DIR.DIRECTORY_SEPARATOR.'db.class.php';
require_once $CLASS_DIR.DIRECTORY_SEPARATOR.'kxHttpClient.php';

?>