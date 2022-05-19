<html>
  <head>
		<title>ResetDB</title>
	</head>
  <?php
// reset
$manager = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");
try {
    echo "Resetting test.users <br/>";
    $command = new \MongoDB\Driver\Command(["drop" => "users"]);
    $result = $manager->executeCommand('test', $command);
    echo "Collection users has dropped<br />\n";
} catch (MongoDB\Driver\Exception\RuntimeException$e) {
    echo "Collection users not exists<br />\n";
}

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert(["name" => 'rjcoleman', "role"=>"user", "age" => 21, "passwd" => "randompw"]);
$bulk->insert(["name" => 'Retupmoc',"role"=>"bot",  "age" => 19, "passwd" => "keep_me_posted"]);
$bulk->insert(["name" => 'Rekcah', "role"=>"user", "age" => 21, "passwd" => "snack-crackers"]);
$bulk->insert(["name" => 'Superadmin', "role"=>"admin", "age" => 22, "passwd" => "FLAG!!!EASY^MEDIUM^HARD"]);
$result = $manager->executeBulkWrite('test.users', $bulk);
echo $result->getInsertedCount() . " documents inserted\n";
?>
</html>
