<?php
/**
 * LoginForm
 */
class LoginForm extends Zend_Form {
   
    public function init() {

        $username = $this->createElement('text', 'email', array(
                            'label' => 'Email:',
                            'required' => TRUE
        ));

        $password = $this->createElement('password', 'password', array(
                            'label' => 'Password:',
                            'required' => TRUE
        ));

        $signin = $this->createElement('submit', 'SignIn', array(
                            'label' => 'Sign In'
        ));

        $this->addElements(array(
                    $username,
                    $password,
                    $signin
        ));

    }
}