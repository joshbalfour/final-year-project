**V 1.0.0**
# Technical Overview

### Purpose
The API is the part that will read the data from the calculated data from the database and return it to the user. The type and data range of the data will be defined in the URL of the request.

### System
The system will be written in PHP using the #RyanLibraryNameHere as a base framework. This will then be served by the nginx docker container. PHP will recieve a HTTP and which will load up the frame, this will then route the request to the correct peice of code base of the router deffintion. After that the code will connect to the database and the code will decide what view it needs to read the data frame. Finally it will return the data back to the user in a defined format.

The API also defines what should happen if there is a error. If it is a catchable error then it should return an error code along with a message. If its an uncathble error it should return the unknown error code and the PHP error. This is defined further in the API document.

### Testing
 #RyanPutThingsHerePlease

### Flow Chart

![image](../images/System designs/Flow Diagram - Section 4.jpg)
