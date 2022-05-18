<?php
  class WishlistController extends BaseController{
      /**
        * "/wishlist/create" Endpoint - Create new wishlist
        */
        public function createAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrQueryStringParams = $_GET;
          // $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $wishlistModel = new WishlistModel();
              $id = "";

              if(isset($arrQueryStringParams['id'])){
                $id = $arrQueryStringParams['id'];
              }


              $arrUser = $wishlistModel->createWish($id);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
          // }
          // else{
          //   $strErrorDesc = 'Method not supported.';
          //   $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          // }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }

      /**
        * "/wishlist/list" Endpoint - get wishlist
        */
    
        public function listAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrQueryStringParams = $_GET;

          $customerId = "";

          if(isset($arrQueryStringParams['id'])){
            $customerId = $arrQueryStringParams['id'];
          }

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $traderModel = new WishlistModel();
              $arrUser = $traderModel->getWishlist($customerId);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        // }
          // else{
          //   $strErrorDesc = 'Method not supported.';
          //   $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          // }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }

      /**
        * "/wishlist/item" Endpoint - get wishlist
        */
    
        public function itemAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrQueryStringParams = $_GET;

          $wishlistId = "";

          if(isset($arrQueryStringParams['id'])){
            $wishlistId = $arrQueryStringParams['id'];
          }

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $traderModel = new WishlistModel();
              $arrUser = $traderModel->getWishlistItems($wishlistId);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        // }
          // else{
          //   $strErrorDesc = 'Method not supported.';
          //   $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          // }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }

        /**
        * "/wishlist/add" Endpoint - Create new wishlist
        */
        public function addAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $wishlistModel = new WishlistModel();

              $arrUser = $wishlistModel->addItemToWishlist($arrFormParams['WISHLISTID'], $arrFormParams['PRODUCTID']);
              $responseData = json_encode($arrUser);
            } catch(Error $e){
              $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
              $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
          // }
          // else{
          //   $strErrorDesc = 'Method not supported.';
          //   $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
          // }

          //  send output
          if(!$strErrorDesc){
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
          }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
          }
        }
      
  }
?>