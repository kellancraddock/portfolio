<?php

//Error Reporting

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

//Modify include path to library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '../library');

//Define upload directory
define('UPLOAD_PATH', '/Applications/MAMP/htdocs/repositories/portfolio/public/uploads/');

//Zend Framework Includes
require_once "Zend/Loader.php";

Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Config');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_DB_Table_Abstract');
Zend_Loader::loadClass('Zend_Controller_Action_Helper_Abstract');
Zend_Loader::loadClass('Zend_Controller_Action_HelperBroker');
Zend_Loader::loadClass('Zend_View_Helper_Abstract');
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Session');
Zend_Loader::loadClass('Zend_Session_Namespace');
Zend_Loader::loadClass('Zend_File_Transfer_Adapter_Http');
Zend_Loader::loadClass('Zend_Layout');

//StartMVC
$mvc_options = array(
    'layout'     => 'default',
    'layoutPath' => '../app/views/layouts',
);
$layout = Zend_Layout::startMvc($mvc_options);

//Set up DB factory Config
$config = new Zend_Config(
	array(
		'database' => array(
			'adapter' => 'Mysqli',
			'params' => array(
				'host' => 'localhost',
				'dbname' => 'portfolio',
				'username' => 'root',
				'password' => 'root',
			)
		)
	)
);

//Start Session
Zend_Session::start();

//Set Database
$db = Zend_Db::factory( $config->database );
Zend_DB_Table_Abstract::setDefaultAdapter($db);

//Register Helpers with Brokers
Zend_Controller_Action_HelperBroker::addPath('../app/helpers/actions', 'Helper_');

//Set View Helpers
$view = new Zend_View();
$view->addHelperPath('../app/helpers/views/', 'View_Helper_');			
$renderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
$renderer->setView($view);

//Get Front Controller
$front = Zend_Controller_Front::getInstance();

//Set Controllers
$front->setControllerDirectory('../app/controllers');
$front->throwExceptions(true);
$front->dispatch();
?>