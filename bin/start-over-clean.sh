#!/bin/bash

echo "************************************************"
echo ""
echo "   REWRITE TO ONLY REMOVE DVNOSQLi OBJECTS"
echo ""
echo "************************************************"
docker-compose down
docker stop $(docker ps -aq)
docker rm --force $(docker ps -aq)
docker rmi --force $(docker images -q)
docker volume rm --force $(docker volume ls -q)
docker system prune --force
rm -rf .data-neo4j/*
echo "************************************************"
echo ""
echo "   REWRITE TO ONLY REMOVE DVNOSQLi OBJECTS"
echo ""
echo "************************************************"
