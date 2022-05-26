<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class OrderModel extends Database {
    public function checkSlot($collectiondate, $collectiontime) {
      return $this->selectSlot("SELECT * FROM ORDERS WHERE COLLECTIONDATE = TO_DATE(:collectiondate, 'MM/DD/YYYY') AND COLLECTIONSLOT = :collectiontime", $collectiondate, $collectiontime);
    }

    public function createOrder($cartid, $customerid, $orderdate, $total, $collectiondate, $collectionslot, $email){
      return $this->insertOrder("INSERT INTO ORDERS VALUES (null, :cartid, :customerid, TO_DATE(:orderdate, 'MM/DD/YYYY'), :total, TO_DATE(:collectiondate, 'MM/DD/YYYY'), :collectionslot, 'Completed')", $cartid, $customerid, $orderdate, $total, $collectiondate, $collectionslot, $email);
    }

    public function getOrder($id){
      return $this->selectById("SELECT * FROM ORDERS WHERE ORDERNO = :id", $id);
    }

    public function getCustomerOrder($id){
      return $this->selectById("SELECT * FROM ORDERS WHERE CUSTOMER = :id", $id);
    }

    public function getTraderOrder($id){
      return $this->selectById("select o.orderno, productname, ci.quantity, o.orderdate, o.collectiondate, o.status, s.shopname from orders o, cartitems ci, product p, shop s where o.cart = ci.cart and ci.product = p.productid and p.shop = s.shopid and s.shopid = :id  ORDER BY o.orderdate", $id);
    }

    public function addItemToCart($cartId, $productId, $quantity){
      return $this->addToCart("INSERT INTO CARTITEMS VALUES (:cart, :product, :quantity)", $cartId, $productId, $quantity);
    }
  }

?>