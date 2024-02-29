<?php

use utilities\Response as Response;
use utilities\Connection as Connection;

$router->post("/auth/login", function ($data) {
  $email = $data['email'];
  $password = $data['password'];

  $stmt = Connection::get()->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
  $url = $_SERVER["HTTP_REFERER"] . "explore";
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $data["user_id"];
  Response::json(["redirect" => $url, "cookies" => "user_id=$user_id;path=/"]);
});

$router->post("/auth/register", function ($data) {
  $first_name = $data["first_name"];
  $middle_name = $data["middle_name"];
  $last_name = $data["last_name"];
  $password = $data["password"];
  $email = $data["email"];
  $username = $data["username"];

  try {
    Connection::get()->query("INSERT INTO users (first_name, middle_name, last_name, password, email, username) VALUES ('$first_name', '$middle_name', '$last_name', '$password', '$email', '$username')");
    $url = $_SERVER["HTTP_REFERER"] . "login";

    Response::json(["redirect" => $url]);
  } catch (\Throwable $th) {
    Response::json(["error" => $th->getMessage()], 500);
  }
});
