<?php

$redis = new Redis(); 
$redis->connect('dvnosqli_redis_1', 6379); 
$keys = $redis->keys('*');
print "<pre>" . print_r($keys,1) . "</pre>";
