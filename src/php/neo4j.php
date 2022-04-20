<?php
require_once __DIR__ .'/vendor/autoload.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Databags\Statement;

try {
    $client = ClientBuilder::create()
        ->withDriver('bolt', 'bolt://neo4j:dvneo4j@dvnosql-neo4j-1:7687') // creates a bolt driver
        ->build();
    // Results are a CypherList
    $results = $client->run('MATCH (canvas:Canvas) RETURN canvas LIMIT 10');
    $results = $client->run('MATCH (n)-[r]->(m) RETURN n,r,m');

    // A row is a CypherMap
    foreach ($results as $result) {
        // Returns a canvas
        echo "<pre>" . print_r($result,1) . "</pre>";
    #    $canvas = $result->get('canvas');

    #    echo $canvas->getProperty('name');
    }

} catch (Exception $e) {
    echo "caught exception: ", $e->getMessage(), "<br>";
}
