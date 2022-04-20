#!/bin/sh
# wait-for-mongo.sh

set -e
  
until php /var/www/html/testmongo.php; do
  >&2 echo "Mongo is unavailable - sleeping"
  sleep 1
done
  
>&2 echo "Mongo is up - executing command"
exec "$@"
