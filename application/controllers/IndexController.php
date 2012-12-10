<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {

        // action body
		$users = new Users();
	    $data = $users->fetchAll($users->select());
	    $this->view->data = $data;
		//$this->_redirect("posts/");
    }
}
?>