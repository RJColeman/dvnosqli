<?php $method = ($_COOKIE['level'] > 0 ? ' method="post"' : ''); ?>
<br />
Please enter both username and password below:
<form action="/?db=mongodb"<?= $method ?>>
Username: <input type="text" name="name" value="<?= (isset($_GET['name']) && !is_array($_GET['name']) ? htmlentities($_GET['name']) : ''); ?>" />
<br />
<br />
Password: <input type="text" name="passwd" value="<?= (isset($_GET['passwd']) && !is_array($_GET['passwd']) ? htmlentities($_GET['passwd']) : ''); ?>" />
<br />
<br />
<input type="hidden" name="db" value="mongodb" />
<input type="submit" name="submit" value="submit" />
</form>

<?php
if (isset($_REQUEST['name']) && isset($_REQUEST['passwd'])) {
  $manager = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");
  $name = $_REQUEST['name'];
  $passwd = $_REQUEST['passwd'];

  if ($_COOKIE['level'] == 0) {
    $query=new MongoDB\Driver\Query(array(
      "name" => $name,
      "passwd" => $passwd
    ));
  } else if ($_COOKIE['level'] == 1) {
    $function = "
    function() {
      var name = '".$name."';
      var passwd = '".$passwd."';
      if(this.name == name && this.passwd == passwd) return true;
      else return false;
    }";
    

    $query = new MongoDB\Driver\Query(array(
      '$where' => $function
    ));
  } else if ($_COOKIE['level'] == 2) {
  } else if ($_COOKIE['level'] == 3) {
  }


  try {
    $users = $manager->executeQuery('test.users',$query)->toArray();
    foreach ($users as $user) {
      $user = ((array)$user);
      echo '<br/>====Login Successful====</br>';
      echo 'name:'.$user['name'].'</br>';
      echo 'passwd:'.$user['passwd'].'</br>';
    }
    if (count($users) > 0) {
      echo "<br />";
      echo "<br />";
      if ($_COOKIE['level'] == 0) {
        echo '<br /><a href="https://www.mongodb.com/docs/manual/reference/operator/query/" target="_blank">Take a look at the query operators available with mongo and try some of them out</a>';
      } else if ($_COOKIE['level'] == 1) {
      } else if ($_COOKIE['level'] == 2) {
      } else if ($_COOKIE['level'] == 3) {
      }
      echo "<br />";
      echo "<br />";
      echo "<br />";
      require_once $_BASE_PATH . "content/banner.html";
    } else {
      echo "<br />Login Failed!";
    }
  } catch (Exception $e) {
    echo "<br />Login Failed!";
    echo "<br><br>" . $e->getMessage();
    echo "<br>";
    echo printObj($query);
  }
}
