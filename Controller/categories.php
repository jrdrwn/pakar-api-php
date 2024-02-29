<?php

use utilities\Response as Response;
use utilities\Connection as Connection;

$router->get("/karya/categories", function () {


  if (isset($_GET["count"]) && isset($_GET["q"])) {
    $q = $_GET["q"];
    $categories = Connection::get()->query("SELECT categories.name as category, COUNT(categories.name) as count FROM categories JOIN karya ON karya.category_id = categories.category_id WHERE categories.name LIKE '%$q%' GROUP BY categories.name ORDER BY count DESC");

    Response::json($categories->fetchAll(PDO::FETCH_ASSOC));
  } else if (isset($_GET["limit"]) && isset($_GET["q"])) {
    $q = $_GET["q"];
    $limit = $_GET["limit"];
    $categories = Connection::get()->query("SELECT * FROM categories WHERE name LIKE '%$q%' LIMIT $limit");


    Response::json($categories->fetchAll(PDO::FETCH_ASSOC));
  } else {
    $q = $_GET["q"];
    $categories = Connection::get()->query("SELECT * FROM categories WHERE name LIKE '%$q%'");

    Response::json($categories->fetchAll(PDO::FETCH_ASSOC));
  }
});
