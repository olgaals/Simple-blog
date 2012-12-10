<?php
	class PostsForm extends Zend_Form
{

    public function init()
    {

	 $email_id = new Zend_Form_Element_Hidden('email_id');
	 $email_id->addFilter('Int');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
                ->setRequired(true)
                ->setAttrib("maxLength", 100)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
				->setOptions(array('class' => 'f_ttl'));
				
		$post = new Zend_Form_Element_Textarea('post');
        $post->setLabel('Post')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
               	->setOptions(array('class' => 'f_post'));		
		
		
		/*$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
		$image = new Zend_Form_Element_File('image');

		$image->setLabel('Image')
				->addValidator('Count', false, 1)
				->addValidator('Size', false, 102400)
				->addValidator('Extension', false, 'jpg,png,gif');
				//->setAttrib(�label�, �submitbutton�)
				//->setDestination(realpath($config->path->posts->images));*/

        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        // Добавдение всех элементов в форму
        $this->addElements(array($email_id, $title, $post, $submit));
    }


}
?>