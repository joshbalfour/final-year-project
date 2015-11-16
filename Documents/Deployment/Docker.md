**V 1.1.0**
# Docker

## Container requirements
The docker enviroment will expect to have the `src` folder pointed to the repo on the host machine and the `data` folder.

#### How to run
Clone the repo:  
`git clone git@github.com:joshbalfour/final-year-project.git ~/final-year-project/Application/deployment`

Go to your Application deployment folder:  
`cd ~/final-year-project/Application/deployment`

Compile container:  
`docker build -t level_crossing .`

Start the container:   
```
docker run  -v "`pwd`/../../data":/data -v "`pwd`/":/src -p 7000:80 -p 7001:3306 level_crossing
```

#####What this means?
* Container name: level_crossing
* HTTP port: 7000
* MySQL port: 7001
* /data: Location to store database data
* /src: Final year project code repo

## Deployment script (runs on server only)
The deploy script script will be ran on the server and is not reloaded when the repo reloads. This is to protect the host from the deoply script being altered.

##### 0) Running the script
The script will be ran in node as root.

##### 1) Webhook
A webhook will be sent from from github to the server when ever  a branch is updated

##### 2) Update code
The node script will then run `sudo -u {name_of_project_owner} git pull` on the repo. This will ensure that git pull it ran and the files have the correct permissions.

##### 3) Update docker
The `docker build .` and `docker reload` commands will then be run reload the docker envrioment.

##### 4) Seed data
Seed data will not be automatically applied but will require a user to manaully apply it using the `php artisan db:seed --class={data_source}`.
