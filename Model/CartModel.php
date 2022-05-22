<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class CartModel extends Database {
    public function cartCreate($id) {
      return $this->createById("INSERT INTO CART VALUES (sq_cart.NEXTVAL, :id)", $id);
    }

    public function getCart($customerid){
      return $this->selectById("SELECT * FROM CART WHERE CUSTOMER = :id", $customerid);
    }

    public function getCartItems($id){
      return $this->selectById("SELECT * FROM CARTITEMS WHERE CART = :id", $id);
    }

    public function addItemToCart($cartId, $productId, $quantity){
      return $this->addToCart("INSERT INTO CARTITEMS VALUES (:cart, :product, :quantity)", $cartId, $productId, $quantity);
    }
  }

?>