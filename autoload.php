<?php

// Autoload classes
spl_autoload_register(function ($class_name) {
  // replace namespace separator with directory separator
  $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
  include_once $class_name . '.php';
});
