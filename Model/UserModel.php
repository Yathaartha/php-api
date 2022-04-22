<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class UserModel extends Database {
    public function getUsers($limit) {
      return $this->select("SELECT * FROM EMP ORDER BY EMPNO");
    }

    public function addUser($user_name, $user_mail, $user_status){
      // insert records to users table
      $this->insert("INSERT INTO users VALUES (NULL, ?, ?, ?)", $user_name, $user_mail, $user_status);
    }
  }
?>