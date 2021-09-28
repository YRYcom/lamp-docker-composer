# LAMP Docker compose

A LAMP stack environment built using Docker Compose. It consists of the following:

* nginx
* mariadb
* php


##  Installation
 
* Clone this repository on your local computer
* configure .env with .env.default 
* Run the `make start`.

```shell
git clone https://github.com/yrycom/lamp-docker-compose.git
cd lamp-docker-compose/
make init
// and customize .env file
make start
// visit http://127.0.0.1 with ${NGINX_PORT} equal 127.0.0.1:80
```

##  WIREMOCK

The default admin is http://localhost:8080/__admin/swagger-ui with ${WIREMOCK_PORT} equal 127.0.0.1:8080 in .env
Url list of mappings is http://localhost:8080/__admin/

With ${WIREMOCK_PORT} equal 127.0.0.1:8080 in .env