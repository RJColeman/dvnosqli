<?php
require_once $_BASE_PATH . 'redis/Redis.php';
if (isset($_GET['test'])) {
  try {

    $redis = RedisBuilder::create()
           ->withLevel($_COOKIE['level']);
    $redis->testSet('test:key', 'my test value');
    echo $redis->testGet('test:key');

  } catch (Exception $e) {
    echo ("caught exception: ". $e->getMessage());
  }
} 
try {

  $redis = RedisBuilder::create()
          ->withLevel($_COOKIE['level']);

} catch (Exception $e) {
  error_log("caught exception: ". $e->getMessage());
}
$output = $redis->printResults();
if (strstr($output, 'FLAG')) {
  require_once($_BASE_PATH . 'banner.html');
}
echo $output;
?>
