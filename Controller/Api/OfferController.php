<?php

  class OfferController extends BaseController{
    /**
     * "/offer/list" Endpoint - Get list of products
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      // if(strtoupper($requestMethod) == 'GET'){
        try{
          $offerModel = new OfferModel();

          if(isset($arrQueryStringParams['offerid'])){
            $offerid = $arrQueryStringParams['offerid'];

            $arrOffer = $offerModel->getOffer($offerid);
            $responseData = json_encode($arrOffer);
          }elseif(isset($arrQueryStringParams['traderid'])){
            $traderid = $arrQueryStringParams['traderid'];

            $arrOffers = $offerModel->getOffersByTrader($traderid);
            $responseData = json_encode($arrOffers);
          }
          else{
            $arrProduct = $offerModel->getOffers();
            $responseData = json_encode($arrProduct);
          }
        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
      // }else{
      //   $strErrorDesc = 'Method not supported.';
      //   $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      // }

      // send output
      if(!$strErrorDesc){
        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
      }else{
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
      }

    }

    /**
        * "/offer/create" Endpoint - Create new offer
        */
    
        public function createAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $offerModel = new OfferModel();
              $arrUser = $offerModel->addOffer($arrFormParams['offer_name'], $arrFormParams['discount'], $arrFormParams['traderid'], $arrFormParams['start_date'], $arrFormParams['end_date']);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
          // }
          // else{
            // $strErrorDesc = 'Method not supported.';
            // $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          // }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }

    /**
        * "/product/delete" Endpoint - Delete product
        */
    
        public function deleteAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrQueryStringParams = $_GET;

          if(strtoupper($requestMethod) == 'DELETE'){
            try{
              $userModel = new ProductModel();

              $productId = "";
              if(isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']){
                $productId = $arrQueryStringParams['id'];
              }

              $arrUser = $userModel->deleteProduct($productId);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
          }
          else{
            $strErrorDesc = 'Method not supported.';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }
  }
?>