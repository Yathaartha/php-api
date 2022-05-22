<?php

  class ShopController extends BaseController{
    /**
     * "/shop/list" Endpoint - Get list of products
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ShopModel();
        
          $arrProduct = $productModel->getShops();
          $responseData = json_encode($arrProduct);
        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
      }else{
        $strErrorDesc = 'Method not supported.';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      }

      // send output
      if(!$strErrorDesc){
        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
      }else{
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
      }

    }

    /**
     * "/product/search" Endpoint - Get list of products
     */
    public function searchAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ProductModel();

          $searchKey = "";

          if(isset($arrQueryStringParams['value']) && $arrQueryStringParams['value']){
            $searchKey = $arrQueryStringParams['value'];
          }
          $arrProducts = $productModel->searchProducts($searchKey);
          $responseData = json_encode($arrProducts);
        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
      }else{
        $strErrorDesc = 'Method not supported.';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      }

      // send output
      if(!$strErrorDesc){
        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
      }else{
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
      }
    }
    /**
     * "/product/single" Endpoint - Get list of products
     */
    public function singleAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ProductModel();

          $productId = "";

          if(isset($arrQueryStringParams['id']) && $arrQueryStringParams['id']){
            $productId = $arrQueryStringParams['id'];
          }
          $arrProducts = $productModel->getProduct($productId);
          $responseData = json_encode($arrProducts);
        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
      }else{
        $strErrorDesc = 'Method not supported.';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      }

      // send output
      if(!$strErrorDesc){
        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
      }else{
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
      }
    }

    /**
        * "/product/create" Endpoint - Create new product
        */
    
        public function createAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrFormParams = $this->getFormParams();

          if(strtoupper($requestMethod) == 'POST'){
            try{
              $userModel = new ProductModel();
              $arrUser = $userModel->addProduct($arrFormParams['firstname'], $arrFormParams['lastname'], $arrFormParams['username'], $arrFormParams['address'], $arrFormParams['phone'], $arrFormParams['email'], $arrFormParams['password'], $arrFormParams['image'], $arrFormParams['status']);
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