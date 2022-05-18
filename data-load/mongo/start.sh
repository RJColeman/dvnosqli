mongoimport --host dvnosqli_mongo_1 -u root -p example --authenticationDatabase admin --db test --collection restaurants --type json --file /restaurants.json 
mongoimport --host dvnosqli_mongo_1 -u root -p example --authenticationDatabase admin --db test --collection users --type json --file /users.json
