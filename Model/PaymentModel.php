<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class PaymentModel extends Database {
    public function getPayments($customerId){
      return $this->selectById("SELECT * FROM PAYMENT WHERE CUSTOMER = :id", $customerId);
    }

    public function addPayment($customerId, $orderId, $total, $paydate){
      return $this->insertPayment("INSERT INTO PAYMENT VALUES (null, :id, :orderid, :total, TO_DATE(:paydate, 'MM/DD/YYYY'))", $customerId, $orderId, $total, $paydate);
    }
  }
?>