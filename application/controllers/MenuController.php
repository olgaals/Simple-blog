<?php
class MenuController extends Zend_Controller_Action{
	
	public function postsAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index', 'class'=>'selected'));
		}else{
			$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index', 'class'=>'selected'), 
								array('label'=>'Create new post', 'controller'=>'posts', 'action'=>'create'));
		}
        
	}
	public function createAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		//$auth = Zend_Auth::getInstance();
		//if(!$auth->hasIdentity()){
			//$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index', 'class'=>'selected'));
		//}else{
			$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index'), 
								array('label'=>'Create new post', 'controller'=>'posts', 'action'=>'create', 'class'=>'selected'));
		//}
	}
	
	public function postAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index'));
		}else{
			$this->view->menu = array(array('label'=>'View posts', 'controller'=>'posts', 'action'=>'index'), 
								array('label'=>'Create new post', 'controller'=>'posts', 'action'=>'create'));
		}
        
	}
			
	public function rightAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$this->view->menu =array(array('label'=>'Log in', 'controller'=>'auth', 'action'=>'login'),
									array('label'=>'Registration', 'controller'=>'auth', 'action'=>'signup'));
		}else{
			$this->view->menu =array(array('label'=>'Logout', 'controller'=>'auth', 'action'=>'logout'));			
		}
	}
	
	public function loginAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$this->view->menu =array(array('label'=>'Log in', 'controller'=>'auth', 'action'=>'login', 'class'=>'selected'),
									array('label'=>'Registration', 'controller'=>'auth', 'action'=>'signup'));
		}
	}
	
	public function signupAction(){
		$this->_helper->viewRenderer->setResponseSegment('menu');
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()){
			$this->view->menu =array(array('label'=>'Log in', 'controller'=>'auth', 'action'=>'login'),
									array('label'=>'Registration', 'controller'=>'auth', 'action'=>'signup', 'class'=>'selected'));
		}
	}
} 
?>