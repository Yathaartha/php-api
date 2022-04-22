<?php
  define("PROJECT_ROOT_PATH", __DIR__ . "/../../");

  // include main configuration file
  require_once PROJECT_ROOT_PATH . "/php-api/inc/config.php";

  // include the base controller file
  require_once PROJECT_ROOT_PATH . "/php-api/Controller/api/BaseController.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-api/Model/UserModel.php";
?>