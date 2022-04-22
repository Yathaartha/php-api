<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class UserModel extends Database {
    public function getUsers($limit) {
      return $this->select("SELECT * FROM EMP ORDER BY EMPNO");
    }

    public function addUser($firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status){
      // insert records to users table
      return $this->insert("INSERT INTO CUSTOMER VALUES (4, :firstname, :lastname, :username, :address, :phone, :email, :password, :image, :status )", $firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status);
    }
  }
?>