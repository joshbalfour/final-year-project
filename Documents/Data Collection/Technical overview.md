**V 1.0.1**
# Technical Overview

## Implementation
Each importer is written as a PHP script, this gets the data from the target and imports it into the database. Each importer needs a set of libraries to access the relative data type.

### Task timing
Each task runs as a cron job. Some tasks need to be ran every minute others, every month depending on how frequent the data changes.

## Flow Chart
Below is a generalised, overall flow chart for the connection to Network Rail data. This will generally be the same for each one, only changing the data source and the import phase.

##### Start
The script starts and loads up it's dependencies.

##### Read Data
The script will then connect to the relevant data source and download the data. This may involve several steps.

##### Is Data Valid
The data is then ran through a series of tests to ensure it's both valid and sane.

##### Notify Admin
If the data is not valid the system administrator is then notified so someone can investigate.

###### Convert Data
This step will vary depending on the data source. The data will be remapped from the external datasource into a format that can be inserted into the database.

###### Append Data to Database
Now insert the data processed in the previous step into the database.

###### System Stop
Finally the PHP script stops and PHP will clean up any data handled internally during the process.


![image](../images/System designs/Flow Diagram - Section 6.jpg =450x)