<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class UserModel extends Database {
    public function getUsers($limit) {
      return $this->select("SELECT * FROM EMP ORDER BY EMPNO");
    }

    public function addUser($firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status){
      // insert records to users table
      $this->insert("INSERT INTO customer VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status);
    }
  }
?>