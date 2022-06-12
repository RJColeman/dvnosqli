# Why

I wanted to understand NoSQL Injection with Neo4j and MongoDB, so I built this vulnerable web application. It is still under construction, but for the most part, Neo4j and MongoDB work. 

The web interface renders the problmeatic code once injection has been accomplished in easy medium hard levels and renders mitigation code in impossible level.

# Getting up and running 

To run your first build, after cloning this repository, execute the following commands:

```
$> docker compose build
$> docker compose --compatibility up -d
$> sh bin/load-neo4j.sh
```

At the very end you should see output as follows:

  ```
  Connecting to Neo4j container ....
  Executing Neo4j data load ....
  Completeed Neo4j data load ....
  ``` 

Next browse to the web front end at [http://localhost:8084/](http://localhost:8084/) and in the MongoDB section, [reset the MongoDB database](https://github.com/RJColeman/dvnosqli#mongo).

# Notes on docker compoase

Because [docker compose v1 (written in python) and docker compose v2 (written in go) use _ or - respectively](https://stackoverflow.com/questions/69464001/docker-compose-container-name-use-dash-instead-of-underscore) when naming networks, I've included the  `--compatibility` flag in the `docker compose up` command because this project depends on the _ (underscore) in network names.

# Solutions

For walkthrough information see:

- [Neo4j Walkthrough hints and steps](https://github.com/RJColeman/dvnosqli/blob/main/NEO4J-HELP.md)
- [MongoDB Walkthrough hints and steps](https://github.com/RJColeman/dvnosqli/blob/main/MONGODB-HELP.md)

# Rebuilding 

To rebuld from scratch, make sure you've removed all related docker images, containers, volumes, and networks, then re-run the steps above. 

# Network Details

Because [docker compose v1 (written in python) and docker compose v2 (written in go) use _ or - respectively](https://stackoverflow.com/questions/69464001/docker-compose-container-name-use-dash-instead-of-underscore) when naming networks, I've included the  `--compatibility` flag in the `docker compose up` command because this project depends on the _ (underscore) in network names.

# Accessing the assets

## Web Frontend

To access the web front end browse to [http://localhost:8084/](http://localhost:8084/)

## Neo4j 

To confirm that the test data was loaded for neo4j:

1. Browse to [http://localhost:7474/browser/](http://localhost:7474/browser/)
2. Log in with username/password neo4j/protect-toga-hair-oberon-coral-2052
3. Execute the following query

 ```
 match (n) return n
 ```
4. You should see nodes and relationships

## Mongo

You need to load the data used by application:

1. Browse to [http://localhost:8084/?db=mongodb](http://localhost:8084/?db=mongodb)
2. Click the "reset/load" button

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
