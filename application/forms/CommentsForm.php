<?php
	class CommentsForm extends Zend_Form
{

    public function init()
    {
        // ������� ������� ������� ������� ����� ()
        $postId = new Zend_Form_Element_Hidden('postId');
        // ������������� ������ integer
        $postId->addFilter('Int');

		$email_id = new Zend_Form_Element_Hidden('email_id');
		$email_id->addFilter('Int');

        $comment = new Zend_Form_Element_Textarea('blogComment');
        $comment->setLabel('Comment')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
		->setOptions(array('class' => 'f_comment'));

		/*$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini','production');
		$image = new Zend_Form_Element_File('image');
		$image->setLabel('Image')
				->addValidator('Count', false, 1)
				->addValidator('Size', false, 102400)
				->addValidator('IsImage', false);
				//->setAttrib(�label�, �submitbutton�)
				//->setDestination(realpath($config->path->comments->images));*/
		
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        // ���������� ���� ��������� � �����
        $this->addElements(array($postId, $email_id, $comment, $submit));
    }

}

?>