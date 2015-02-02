# Cheatsheet

## Installation
```
$ curl -sSL https://get.docker.com/ | sh
```
## Building an image
```
$ sudo docker build -t httpserver
```
## Run a container
```
$ sudo docker run -p 8081:80 -v /home/simont/dockerfiles/apache/www/:/var/www/site/ -d --name web httserver
```
## Connect to a running container
```
$ sudo docker attach --sig-proxy=true insane_bardeen
```
## Remove all images
```
$ sudo docker images -a -q | xargs docker rmi
```
## Remove Stopped Containers
```
$ sudo docker ps -a | awk '/Exit/ {print $1}' | xargs docker rm
```
## Remove all containers (including running containers)
```
$ sudo docker ps -q -a | xargs docker rm
```
