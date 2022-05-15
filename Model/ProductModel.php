<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ProductModel extends Database {
    public function getProducts($limit) {
      return $this->select("SELECT * FROM product ORDER BY productid");
    }

    public function addProduct($firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status){
      // insert records to users table
      return $this->insert("INSERT INTO CUSTOMER VALUES (sq_customer.NEXTVAL, :firstname, :lastname, :username, :address, :phone, :email, :password, :image, :status )", $firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status);
    }
  }
?>