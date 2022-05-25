<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ProductModel extends Database {
    public function getProducts($limit) {
      return $this->select("SELECT * FROM product where rownum BETWEEN 1 AND :limit", intval($limit)); 
    }

    public function getProduct($productId) {
      return $this->getSingleProduct("SELECT * FROM product where PRODUCTID = :productid", intval($productId)); 
    }

    public function getHighlightedProducts($value, $limit){
      if($value === "featured"){
        return $this->select("SELECT * FROM (SELECT * FROM product where FEATURED = 'true') WHERE rowNum BETWEEN 1 AND :limit", intval($limit));
      }elseif($value === "best_selling"){
        return $this->select("SELECT * FROM (SELECT * FROM product where BEST_SELLING = 'true') WHERE rowNum BETWEEN 1 AND :limit", intval($limit));
      }else{
        return $this->select("SELECT * FROM (SELECT * FROM product where TOP_RATED = 'true') WHERE rowNum BETWEEN 1 AND :limit", intval($limit));
      }
    }

    public function searchProducts($searchkey) {
      $searchkey = strtoupper($searchkey);
      $searchkey = "%".$searchkey."%";
      return $this->search("SELECT * FROM product where upper(productname) like :searchkey", $searchkey); 
    }

    public function addProduct($name, $price, $description, $image, $stock, $shop, $category, $offer){
      // insert records to users table
      $image = "http://localhost:1000/php-api/assets/images/" . $image;
      if($offer != null){
        return $this->insertProduct("INSERT INTO PRODUCT VALUES (null, :name, :description, :price, :image, :stock, 'Pending', 'false', 'false', 'false', :shop, :category, :offer)", $name, $description, $price, $image, $stock, $shop, $category, $offer);
      }else{
        return $this->insertProduct("INSERT INTO PRODUCT VALUES (null, :name, :description, :price, :image, :stock, 'Pending', 'false', 'false', 'false', :shop, :category, NULL)", $name, $description, $price, $image, $stock, $shop, $category, $offer);
      }
    }

    public function getProductByShop($id){
      return $this->selectById("SELECT * FROM product where SHOP = :id", intval($id)); 
    }

    public function deleteProduct($id){
      return $this->selectById("DELETE FROM product where PRODUCTID = :id", intval($id)); 
    }
  }
?>