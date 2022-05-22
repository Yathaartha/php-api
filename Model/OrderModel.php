<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class OrderModel extends Database {
    public function checkSlot($collectiondate, $collectiontime) {
      return $this->selectSlot("SELECT * FROM ORDERS WHERE COLLECTIONDATE = TO_DATE(:collectiondate, 'MM/DD/YYYY') AND COLLECTIONSLOT = :collectiontime", $collectiondate, $collectiontime);
    }

    public function createOrder($cartid, $orderdate, $total, $collectiondate, $collectionslot, $email){
      return $this->insertOrder("INSERT INTO ORDERS VALUES (null, :cartid, TO_DATE(:orderdate, 'MM/DD/YYYY'), :total, TO_DATE(:collectiondate, 'MM/DD/YYYY'), :collectionslot, 'pending')", $cartid, $orderdate, $total, $collectiondate, $collectionslot, $email);
    }

    public function getCartItems($id){
      return $this->selectById("SELECT * FROM CARTITEMS WHERE CART = :id", $id);
    }

    public function addItemToCart($cartId, $productId, $quantity){
      return $this->addToCart("INSERT INTO CARTITEMS VALUES (:cart, :product, :quantity)", $cartId, $productId, $quantity);
    }
  }

?>