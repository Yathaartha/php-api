<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class UserModel extends Database {
    public function addUser($firstname, $lastname, $username, $address, $phone, $email, $password){
      // insert records to users table
      return $this->insert("INSERT INTO CUSTOMER VALUES (sq_customer.NEXTVAL, :firstname, :lastname, :username, :address, :phone, :email, :password, 'http://localhost:1000/php-api/assets/images/dummy-profile.png', 'inactive' )", $firstname, $lastname, $username, $address, $phone, $email, $password);
      // $userId = $this->getToken($username, $password);
      // $this->createWishList("INSERT INTO WISHLIST VALUES (sq_wishlist.NEXTVAL, :id)", $userId['CUSTOMERID']);
    }

    public function editUser($id, $firstname, $lastname, $username, $address, $phone, $email, $password, $image){
      // insert records to users table
      $image = "http://localhost:1000/php-api/assets/images/" . $image;
      return $this->update("UPDATE CUSTOMER SET FIRSTNAME = :firstname, LASTNAME = :lastname, USERNAME = :username, ADDRESS = :address, PHONE = :phone, EMAIL = :email, PASSWORD = :password, IMAGE = :image WHERE CUSTOMERID = :id", $id, $firstname, $lastname, $username, $address, $phone, $email, $password, $image);
      // $userId = $this->getToken($username, $password);
      // $this->createWishList("INSERT INTO WISHLIST VALUES (sq_wishlist.NEXTVAL, :id)", $userId['CUSTOMERID']);
    }

    public function getCategories() {
      return $this->selectAll("SELECT * FROM CATEGORY");
    }

    public function getToken($username, $password){
      // select customer with username and password as parameters
      $response = $this->login("SELECT * FROM CUSTOMER WHERE USERNAME = :username AND PASSWORD = :password", $username, $password);
      if(count($response) > 0){
        $_SESSION['logged_user_id'] = $response[0]['CUSTOMERID'];

        $_SESSION['user_role'] = "Customer";
        
        return $response[0];
      }else{
        return "Username or password is incorrect";
      }
    }

    public function isLoggedIn(){
      if(isset($_SESSION['logged_user_id'])){
        return $_SESSION['logged_user_id'];
      }else{
        return false;
      }
    }

    public function getUser($id){
      return $this->getUserProfile("SELECT * FROM CUSTOMER WHERE CUSTOMERID = :id", $id);
    }

    public function logoutUser(){
      unset($_SESSION['logged_user_id']);
      unset($_SESSION['user_role']);
    }
  }
?>