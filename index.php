<?php
  session_start();

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Credentials: true");
  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
  header('Access-Control-Max-Age: 1000');
  header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
  require __DIR__ . "/inc/bootstrap.php";
  ini_set('display_errors', FALSE);
  
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
  }elseif(($uri[3]) && $uri[3] == 'wishlist'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/WishlistController.php";
    $objFeedController = new WishlistController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'shop'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/ShopController.php";
    $objFeedController = new ShopController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'cart'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/CartController.php";
    $objFeedController = new CartController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'order'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/OrderController.php";
    $objFeedController = new OrderController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'review'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/ReviewController.php";
    $objFeedController = new ReviewController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }elseif(($uri[3]) && $uri[3] == 'offer'){
    require PROJECT_ROOT_PATH . "/php-api/Controller/Api/OfferController.php";
    $objFeedController = new OfferController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
  }
  else{
    header("HTTP/1.1 404 Not Found");
    exit();
  }
?>