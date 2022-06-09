# Getting up and running 

## PHP & Nginx Details

To run your first build run the following commands:

```
$> docker-compose build
$> docker-compose up
$> sh bin/load-neo4j.sh
```

At the very end you should see output as follows:

  ```
  Connecting to Neo4j container ....
  Executing Neo4j data load ....
  Completeed Neo4j data load ....
  ``` 

To rebuld from scratch, make sure you've removed all related docker images, containers, volumes, and networks, then re-run the steps above. 

# Network Details

# Accessing the assets

## Web Frontend

To access the web front end browse to [http://localhost:8084/](http://localhost:7474/browser/)

## Neo4j 

To confirm that the test data was loaded:

1. Browse to [http://localhost:7474/browser/](http://localhost:7474/browser/)
2. Log in with username/password neo4j/protect-toga-hair-oberon-coral-2052
3. Execute the following query

 ```
 match (n) return n
 ```
4. You should see nodes and relationships

## Mongo

You need to set up the database used by application:

1. Browse to [http://localhost:8081/](http://localhost:8081/)
2. Enter `test` into the `+ create database` field and click `+ create database`
3.  mongoimport -u root -p example --authenticationDatabase admin --db test --collection restaurants --type json --file j.json

* Test data from https://raw.githubusercontent.com/ozlerhakan/mongodb-json-files/master/datasets/restaurant.json


To access the mongodb shell:

```
$> docker exec -it [container id] bash
```

## Mongo Frontend 

This container depends on mongo being up and accessible. To enforce this in the docker-compose.yml file, the file must use 

* [depends_on: - mongo](https://docs.docker.com/compose/startup-order/). 
* [restart: unless-stopped](https://docs.docker.com/config/containers/start-containers-automatically/)

## References

[setting environment variables in docker compose](https://docs.docker.com/compose/environment-variables/)
[primer on docker networking](https://docs.docker.com/network/network-tutorial-standalone/)
[mongodb shell commands](https://www.mongodb.com/docs/manual/reference/mongo-shell/)
