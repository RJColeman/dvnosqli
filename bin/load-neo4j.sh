echo "Connecting to Neo4j container .... "
cid=$(docker container ls | grep neo4j | awk '{print$1}')
echo "Executing Neo4j data load .... "
docker exec --privileged -i $cid sh /data-load/load.sh
echo "Completeed Neo4j data load .... "
