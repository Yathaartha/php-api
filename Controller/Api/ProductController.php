<?php

  class ProductController extends BaseController{
    /**
     * "/product/list" Endpoint - Get list of products
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      // if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ProductModel();

        if(isset($arrQueryStringParams['limit'])){

          $intLimit = 10;

          $intLimit = $arrQueryStringParams['limit'];

          if(isset($arrQueryStringParams['offer'])){
            $offer = $arrQueryStringParams['offer'];
            $arrProduct = $productModel->getOfferProduct($intLimit);
            $responseData = json_encode($arrProduct);
          }
          if(isset($arrQueryStringParams['highlight'] ) && $arrQueryStringParams['highlight']){
            $highlight = $arrQueryStringParams['highlight'];
            $arrProducts = $productModel->getHighlightedProducts($highlight ,$intLimit);
            $responseData = json_encode($arrProducts);
          }else{
            $arrProducts = $productModel->getProducts($intLimit);
            $responseData = json_encode($arrProducts);
          }
        } 
        if(isset($arrQueryStringParams['shop'])){
          $intProductId = $arrQueryStringParams['shop'];
          $arrProduct = $productModel->getProductByShop($intProductId);
          $responseData = json_encode($arrProduct);
        }
        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }

      // send output
      if(!$strErrorDesc){
        $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
      }else{
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
      }
    }
    /**
     * "/product/offer" Endpoint - Get list of products
     */
    public function offerAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      // if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ProductModel();
          
          $arrProduct = $productModel->getOfferProduct();
          $responseData = json_encode($arrProduct);

        } catch(Error $e){
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact supper.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
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
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $productModel = new ProductModel();
              $arrUser = $productModel->addProduct($arrFormParams['product_name'], $arrFormParams['product_price'], $arrFormParams['product_description'], $arrFormParams['product_image'], $arrFormParams['product_stock'], $arrFormParams['shop'], $arrFormParams['category'], $arrFormParams['offer']);
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
        * "/product/edit" Endpoint - Create new product
        */
    
        public function editAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $productModel = new ProductModel();
              $arrUser = $productModel->editProduct($arrFormParams['product_name'], $arrFormParams['product_price'], $arrFormParams['product_description'], $arrFormParams['product_image'], $arrFormParams['product_stock'], $arrFormParams['shop'], $arrFormParams['category'], $arrFormParams['offer'], $arrFormParams['productid']);
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
        * "/product/delete" Endpoint - Delete product
        */
    
        public function deleteAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrQueryStringParams = $_GET;

          // if(strtoupper($requestMethod) == 'DELETE'){
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