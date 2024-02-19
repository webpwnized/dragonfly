```
    ____                               ______     
   / __ \_________ _____ _____  ____  / __/ /_  __
  / / / / ___/ __ `/ __ `/ __ \/ __ \/ /_/ / / / /
 / /_/ / /  / /_/ / /_/ / /_/ / / / / __/ / /_/ / 
/_____/_/   \__,_/\__, /\____/_/ /_/_/ /_/\__, /  
                 /____/                  /____/
```

### A web-based application designed to collect metrics to help measure browser privacy impact

## Build

To build the container image webpwnized/dragonfly:www, from project root, build with:

    docker build --file .build/www/Dockerfile --tag webpwnized/dragonfly:www .

## Run

Run From project root, run with:

    docker-compose --file .build/docker-compose.yml up --detach
	
Once the containers are running, the following services are available on localhost.

- Port 80, 8088: Dragonfly HTTP web interface

## How to run the application in Docker

 - Build the containers with [the Dragonfly Docker project](https://github.com/webpwnized/dragonfly-docker)
  - Run with Docker Compose
  
## How to run the application from Dockerhub

 - The Docker Compose file is available in [the Dragonfly Dockerhub project](https://github.com/webpwnized/dragonfly-dockerhub)
 - Run the pre-built containers from DockerHub using Docker Compose 

 ## How to deploy the application to Google Cloud

  - The Terraform Infrastructure as Code (IaC) is available from [Dragonfly Terraform project](https://github.com/webpwnized/dragonfly-terraform)