<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class TraderModel extends Database {
    public function addTrader($firstname, $lastname, $username, $address, $phone, $email, $salescategory,$password){
      // insert records to users table
      return $this->insert("INSERT INTO TRADER VALUES (sq_trader.NEXTVAL, :firstname, :lastname, :username, :address, :phone, :email, :salescategory, :password, 'default.png', 'inactive' )", $firstname, $lastname, $username, $address, $phone, $email, $password);
    }

    public function getToken($username, $password){
      // select customer with username and password as parameters
      $response = $this->login("SELECT * FROM TRADER WHERE USERNAME = :username AND PASSWORD = :password", $username, $password);
      if(count($response) > 0){
        $_SESSION['logged_trader_id'] = $response[0]['TRADERID'];

        $_SESSION['user_role'] = "Trader";
        
        return $response[0];
      }else{
        return "Username or password is incorrect";
      }
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