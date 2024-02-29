<?php

use utilities\Response as Response;
use utilities\Router as Router;

require_once 'autoload.php';
require_once 'error.php';

Response::allowOrigin();

$router = new Router();

require_once 'Controller/karya.php';
require_once 'Controller/auth.php';
require_once 'Controller/categories.php';

try {
  $router->run();
} catch (Exception $e) {
  Response::json(['error' => $e->getMessage()], 500);
}
