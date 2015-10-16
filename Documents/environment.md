**V 1.1.0**
# Environment
This document says about the repo structure and environment.

## Config
We use docker.  
Start by: `docker run`


## File Structure
### Assets/
The assets folder has assets related to the project just as logos, designs, any generally files that have no other specific place within the file system.

### Application/
The Application folder folder containers the several folders required for running the application its self.


### Application/Development/
The deployment folder will contain the Application required to actaully start and run the system. This will include a initialisation script that will download all data, and a boot script that just starts the system assuming it already has a primed database.

### Application/Data Collection/
This folder will contain all the Application related to the Data Collection and a crontab file which will ensure all the data runs at the correct timings.

### Application/Database/
The database will contain all files related to the the database including any seed data, schemas for tables and schemas for views. The views will store the algorithum.

### Application/API/
The API reads the data from the database views.

### Application/WebApp/
The web app contains the angular web application which will display the level crossings.


### Documents/
The docs folder contains all the documents related to this project. This is the management files as well as technical coding files.