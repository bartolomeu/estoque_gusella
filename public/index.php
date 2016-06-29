<?php

ini_set("display_errors", E_ALL);

//setlocale(LC_MONETARY,"pt_BR", "ptb"); //money_format padrão PT-BR  @TODO colocar isso no config

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

spl_autoload_register('auto_load_me');

function auto_load_me($class){
    $ar_class = explode('_', $class.'.php');
    $class_name = array_pop($ar_class);
    
    foreach ($ar_class as $key => $value) {
        $ar_class[$key]= strtolower($value);
    }
    $ar_class[]=$class_name;
    
    require('../'.implode(DIRECTORY_SEPARATOR, $ar_class));
}

$application->bootstrap()->run();