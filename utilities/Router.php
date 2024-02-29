<?php

namespace utilities;

class Router
{
  private $routes = [];

  public function get($path, $callback)
  {
    $this->routes["/api" . $path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes["/api" . $path] = $callback;
  }

  public function run()
  {
    $path = $_SERVER['PATH_INFO'];
    $method = $_SERVER['REQUEST_METHOD'];

    $routeFound = false;
    foreach ($this->routes as $routePattern => $handler) {
      $routePattern = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^\/]+)', $routePattern);
      if (preg_match("#^" . $routePattern . "$#", $path, $matches)) {
        $routeFound = true;
        if ($method === 'GET') {
          $handler($matches);
        } else if ($method === 'POST') {
          $data = json_decode(file_get_contents('php://input'), true);
          $handler($data, $matches);
        }
        break;
      }
    }

    if (!$routeFound) {
      Response::json(['error' => 'Not Found'], 404);
    }
  }
}
