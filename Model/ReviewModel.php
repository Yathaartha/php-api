<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ReviewModel extends Database {
    public function getReviews($productId){
      return $this->selectById("SELECT * FROM REVIEW WHERE PRODUCT = :id", $productId);
    }

    public function addReview($productId, $content, $rating, $customerid){
      return $this->insertReview("INSERT INTO REVIEW VALUES (null, :productid, :content, :rating, :customer, null, null, null)", $productId, $content, $rating, $customerid);
    }

    public function reportReview($reviewId, $reportReason, $customerId){
      return $this->updateReview("UPDATE REVIEW SET ISREPORTED = 'true', REPORTREASON = :reportreason, REPORTEDBY = :customer WHERE REVIEWID = :reviewid", $reviewId, $reportReason, $customerId);
    }
  }
?>