<?php
require_once $_BASE_PATH . 'mongodb/Search.php';

if (isset($_GET['test'])) {
  try {

    $search = SearchBuilder::create()
           ->withLevel($_COOKIE['level'], "test");
    $results = $search->testQuery('Tom Hanks" OR p.name =~ ".*');

    echo '<p class="notice">Test was a ssucess</p>';

  } catch (Exception $e) {
    echo ("caught exception: ". $e->getMessage());
  }
}

// connect to mongodb
try {
    # $m = new MongoDB\Driver\Manager("mongodb://172.24.0.2:27017");
    $m = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");
} catch (Exception $e) {
    print_r($e);
}

$filter['published'] = 'yes';
$query = new MongoDB\Driver\Query($filter);
$rows = $m->executeQuery('test.restaurants', $query);
print gettype($rows);
print get_class($rows);

foreach ($rows as $row) {
  print "<pre>";
  print_r($row);
  print "</pre>";
}

// Output of the executeQuery will be object of MongoDB\Driver\Cursor class
#$cursor = $m->executeQuery('test.users', $query);

// Convert cursor to Array and print result
#print_r($cursor->toArray());
?>
