<form action="/app/?db=redis" method="POST">
<input name="load" value="Load / Reset Redis Cached Data" type="submit" />
</form>
<?php
require_once $_BASE_PATH . 'redis/Cache.php';
if (isset($_POST['load'])) {
  print '<p><a href="/app/?db=redis">Click to return to injection challenge</a></p>';
  require_once $_BASE_PATH . 'redis/load.php';
} 

if (isset($_GET['test'])) {
  try {

    $redis = CacheBuilder::create()
           ->withLevel($_COOKIE['level']);
    $redis->testSet('test:key', 'my test value');
    echo $redis->testGet('test:key');

  } catch (Exception $e) {
    echo ("caught exception: ". $e->getMessage());
  }
} 
try {

  $redis = CacheBuilder::create()
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
