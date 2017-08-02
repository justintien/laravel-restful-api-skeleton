#!/bin/bash

__DIR__=$( dirname "${BASH_SOURCE[0]}" )
source $__DIR__/global.sh

if [ -z "$2" ];then
docker exec -it ${DOCKER_SERVER_NAME} vendor/phpunit/phpunit/phpunit -v $1
else
docker exec -it ${DOCKER_SERVER_NAME} vendor/phpunit/phpunit/phpunit -v $1 --filter $2
fi
