<?php
require_once('Zend/Db.php');

class UserModel
{
    public $db;

    public function __construct()
    {
        $this->db = Zend_Registry::get('db');
    }

    public function registUser($email){
        $sql = <<< SQL
insert into user(email, date) values(:EMAIL, current_timestamp);
select 
SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('EMAIL' => $email));

        return $this->db->lastInsertId();
    }

    public function findUserById($user_id){
        $sql = <<< SQL
select * from user where user_id = :USER_ID;
SQL;

        return $this->db->fetchRow($sql, array('USER_ID' => $user_id), Zend_Db::FETCH_OBJ);
    }
}