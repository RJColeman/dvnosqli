<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// connect to mongodb
try {
    # $m = new MongoDB\Driver\Manager("mongodb://172.24.0.2:27017");
    $m = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");
} catch (Exception $e) {
    print_r($e);
}

$filter['user']['$ne'] = 'admin';
$query = new MongoDB\Driver\Query($filter);
$rows = $m->executeQuery('test.users', $query);

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
