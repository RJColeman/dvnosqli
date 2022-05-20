<?php 
$name = $passwd = $flag = $msg = false;

// confirm data in exists and is in correct format, in our case, both name and passwd should be strings
if (isset($_REQUEST['fields']['name'])) {
  if (!is_string($_REQUEST['fields']['name'])) {
    // do not print error to the screen, only to the logs
    error_log("ALERT name is being attacked. Should probably add IP address of attacker to logs");
    $msg = "<br />Login Failed";
  } else {
    $name = $_REQUEST['fields']['name'];  
  }
}

if (isset($_REQUEST['fields']['passwd'])) {
  if (!is_string($_REQUEST['fields']['passwd'])) {
    // do not print error to the screen, only to the logs
    error_log("ALERT passwd is being attacked. Should probably add IP address of attacker to logs");
    $msg = "<br />Login Failed";
  } else {
    $passwd = $_REQUEST['fields']['passwd'];  
  }
}

if ($name && $passwd) {
  $manager = new MongoDB\Driver\Manager("mongodb://root:example@dvnosqli_mongo_1:27017");

  // build query
  try {

    $query=new MongoDB\Driver\Query(array(
      "name" => strval($name),
      "passwd" => strval($passwd)
    ));

    $users = $manager->executeQuery("test.users",$query)->toArray();
    foreach ($users as $user) {
      $user = ((array)$user);
      echo '<br/>====Login Successful====</br>';
      echo 'name: ' . htmlentities($user['name']) . '<br />';
      echo 'passwd: ' . htmlentities($user['passwd']) . '<br />';
      if ($user['passwd'] != $passwd && !$flag) {
        $flag = true;
      }
    }
    if ($flag > 1) {
      echo "<br />";
      require_once $_BASE_PATH . "content/banner.html";
      print_good_code();

    } else if (count($users) == 0) {
      echo "<br />Login Failed!";
      print_good_code();
    } else {
      echo "<br />please enter username and password";
    }
  } catch (Exception $e) {
    error_log("ALERT " . $e->getMessage());
    $msg = "<br />Login Failed";
    print_good_code();
  }
}

if ($msg) echo $msg;

function print_good_code() {
  echo '
<br />
<br />
==== Mitigation Information Below ====<br />
<br />
Below is the code mitigating NoSQLi vulnerabilities for this MongoDB instance. Three things to note:
<ul>
<li>This code rejects input that does not meet data requirements. In this case, the data must be a string. No arrays</li>
<li>This code is Not using the $where operator, which allows JavaScript to be passed to the server</li>
<li>This code logs when unexpected data types are pssed in</li>
<li>This code DOES NOT print unnecessary errors to the browser. "Login Failed" and "Please enter both username and password" are all our users need to know.</li>
</ul>
&nbsp;&nbsp;<div class="code">
&nbsp;&nbsp;// validate input data: in our case, name &amp; passwd should be strings<br/><br />
&nbsp;&nbsp;if (isset($_REQUEST["fields"]["name"])) {<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;if (!is_string($_REQUEST["fields"]["name"])) {<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// do not print error to the screen, only to the logs<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;error_log("ALERT name is being attacked. Add IP address of attacker to logs");<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$msg = "Login Failed";<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;} else {<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name = $_REQUEST["fields"]["name"];<br/>
&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;}<br/>
<br />
&nbsp;&nbsp;if (isset($_REQUEST["fields"]["passwd"])) {<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;if (!is_string($_REQUEST["fields"]["passwd"])) {<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// do not print error to the screen, only to the logs<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;error_log("ALERT passwd is being attacked. Add IP address of attacker to logs");<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$msg = "Login Failed";<br/><br />
&nbsp;&nbsp;&nbsp;&nbsp;} else {<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$passwd = $_REQUEST["fields"]["passwd"];<br/>
&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;}<br/>
<br/>
&nbsp;&nbsp;... code omitted ...
<br />
<br/>
&nbsp;&nbsp;// build query<br/>
&nbsp;&nbsp;$query=new MongoDB\Driver\Query(array(<br/>
&nbsp;&nbsp;&nbsp;&nbsp;"name" => strval($name),<br/>
&nbsp;&nbsp;&nbsp;&nbsp;"passwd" => strval($passwd)<br/>
&nbsp;&nbsp;));<br/>
<br/>
&nbsp;&nbsp;... code omitted ...
&nbsp;&nbsp;</div>

';

}
