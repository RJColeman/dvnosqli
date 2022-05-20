<?php
$method = ($_COOKIE['level'] > 1 ? ' method="post"' : ' method="get"'); 
?>
<form action="/mongodb/load_mongodb.php"  method="POST">
<input name="load" value="Load / Reset MongoDB Data" type="submit" />
</form>
<br />
Please enter both username and password below:
<form action="/?db=mongodb"<?= $method ?>>
Username: <input type="text" id="name" name="fields[name]" value="<?= (isset($_REQUEST['fields']['name']) && !is_array($_REQUEST['fields']['name']) ? htmlentities($_REQUEST['fields']['name']) : ''); ?>" />
<br />
<br />
Password: <input type="text" id="passwd" name="fields[passwd]" value="<?= (isset($_REQUEST['fields']['passwd']) && !is_array($_REQUEST['fields']['passwd']) ? htmlentities($_REQUEST['fields']['passwd']) : ''); ?>" />
<br />
<br />
<input type="hidden" name="db" value="mongodb" />
<?php if ($_COOKIE['level'] == 2) { ?>
<input type="hidden" name="collection" value="users" />
<?php }?>
<input type="submit" name="submit" value="submit" />
</form>

<?php 
if ($_COOKIE['level'] > 2) {
  require_once $_BASE_PATH . "mongodb/impossible.php";
} else {
  if (isset($_REQUEST['fields']) && isset($_REQUEST['fields'])) {
    $manager = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");
    $name = isset($_REQUEST['fields']['name']) ? $_REQUEST['fields']['name'] : '';
    $passwd = isset($_REQUEST['fields']['passwd']) ? $_REQUEST['fields']['passwd'] : '';
 
    $collection = "users";
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
      $collection = (isset($_REQUEST['collection']) ? $_REQUEST['collection'] : 'users');
      $query=new MongoDB\Driver\Query($_REQUEST['fields']);
    } else if ($_COOKIE['level'] == 3) {
    }
 
    try {
      $users = $manager->executeQuery("test.$collection",$query)->toArray();
      $content = '';
      foreach ($users as $user) {
        $user = ((array)$user);
        $user_row = '<br/>====Login Successful====</br>';
        foreach ($_REQUEST['fields'] as $lbl => $val) {
          $user_row .= $lbl . ': ' . $user[$lbl].'</br>';
        }
        $content .= $user_row;
      }
      if (count($users) > 0) {
        echo "<br />";
        if ($_COOKIE['level'] > 1) {
          if (strstr($content, '!!HARD')) { 
            require_once $_BASE_PATH . "content/banner.html";
          }
        } else {
          require_once $_BASE_PATH . "content/banner.html";
        }
 
        echo $content;
        if ($_COOKIE['level'] == 0) {
          echo '<br /><a href="https://www.mongodb.com/docs/manual/reference/operator/query/" target="_blank">Take a look at the query operators available with mongo and try some of them out</a>';
        } else if ($_COOKIE['level'] == 1) {
        } else if ($_COOKIE['level'] == 2) {
        } else if ($_COOKIE['level'] == 3) {
        }
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
}
/*
      const date = Date.now();
      let currentDate = null;
      do {
        currentDate = Date.now();
      } while (currentDate - date < 100);
*/

