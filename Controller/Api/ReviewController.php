<?php

  class ReviewController extends BaseController{
    /**
     * "/review/list" Endpoint - Get list of reviews
     */
    public function listAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrQueryStringParams = $_GET;

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $reviewModel = new ReviewModel();

          if(isset($arrQueryStringParams['id'])){
            $productId = $arrQueryStringParams['id'];
          }
        
          $arrProduct = $reviewModel->getReviews($productId);
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
     * "/review/report" Endpoint - report review
     */
    public function reportAction(){
      $strErrorDesc = '';
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $arrFormParams = json_decode(file_get_contents('php://input'), true);

      if(strtoupper($requestMethod) == 'GET'){
        try{
          $reviewModel = new ReviewModel();

          $arrProducts = $reviewModel->reportReview($arrFormParams['reviewid'], $arrFormParams['reportreason'], $arrFormParams['customerid']);
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
        * "/review/create" Endpoint - Create new review
        */
    
        public function createAction(){
          $strErrorDesc = '';
          $requestMethod = $_SERVER["REQUEST_METHOD"];
          // $arrQueryStringParams = $this->getQuerystringParams();
          $arrFormParams = json_decode(file_get_contents('php://input'), true);

          // if(strtoupper($requestMethod) == 'POST'){
            try{
              $reviewModel = new ReviewModel();
              $arrUser = $reviewModel->addReview($arrFormParams['productid'], $arrFormParams['content'], $arrFormParams['rating'], $arrFormParams['customerid']);
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