# Dragonfly

```
    ____                               ______     
   / __ \_________ _____ _____  ____  / __/ /_  __
  / / / / ___/ __ `/ __ `/ __ \/ __ \/ /_/ / / / /
 / /_/ / /  / /_/ / /_/ / /_/ / / / / __/ / /_/ / 
/_____/_/   \__,_/\__, /\____/_/ /_/_/ /_/\__, /  
                 /____/                  /____/
```

Dragonfly is a web-based application designed to collect metrics to help measure browser privacy impact.

## Features

- Collects various metrics related to browser privacy.
- Provides insights into user browser fingerprinting techniques and tracking prevention measures.

### Client IP Address Handling

- Dragonfly retrieves client IP addresses using `$_SERVER['HTTP_CLIENT_IP']` and `$_SERVER['REMOTE_ADDR']` variables.
- It also attempts to retrieve forwarded IP addresses from common headers (`HTTP_X_FORWARDED_FOR`, `HTTP_X_FORWARDED`, `HTTP_FORWARDED_FOR`, `HTTP_FORWARDED`).

### Browser Fingerprinting

- Dragonfly utilizes the ClientJS library to collect various browser fingerprinting metrics.
- It retrieves and displays information such as browser fingerprint, user agent, browser engine, operating system, device information, screen resolution, plugins, fonts, local storage availability, session storage availability, cookie support, timezone, language, system language, and canvas print.
- Dragonfly stores previous values of data points in session storage and highlights changes in UI to detect differences in browser configurations.

## Build

To build the container image `webpwnized/dragonfly:www`, follow these steps:

1. Clone the repository:

   ```
   git clone https://github.com/webpwnized/dragonfly.git
   ```

2. Navigate to the project root:

   ```
   cd dragonfly
   ```

3. Build the container image using Docker:

   ```
   docker build --file .build/www/Dockerfile --tag webpwnized/dragonfly:www .
   ```

## Run

To run Dragonfly using Docker Compose:

1. From the project root, run:

   ```
   docker compose --file .build/docker compose.yml up --detach
   ```

2. Once the containers are running, you can access the following services on localhost:

   - Port 80, 8088: Dragonfly HTTP web interface

## Deployment

Dragonfly can be deployed to various platforms using the following methods:

- **Docker Compose:** Use the provided Docker Compose file to deploy Dragonfly locally or to a Docker Swarm.
- **DockerHub:** Pre-built container images are available on DockerHub for easy deployment.
- **Google Cloud Platform (GCP):** Use the provided Terraform Infrastructure as Code (IaC) to deploy Dragonfly to GCP.

For detailed deployment instructions, refer to the respective project repositories:

- [Dragonfly Docker project](https://github.com/webpwnized/dragonfly-docker)
- [Dragonfly DockerHub project](https://github.com/webpwnized/dragonfly-dockerhub)
- [Dragonfly Terraform project](https://github.com/webpwnized/dragonfly-terraform)

## Files

### `LICENSE`

- The `LICENSE` file contains the license under which the Dragonfly project is distributed. It specifies the terms and conditions for the permitted use, modification, and distribution of the project.

### `README.md`

- The `README.md` file provides an overview of the Dragonfly project, including its purpose, features, build and run instructions, security considerations, deployment options, and links to related repositories.

### `src`

- The `src` directory contains the source code of the Dragonfly web application.

  - `css`: Contains CSS stylesheets used for styling the web interface.
  
  - `images`: Contains images used in the web interface, including the Dragonfly icon.
  
  - `javascript`: Contains JavaScript files used for client-side scripting.
  
    - `client.base.min.js`: Minified version of the ClientJS library, used for collecting browser fingerprinting metrics.
    
    - `client.base.min.js.map`: Source map for the minified ClientJS library.
    
    - `client.flash.min.js`: Minified version of the Flash detection module of ClientJS.
    
    - `client.flash.min.js.map`: Source map for the minified Flash detection module.
    
    - `client.java.min.js`: Minified version of the Java detection module of ClientJS.
    
    - `client.java.min.js.map`: Source map for the minified Java detection module.

### `tools`

- The `tools` directory contains scripts and tools related to the Dragonfly project.

  - `git.sh`: Shell script for performing Git operations, possibly related to version control.
  
  - `push-development-branch.sh`: Shell script for pushing changes to a development branch, possibly for deployment purposes.
