<?php
class Posts extends Zend_Db_Table{

    protected $_name = 'posts';

    public function getById($id)
    {
        $id = intval($id);
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception('Post wasn\'t selected');
        }
        return $row;
    }
	
	public function add($email_id, $title, $post)
    {
        $data = array(
            'email_id' => $email_id,
            'title' => $title,
            'blog_post' => $post
        );
        $this->insert($data);
    }
}

?>