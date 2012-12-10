<?php
/**
 * RegistrationForm
 */
class RegistrationForm extends Zend_Form {
   
    public function init() {
        
        $email = $this->createElement('text', 'email', array(
                            'label' => 'E-mail: *',
                            'required' => TRUE
        ));

         $password = $this->createElement('password', 'password', array(
                            'label' => 'Password: *',
                            'required' => TRUE
        ));

        $confirmPassword = $this->createElement('password', 'confirmPassword', array(
                            'label' => 'Confirm Password: *',
                            'required' => TRUE
        ));

        $register = $this->createElement('submit', 'Register', array(
                            'label' => 'Submit'
        ));

        $this->addElements(array(
                    $email,
                    $password,
                    $confirmPassword,
                    $register
        ));
    }
}