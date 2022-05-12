cid=$(docker container ls | grep neo4j | awk '{print$1}')
docker exec -it $cid /bin/bash
