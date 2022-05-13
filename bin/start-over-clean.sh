#!/bin/bash

echo ""
echo "stopping all containers for dvnosqli......"
echo ""
docker stop $(docker ps --filter "name=dvnosqli.*" -aq) 2> null
echo "removing all containers for dvnosqli......"
echo ""
docker rm --force $(docker ps --filter "name=dvnosqli.*" -aq) 2> null
echo "removing dvnosqli frontend container......"
echo ""
docker rmi --force $(docker images --filter "label=com.rjcoleman.dvnosqli" -q) 2> null
docker volume prune 
docker network prune 
rm -rf .data-neo4j/*
echo "************************************************"
echo ""
echo "   REWRITE TO ONLY REMOVE DVNOSQLi OBJECTS"
echo ""
echo "************************************************"
