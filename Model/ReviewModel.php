<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ReviewModel extends Database {
    public function getReviews($productId){
      return $this->selectById("SELECT * FROM REVIEW WHERE PRODUCT = :id", $productId);
    }
  }
?>