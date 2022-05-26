<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class ProductModel extends Database {
    public function getProducts($limit) {
      return $this->select("SELECT * FROM product where rownum BETWEEN 1 AND :limit", intval($limit)); 
    }

    public function getProduct($productId) {
      return $this->selectById("SELECT * FROM product where PRODUCTID = :id", $productId); 
    }

    public function getOfferProduct() {
      return $this->selectAll("SELECT * FROM PRODUCT where OFFER IS NOT NULL");
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
      if(strlen($image) < 50){
        $image = "http://localhost:1000/php-api/assets/images/" . $image;
      }
      if($offer != null){
        return $this->insertProduct("INSERT INTO PRODUCT VALUES (null, :name, :description, :price, :image, :stock, 'Active', 'false', 'false', 'false', :shop, :category, :offer)", $name, $description, $price, $image, $stock, $shop, $category, $offer);
      }else{
        return $this->insertProduct("INSERT INTO PRODUCT VALUES (null, :name, :description, :price, :image, :stock, 'Active', 'false', 'false', 'false', :shop, :category, NULL)", $name, $description, $price, $image, $stock, $shop, $category, $offer);
      }
    }

    public function editProduct($name, $price, $description, $image, $stock, $shop, $category, $offer, $productId){
      // insert records to users table
      if(strlen($image) < 50){
        $image = "http://localhost:1000/php-api/assets/images/" . $image;
      }
      return $this->updateProduct("UPDATE PRODUCT SET PRODUCTNAME = :name, DESCRIPTION = :description, PRICE = :price, IMAGE = :image, STOCK = :stock, STATUS = 'Active', SHOP = :shop, CATEGORY = :category, OFFER = :offer WHERE PRODUCTID = :id", $name, $description, $price, $image, $stock, $shop, $category, $offer, $productId);
    }

    public function getProductByShop($id){
      return $this->selectById("SELECT * FROM product where SHOP = :id", intval($id)); 
    }

    public function deleteProduct($id){
      return $this->selectById("DELETE FROM product where PRODUCTID = :id", intval($id)); 
    }
  }
?>