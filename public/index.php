<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('IMAGES_PATH')
    || define('IMAGES_PATH', realpath(dirname(__FILE__) ));
/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Config/Ini.php';

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV,
            array('allowModifications'=>true));

$application = new Zend_Application(
    APPLICATION_ENV,
	$config
);

$application->bootstrap()->run();