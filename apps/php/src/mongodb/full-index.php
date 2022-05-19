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
<?php
$manager=new MongoDB\Driver\Manager("mongodb://db_mongo_new:27017");
$name = $_GET['name'];
$passwd = $_GET['passwd'];

$query=new MongoDB\Driver\Query(array(
    "name" => $name,
    "passwd" => $passwd
));

$result = $manager->executeQuery('nosqli.sqli',$query);
$count=count($result);
if($count > 0)
{
    foreach($result as $user)
    {  
        $user = ((array)$user);
        echo '====Login Successful====</br>';
        echo 'name:'.$user['name'].'</br>';
        echo 'passwd:'.$user['passwd'].'</br>';
    }
}
else{
    echo "Login Failed!";
}
<?php
$manager = new MongoDB\Driver\Manager("mongodb://db_mongo_new:27017");
$name = $_GET['name'];
$passwd = $_GET['passwd'];
$function = "
function() {
    var name = '".$name."';
    var passwd = '".$passwd."';
    if(this.name == name && this.passwd == passwd) return true;
    else return false;
}";
echo $function.'<br />';

$query = new MongoDB\Driver\Query(array(
    '$where' => $function
));
$result = $manager->executeQuery('nosqli.sqli', $query)->toArray();
print_r($result);
echo '<br />';
$count = count($result);
if ($count>0) {
    foreach ($result as $user) {
        $user=(array)$user;
        echo '====Login Success====<br>';
        echo 'username: '.$user['name']."<br>";
        echo 'password: '.$user['passwd']."<br>";
    }
}
else{
    echo 'Login Failed';
}
?>
