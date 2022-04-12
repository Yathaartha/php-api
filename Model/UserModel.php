<?php
  require_once PROJECT_ROOT_PATH . "/php-apis/Model/Database.php";

  class UserModel extends Database {
    public function getUsers($limit) {
      return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function addUser($user_name, $user_mail, $user_status){
      // insert records to users table
      $this->insert("INSERT INTO users VALUES (NULL, ?, ?, ?)", $user_name, $user_mail, $user_status);
    }
  }
?>