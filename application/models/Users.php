<?php
class Users extends Zend_Db_Table
{
    protected $_name = 'users';
	
	function checkUnique($email)
    {
        $select = $this->_db->select()
                            ->from($this->_name,array('email'))
                            ->where('email=?',$email);
        $result = $this->getAdapter()->fetchOne($select);
        if($result){
            return true;
        }
        return false;
    }
}
?>