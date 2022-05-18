<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class CategoryModel extends Database {
    public function getCategories() {
      return $this->selectAll("SELECT * FROM CATEGORY");
    }
  }
?>