<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ShopModel extends Database {
    public function getShops() {
      return $this->selectAll("SELECT * FROM SHOP");
    }
    
    public function getShopById($shopId) {
      return $this->selectById("SELECT * FROM SHOP WHERE SHOPID = :id", $shopId);
    }

    public function addShop($shopname, $shopdescription, $shopimage, $bannerimage, $trader) {
      $shopimage = "http://localhost:1000/php-api/assets/images/" . $shopimage;
      $bannerimage = "http://localhost:1000/php-api/assets/images/" . $bannerimage;
      return $this->insertShop("INSERT INTO SHOP VALUES (null, :shopname, :shopdescription, :shopimage, :bannerimage, 'active', :traderid)", $shopname, $shopdescription, $shopimage, $bannerimage, $trader);
    }
  }
?>