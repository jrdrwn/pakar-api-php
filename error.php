<?php

use utilities\Response;


set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  Response::json(['error' => "Error $errno: $errstr in $errfile on line $errline"], 500);
});
