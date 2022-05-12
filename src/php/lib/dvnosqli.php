<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

function printObj($o) {
  echo "<pre>" . print_r($o,1) . "</pre>";
}

if (!isset($_COOKIE['level'])) {
  header("location: /app/setcookie.php?level=0");
  exit();
}
