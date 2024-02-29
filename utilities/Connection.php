<?php

namespace utilities;

class Connection
{
  private static $pdo;

  public static function get()
  {
    if (!self::$pdo) {
      self::$pdo = new \PDO('mysql:host=127.0.0.1;dbname=pakar', 'root');
    }

    return self::$pdo;
  }

  public static function close()
  {
    self::$pdo = null;
  }
}
