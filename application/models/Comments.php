<?php

class Comments extends Zend_Db_Table
{
 	protected $_name = 'comments';
	
	
	public function getByPostId($postId)
    {
        $postId = intval($postId);
		
        $row = $this->fetchAll('post_id = ' . $postId);
        if (!$row) {
            throw new Exception('Fail');
        }
        return $row->toArray();
    }

	
    public function add($postId, $email_id, $comment)
    {
        $postId = intval($postId);
        $data = array(
            'post_id' => $postId,
            'email_id' => $email_id,
            'blog_comment' => $comment
        );
        $this->insert($data);
    }
}
?>