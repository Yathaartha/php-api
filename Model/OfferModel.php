<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class OfferModel extends Database {
    public function getOffers() {
      return $this->selectAll("SELECT * FROM OFFER");
    }

    public function addOffer($shopname, $shopdescription, $shopimage, $bannerimage, $trader) {
      $shopimage = "http://localhost:1000/php-api/assets/images/" . $shopimage;
      $bannerimage = "http://localhost:1000/php-api/assets/images/" . $bannerimage;
      return $this->insertShop("INSERT INTO SHOP VALUES (null, :shopname, :shopdescription, :shopimage, :bannerimage, 'active', :traderid)", $shopname, $shopdescription, $shopimage, $bannerimage, $trader);
    }
  }
?>