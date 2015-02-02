# Cheatsheet

## Run a container
```
$ sudo docker run -p 8081:80 -v /srv/dock1/app/wordpress/:/var/www/html/ -d -i -t chris/clc0317.oit /bin/bash
```

## Connect to a running container
```
$ sudo docker attach --sig-proxy=true insane_bardeen
```
## Remove all images
```
$ docker images -a -q | xargs docker rmi
```

## Remove Stopped Containers
```
$ docker ps -a | awk '/Exit/ {print $1}' | xargs docker rm
```

## Remove all containers (including running containers)
```
$ docker ps -q -a | xargs docker rm
```
