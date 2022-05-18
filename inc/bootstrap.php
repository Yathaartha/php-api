<?php
  define("PROJECT_ROOT_PATH", __DIR__ . "/../../");

  // include main configuration file
  require_once PROJECT_ROOT_PATH . "/php-api/inc/config.php";

  // include the base controller file
  require_once PROJECT_ROOT_PATH . "/php-api/Controller/api/BaseController.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/UserModel.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/CategoryModel.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/TraderModel.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/ProductModel.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/WishlistModel.php";
?>