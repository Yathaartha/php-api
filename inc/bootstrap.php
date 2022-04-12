<?php
  define("PROJECT_ROOT_PATH", __DIR__ . "/../../");

  // include main configuration file
  require_once PROJECT_ROOT_PATH . "/php-apis/inc/config.php";

  // include the base controller file
  require_once PROJECT_ROOT_PATH . "/php-apis/Controller/api/BaseController.php";

  // include the user model file
  require_once PROJECT_ROOT_PATH . "/php-apis/Model/UserModel.php";
?>