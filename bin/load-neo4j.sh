echo "Connecting to container .... "
cid=$(docker container ls | grep neo4j | awk '{print$1}')
echo "Executing data load .... "
docker exec --privileged -i $cid sh /data-load/load.sh
echo "Completeed data load .... "
