<?php

  class ProductController extends BaseController{
    /**
     * "/product/list" Endpoint - Get list of products
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $this->getQuerystringParams();

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $productModel = new ProductModel();

          $intLimit = 10;

          if(isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']){
            $intLimit = $arrQueryStringParams['limit'];
          }

          $arrProducts = $productModel->getProducts($intLimit);
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
        * "/user/create" Endpoint - Create new user
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
  }
?>