<?php

// set level in cookie
$levels = array('0','1','2','3');
if (isset($_GET['level']) && isset($levels[$_GET['level']])) {
  setcookie('level', $_GET['level']);
} else if (!isset($_COOKIE['level'])) {
  setcookie('level', '0');
}

if (isset($_SERVER['HTTP_REFERER'])) {
  header("location: " . $_SERVER['HTTP_REFERER']);
} else {
  header("location: /app/");
}
exit();
?>
