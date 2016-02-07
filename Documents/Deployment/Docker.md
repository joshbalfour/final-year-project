**V 1.1.3**
# Runtime Environment

## Description

The runtime environment is a fully self-contained OS within which the application can be run. It's purpose is to ensure that the application always has everything it needs in order to function optimally. The advantages of this are:


* The environments for projects the developers are concurrently working on do not "pollute" this project's environment (e.g. a developer could require an older version of MySQL for another project which would conflict with ours)
* The development environment is consistant across all developers.
* The testing environment is consistant with development and deployment.
* The deployment environment is consistant with development and testing.

It removes many unknows, and guarentees that code written by a developer will perform the exact same between their local copy, the testing environment and the production environment.

In order to accomplish this we're utilising Docker, which allows you to specify your environment in a `Dockerfile`. Ours is in [The deployment folder](../../Application/deployment/Dockerfile).
It specifies an environment with:

* MySQL (latest version)
* Apache (latest version)
* Node JS (latest version)
* PHP (latest version)
* Composer
* Laravel 5

## Prerequisites
1. Docker Installed
2. At least 2GB RAM and 2 cores available

## Container requirements
The docker enviroment will expect to have the `src` folder pointed to the repo on the host machine and the `data` folder.

#### How to run

Clone the repo:  
`git clone git@github.com:joshbalfour/final-year-project.git ~/final-year-project/Application/deployment`

Go to the deployment folder:
`cd ~/final-year-project/Application/deployment`

In the same directory run this command which builds the image for the container:  
`docker build -t level_crossing_predictor .`  

In the same directory run this command which starts a container from the image:
 
````
docker run -v "`pwd`/data":/data -v "`pwd`/../":/src -p 7000:80 -p 7001:3306 level_crossing_predictor
````

And then verify it's running by running `docker ps -a` 

##### Parameter Description
* Container name: level_crossing
* HTTP port mapped to the host: 7000
* MySQL port mapped to the host: 7001
* /data: Location to store database data
* /src: Final year project code repo