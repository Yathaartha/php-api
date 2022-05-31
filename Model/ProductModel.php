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

    public function searchProducts($searchkey, $sort, $min, $max, $rating, $category) {
      $searchkey = strtoupper($searchkey);
      $searchkey = "%".$searchkey."%";
      if($sort === ""){
        if($min != "" && $max != ""){
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and RATING >= :rating and category = :category", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max and rating >= :rating", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and category = :category", $searchkey, intval($min), intval($max), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max", $searchkey, $min, $max, $rating, $category);
            }
          }
        }else{
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM product where UPPER(NAME) LIKE :searchkey and RATING >= :rating", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and rating >= :rating", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM product where UPPER(NAME) LIKE :searchkey", $searchkey, $min, $max, $rating, $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey", $searchkey, $min, $max, $rating, $category);
            }
          }
        }
      }elseif($sort === "high"){
        if($min != "" && $max != ""){
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and RATING >= :rating and category = :category", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max and rating >= :rating order by price desc", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and category = :category) ORDER BY PRICE DESC", $searchkey, intval($min), intval($max), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max order by price desc", $searchkey, $min, $max, $rating, $category);
            }
          }
        }else{
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and RATING >= :rating and category = :category) ORDER BY PRICE DESC", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and rating >= :rating order by price desc", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and category = :category) ORDER BY PRICE DESC", $searchkey, $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey order by price desc", $searchkey, $min, $max, $rating, $category);
            }
          }
        }
      }elseif($sort === "low"){
        if($min != "" && $max != ""){
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and RATING >= :rating and category = :category) ORDER BY PRICE ASC", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max and rating >= :rating order by price asc", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and PRICE BETWEEN :min and :max and category = :category) ORDER BY PRICE ASC", $searchkey, intval($min), intval($max), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and price between :min and :max order by price asc", $searchkey, $min, $max, $rating, $category);
            }
          }
        }else{
          if($rating != ""){
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and RATING >= :rating and category = :category) ORDER BY PRICE ASC", $searchkey, intval($min), intval($max), intval($rating), $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey and rating >= :rating order by price asc", $searchkey, $min, $max, $rating, $category);
            }
          }else{
            if($category != ""){
              return $this->select("SELECT * FROM (SELECT * FROM product where UPPER(NAME) LIKE :searchkey and category = :category) ORDER BY PRICE ASC", $searchkey, $category);
            }else{
              return $this->search("SELECT * FROM product where upper(productname) like :searchkey order by price asc", $searchkey, $min, $max, $rating, $category);
            }
          }
        }
      }
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