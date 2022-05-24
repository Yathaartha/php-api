<?php
  require_once PROJECT_ROOT_PATH . "/php-api/Model/Database.php";

  class OfferModel extends Database {
    public function getOffers() {
      return $this->selectAll("SELECT * FROM OFFER");
    }

    public function getOffersByTrader($traderid) {
      return $this->selectById("SELECT * FROM OFFER WHERE TRADER = :id", $traderid);
    }

    public function getOffer($offerid) {
      return $this->selectById("SELECT * FROM OFFER WHERE OFFERID = :id", $offerid);
    }

    public function addOffer($offername, $discount, $traderid, $startdate, $enddate) {
      return $this->insertOffer("INSERT INTO OFFER VALUES (null, :offername, :discount, :traderid, TO_DATE(:startdate, 'MM/DD/YYYY'), TO_DATE(:enddate, 'MM/DD/YYYY'))", $offername, $discount, $traderid, $startdate, $enddate);
    }
  }
?>