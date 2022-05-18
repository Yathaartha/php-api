<?php
  session_start();

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Credentials: true");
  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
  header('Access-Control-Max-Age: 1000');
  header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
  require __DIR__ . "/inc/bootstrap.php";
  
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $uri = explode( '/', $uri );
  
  if (isset($uri[3]) && $uri[3] == 'user') {    
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/UserController.php";
    
    $objFeedController = new UserController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  } elseif(($uri[3]) && $uri[3] == 'product'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/ProductController.php";
    $objFeedController = new ProductController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'category'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/CategoryController.php";
    $objFeedController = new CategoryController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'trader'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/TraderController.php";
    $objFeedController = new TraderController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }
  else{
    header("HTTP/1.1 404 Not Found");
    exit();
  }
?>