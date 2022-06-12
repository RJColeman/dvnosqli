cid=$(docker ps --filter "name=dvnosqli_neo4j*" -aq)
docker exec -it $cid /bin/bash
