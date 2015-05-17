<?php
require_once('Zend/Db.php');

class QuestionModel
{
    public $db;

    public function __construct()
    {
        $this->db = Zend_Registry::get('db');
    }

    public function registQuestion($user_id, $question, $photo, $comments){
        $sql = <<< SQL
insert into question(user_id, content, photo, comments) values(:USER_ID, :CONTENT, :PHOTO, :COMMENTS);
SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array('USER_ID' => $user_id, 'CONTENT' => $question, 'PHOTO' => $photo, 'COMMENTS' => $comments));

        return $this->db->lastInsertId();
    }

    public function findQuestionById($question_id){
        $sql = <<< SQL
select * from question where question_id = :QUESTION_ID;
SQL;

        return $this->db->fetchRow($sql, array('QUESTION_ID' => $question_id), Zend_Db::FETCH_OBJ);
    }
}