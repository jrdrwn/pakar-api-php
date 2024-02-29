<?php

use utilities\Response as Response;
use utilities\Connection as Connection;

$router->get("/karya", function () {
  $tag = urldecode(isset($_GET["tag"]) ? $_GET["tag"] : '');
  $user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : "";

  try {
    $query = "SELECT karya.karya_id, title, about, price, karya.image, categories.name as category, users.user_id, username, first_name, middle_name, last_name, COUNT(likes.karya_id) as likes_count, SUM(CASE WHEN likes.user_id = '$user_id' THEN 1 ELSE 0 END) as is_user_like FROM karya JOIN users ON karya.author = users.user_id JOIN categories ON karya.category_id = categories.category_id LEFT JOIN likes ON likes.karya_id = karya.karya_id";
    if (isset($_GET["tag"]) && $_GET["tag"] === "me") {
      $query .= " WHERE karya.author = '$user_id' GROUP BY karya.karya_id";
    } else if (isset($_GET["tag"]) && $_GET["tag"] === "Semua") {
      $query .= " GROUP BY karya.karya_id";
    } else if (isset($_GET["q"])) {
      $q = $_GET["q"];
      $query .= " WHERE karya.title LIKE $q GROUP BY karya.karya_id";
    } else {
      $query .= " WHERE categories.name = '$tag' GROUP BY karya.karya_id";
    }
    if (isset($_GET["limit"]) && isset($_GET["offset"])) {
      $limit = $_GET["limit"];
      $offset = $_GET["offset"];
      $query .= " LIMIT $limit OFFSET $offset";
    }
    $stmt = Connection::get()->query($query);
    Response::json($stmt->fetchAll(PDO::FETCH_ASSOC));
  } catch (\Throwable $th) {
    Response::json(["error" => $th->getMessage()], 500);
  }
});
