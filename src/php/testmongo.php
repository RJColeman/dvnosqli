<?php
// connect to mongodb

try {
    $m = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    echo 1;
} catch (Exception $e) {
    echo 0;
}

?>
