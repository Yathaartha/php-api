<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class TraderModel extends Database {
    public function addTrader($firstname, $lastname, $username, $address, $phone, $email, $salescategory, $password){
      // insert records to users table
      return $this->insertTrader("INSERT INTO TRADER VALUES (sq_trader.NEXTVAL, :firstname, :lastname, :username, :address, :phone, :email, :salescategory, :password, 'http://localhost:1000/php-api/assets/images/default.jpg', 'inactive' )", $firstname, $lastname, $username, $address, $phone, $email, $salescategory, $password);
    }

    public function editTrader($id, $firstname, $lastname, $username, $address, $phone, $email, $salescategory, $password, $image, $status){
      // insert records to users table
      if(strlen($image) < 50){
        $image = "http://localhost:1000/php-api/assets/images/" . $image;
      }
      return $this->updateTrader("UPDATE TRADER SET FIRSTNAME = :firstname, LASTNAME = :lastname, USERNAME = :username, ADDRESS = :address, PHONE = :phone, EMAIL = :email, SALESCATEGORY = :salescategory, PASSWORD = :password, IMAGE = :image, STATUS = :status WHERE TRADERID = :id", $firstname, $lastname, $username, $address, $phone, $email, $salescategory, $password, $image, $status, $id);
    }

    public function getToken($username, $password){
      // select customer with username and password as parameters
      return $this->login("SELECT * FROM TRADER WHERE USERNAME = :username AND PASSWORD = :password", $username, $password);
    }
    
    public function isTraderLoggedIn(){
      if(isset($_SESSION['logged_trader_id'])){
        return $_SESSION['logged_trader_id'];
      }else{
        return "Not Logged In";
      }
    }

    public function getTrader($id){
      return $this->selectById("SELECT * FROM TRADER WHERE TRADERID = :id", $id);
    }

    public function getTraderShops($id){
      return $this->selectById("SELECT * FROM SHOP WHERE TRADER = :id", $id);
    }

    public function logoutTrader(){
      unset($_SESSION['logged_user_id']);
      unset($_SESSION['user_role']);
    }
  }
?>