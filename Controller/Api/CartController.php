<?php
  class CartController extends BaseController{
      /**
        * "/cart/create" Endpoint - Create new wishlist
        */
        public function createAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrQueryStringParams = $_GET;
          // $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $cartModel = new CartModel();
              $id = "";

              if(isset($arrQueryStringParams['id'])){
                $id = $arrQueryStringParams['id'];
              }


              $arrUser = $cartModel->cartCreate($id);
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
        * "/cart/list" Endpoint - get wishlist
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
              $cartModel = new CartModel();
              $arrUser = $cartModel->getCart($customerId);
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
        * "/cart/item" Endpoint - get wishlist
        */
    
        public function itemAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrQueryStringParams = $_GET;

          $cartId = "";

          if(isset($arrQueryStringParams['id'])){
            $cartId = $arrQueryStringParams['id'];
          }

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $cartModel = new CartModel();
              $arrUser = $cartModel->getCartItems($cartId);
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
        * "/cart/add" Endpoint - Create new wishlist
        */
        public function addAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $cartModel = new CartModel();

              $arrUser = $cartModel->addItemToCart($arrFormParams['CARTID'], $arrFormParams['PRODUCTID'], $arrFormParams['QUANTITY']);
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