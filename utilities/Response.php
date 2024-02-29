<?php

namespace utilities;

class Response
{
  public static function json($data, $status = 200)
  {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
  }

  public static function allowOrigin()
  {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With');

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
      header('HTTP/1.1 200 OK');
      exit();
    }
  }
}
