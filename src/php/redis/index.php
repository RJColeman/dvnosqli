<?php 
   //Connecting to Redis server on localhost 
   $redis = new Redis(); 
   $redis->connect('dvnosqli_redis_1', 6379); 
   echo "Connection to server sucessfully"; 
   //check whether server is running or not 
   echo "Server is running: ".$redis->ping(); 
   $redis->set($key, "Redis tutorial");
   $redis->set('1abcd', "Redis tutorial");
   $redis->set('1efgh', "Redis tutorial");
   $redis->set('1ijkl', "Redis tutorial");
   echo "getting tutorial-name " . $redis->get("tutorial-name");
   echo "getting keys " . print_r($redis->keys('1*'));
   $keys = $redis->keys('1*');
   echo 'getting all values' . $redis->get($keys[0]);
?>
