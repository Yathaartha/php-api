<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class WishlistModel extends Database {
    public function createWish($id) {
      return $this->createById("INSERT INTO WISHLIST VALUES (sq_wishlist.NEXTVAL, :id)", $id);
    }

    public function getWishlist($customerid){
      return $this->selectById("SELECT * FROM WISHLIST WHERE CUSTOMER = :id", $customerid);
    }

    public function getWishlistItems($id){
      return $this->selectById("SELECT * FROM WISHLISTITEMS WHERE WISHLIST = :id", $id);
    }

    public function addItemToWishlist($wishlistId, $productId){
      return $this->addToWishlist("INSERT INTO WISHLISTITEMS VALUES (:wishlist, :product)", $wishlistId, $productId);
    }

    public function deleteFromWishlist($wishlistId, $productId){
      return $this->removeFromWishlist("DELETE FROM WISHLISTITEMS WHERE PRODUCT = :productid AND WISHLIST = :wishlistid", $wishlistId,$productId);
    }
  }

?>