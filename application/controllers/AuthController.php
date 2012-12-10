<?php
class AuthController extends Zend_Controller_Action{

    public function loginAction()
    {
    	$auth = Zend_Auth::getInstance();
	    if(!$auth->hasIdentity()) {
			$users = new Users();
	        $form = new LoginForm();
	        $this->view->form = $form;
	       
	        if($this->getRequest()->isPost()){
	            if($form->isValid($_POST)){
	            	$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');	
	      			$salt = $config->password->salt;
	                $data = $form->getValues();
	                $auth = Zend_Auth::getInstance();
	                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'users');
	                $authAdapter->setIdentityColumn('email')
	                            ->setCredentialColumn('password');
	                $authAdapter->setIdentity($data['email'])
	                            ->setCredential(md5($data['password'].$salt));
	               $result = $auth->authenticate($authAdapter);
	                if($result->isValid()){
	                    $storage = new Zend_Auth_Storage_Session();
	                    $storage->write($authAdapter->getResultRowObject());
	                    $this->_redirect('auth/home');
						//$this->_redirect('posts/index');
	                } else {
	                    $this->view->errorMessage = "Invalid email or password. Please try again.";
	                }         
	            }
	        }
	    }  
	    else{
	    	$this->_redirect('auth/home');
	    }  
	    $this->view->title = "Log in";
   		$this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
   		$this->_helper->actionStack('post', 'menu');
   		$this->_helper->actionStack('login', 'menu');
    } 
    public function signupAction()
    {
    	$auth = Zend_Auth::getInstance();
    	if(!$auth->hasIdentity()) {
			$users = new Users();
	        $form = new RegistrationForm();
	        $this->view->form=$form;
	        if($this->getRequest()->isPost()){
	            if($form->isValid($_POST)){
		
	              $data = $form->getValues();
	                if($data['password'] != $data['confirmPassword']){
	                    $this->view->errorMessage = "Password and confirm password don't match.";
	                    return;
	                }
	                  if($users->checkUnique($data['email'])){
	                    $this->view->errorMessage = "You have already registred!";
	                    return;
	                }
	                unset($data['confirmPassword']);
	              
	               	$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');	
	      			$salt = $config->password->salt;
	                $data['password'] = md5($data['password'].$salt);
	                
	                $users->insert($data);
	                $this->_redirect('auth/login');
	            }
	        }
	        $this->view->authorathed = 0;
    	}
    	else {
			$this->view->authorathed = 1;
			$this->_redirect('auth/home');
		}
		
		$this->view->title = "Sign up";
   		$this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
   		$this->_helper->actionStack('post', 'menu');
   		$this->_helper->actionStack('signup', 'menu');

    } 
    public function logoutAction()
    {
		$storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('auth/login');
    }
    public function homeAction()
    {
    	if ($auth = Zend_Auth::getInstance()){
    			 $this->view->authorathed = 1;
    			 $this->view->title = "Home";
   				 $this->view->headTitle("Simple Blog | ".$this->view->title, 'PREPEND');
    	}else{
    		 $this->view->authorathed = 0;
    	}
    	
		$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('auth/login');
        }
        $this->view->email = $data->email;
        $this->_helper->actionStack('post', 'menu');
   		$this->_helper->actionStack('right', 'menu');  
    }
}
?>