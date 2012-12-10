<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
	function _initDB(){
		require_once 'Zend/Loader/Autoloader.php';
		$loader = Zend_Loader_Autoloader::getInstance();
		$loader->setFallbackAutoloader(true);
		
		$options = array(
			Zend_Db::AUTO_QUOTE_IDENTIFIERS => false
		);
		
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
		$params = $config->resources->db->params;
		$adapter = $config->resources->db->adapter;

		$db = Zend_Db::factory($adapter, $params);
		$db->query('SET NAMES UTF8');
		Zend_Db_Table::setDefaultAdapter($db);  
		
		$front = Zend_Controller_Front::getInstance();
		$front->setDefaultControllerName($config->resources->frontController->defaultControllerName);
		
		
	}
	

	protected function _initDoctype(){
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
}
