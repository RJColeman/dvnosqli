# Getting up and running 

## PHP & Nginx Details

To rebuld from scratch, make sure you've removed all related docker images and containers, then, from the repository root directory, run:

```
$> sh build.sh
```

This script is short and sweet:

```
# build our own custom web server
docker build -t dvneo4j:latest .

# build and bring all containers and networks up 
docker-compose build
docker-compose up
```

# Network Details

# Accessing the assets

## Web Frontend

To access the web front end browse to [http://localhost:8084/](http://localhost:7474/browser/)

## Neo4j 

After running `docker compose up`, you'll need to load the test data and change your neo4j default password. From the root of this repository run:


   ```
   sh bin/load-neo4j.sh
   ```
You should see output as follows:

  ```
  Connecting to container ....
  Executing data load ....
  Completeed data load ....
  ``` 
To confirm test data was loaded:

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
