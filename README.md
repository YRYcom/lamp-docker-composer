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
cp .env.default .env
// and modify
make start
// visit http://localhost
```
