<?php
require_once $_BASE_PATH . 'neo4j/Search.php';
if (isset($_GET['test'])) {
  try {

    $search = SearchBuilder::create()
           ->withLevel($_COOKIE['level']);
    $results = $search->testQuery('Tom Hanks" OR p.name =~ ".*');

    echo '<p class="notice">Test was a ssucess</p>';

  } catch (Exception $e) {
    echo ("caught exception: ". $e->getMessage());
  }
} 
try {

  $search = SearchBuilder::create()
          ->withLevel($_COOKIE['level']);

  // to allow access to all people in db, remove the ->setInclude() line below
  $search->setInclude(['Tom Hanks']);

  $names = $search->getNames();
  $data = [];
  if (isset($_POST['search'])) {
    if ($_COOKIE['level'] > 0) {
      $results = $search->getData($_POST['person'], $_POST['role']);
    } else {
      $results = $search->getData($_POST['person']);
    }
  }

} catch (Exception $e) {
  error_log("caught exception: ". $e->getMessage());
}
?>
<p class="err">Until further notice, we are only permitted to display data related to Tom Hanks.</p>
<form method="POST">
  Show all movie data for 
  <select name="person">
<?php
  foreach ($names as $name => $info) {
?>
  <option value="<?= $name ?>"<?= $info['disabled'] ?>><?= $name ?></option>
<?php 
  }
?>
  </select> 
<?php if ($_COOKIE['level'] > 0) { ?>
  as
  <select name="role">
    <option value="">-- select -- </option>
    <option value="ACTED_IN"<?= (isset($_POST['role']) && $_POST['role'] == 'ACTED_IN') ? ' selected': '' ?>>actor</option>
    <option value="DIRECTED"<?= (isset($_POST['role']) && $_POST['role'] == 'DIRECTED') ? ' selected': '' ?>>director</option>
    <option value="PRODUCED"<?= (isset($_POST['role']) && $_POST['role'] == 'PRODUCED') ? ' selected': '' ?>>producer</option>
    <option value="WROTE"<?= (isset($_POST['role']) && $_POST['role'] == 'WROTE') ? ' selected': '' ?>>writer</option>
  </select>
<?php } ?>
  <input type="submit" value="go" name="search" />
</form>
<?php
$output = $search->printResults();
if (strstr($output, 'FLAG')) {
  require_once($_BASE_PATH . 'content/banner.html');
}
echo $output;
?>
