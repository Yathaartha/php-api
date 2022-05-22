<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class OrderModel extends Database {
    public function checkSlot($collectiondate, $collectiontime) {
      return $this->selectSlot("SELECT * FROM ORDERS WHERE COLLECTIONDATE = :collectiondate AND COLLECTIONSLOT = :collectiontime", $collectiondate, $collectiontime);
    }

    public function createOrder($customerid){
      return $this->selectById("INSERT INTO ORDERS VALUES (sq_orders, :cartid, :orderdate, :collectiondate, :collectionslot, 'pending')", $customerid);
    }

    public function getCartItems($id){
      return $this->selectById("SELECT * FROM CARTITEMS WHERE CART = :id", $id);
    }

    public function addItemToCart($cartId, $productId, $quantity){
      return $this->addToCart("INSERT INTO CARTITEMS VALUES (:cart, :product, :quantity)", $cartId, $productId, $quantity);
    }
  }

?>