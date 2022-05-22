<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ShopModel extends Database {
    public function getShops() {
      return $this->selectAll("SELECT * FROM SHOP");
    }
  }
?>