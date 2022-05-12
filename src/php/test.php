<?php

class gp {
  function myfunc() {
    echo "i'm in gp";
  }
}

class par extends gp {
  function myfunc() {
    parent::myfunc();
    echo "i'm also a par";
  }
}

class gc extends par {
}

$per = new gc();
$per->myfunc();
