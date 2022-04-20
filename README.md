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

To access the Neo4j frontend browse to [http://localhost:7474/browser/](http://localhost:7474/browser/)

## Mongo

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
