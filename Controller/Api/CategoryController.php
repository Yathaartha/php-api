<?php

  class CategoryController extends BaseController{
    /**
     * "/category/list" Endpoint - Get list of products
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $categoryModel = new CategoryModel();
          
          $arrProducts = $categoryModel->getCategories();
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
    
  }
?>