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

    public function addProduct($firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status){
      // insert records to users table
      return $this->insert("INSERT INTO CUSTOMER VALUES (sq_customer.NEXTVAL, :firstname, :lastname, :username, :address, :phone, :email, :password, :image, :status )", $firstname, $lastname, $username, $address, $phone, $email, $password, $image, $status);
    }

    public function getProductByShop($id){
      return $this->selectById("SELECT * FROM product where SHOP = :id", intval($id)); 
    }

    public function deleteProduct($id){
      return $this->selectById("DELETE FROM product where PRODUCTID = :id", intval($id)); 
    }
  }
?>