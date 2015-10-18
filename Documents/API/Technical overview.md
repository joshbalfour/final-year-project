**V 1.1.0**
# Technical Overview

### Purpose
The API is the part that will read the data from the calculated data from the database and return it to the user. The type and data range of the data will be defined in the URL of the request.

### Implementation
#### General
The system will be written in PHP using the #RyanLibraryNameHere as a base framework. This will then be served by the nginx docker container. PHP will recieve a HTTP and which will load up the frame, this will then route the request to the correct peice of code base of the router deffintion. After that the code will connect to the database and the code will decide what view it needs to read the data frame. Finally it will return the data back to the user in a defined format.

#### Errors
The API also defines what should happen if there is a error. If it is a catchable error then it should return an error code along with a message. If its an uncathble error it should return the unknown error code and the PHP error. This is defined further in the API document.

#### Testing
 #RyanPutThingsHerePlease

### Flow Chart
##### HTTP Request
The system will start when when a HTTP request is made to the server. The server will then load up PHP and pass the request data long

##### Validate URL request
The next phase is the framework will verify the URL and find the correct piece of code to run it.

##### Has cached version?
Next it checks to see if theres already a cached version of the request. Different requests will have different caching lengths. Stale caches will be automatically removed by the library.

##### Read Cache
Assuming is to does have a cached version it needs to read this and pass this on to the returning data phase.

##### Read crossing data from computed view
If the server does not already have the data cached it needs to connect to the database and read the data from a table. No further processing of data needs to be done after this because all of the predicting logic will be done in the database.

##### Write to cache
Once the request has been returned from the database it should be cached for quicker access in the future.

##### Return data
Finally the data shoudl be wrapped correct in the API wrapper and returned to the browser in JSON format.

![image](../images/System designs/Flow Diagram - Section 4.jpg)
