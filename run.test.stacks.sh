#!/bin/bash

__DIR__=$( dirname "${BASH_SOURCE[0]}" )

if command -v reallink;then
	__DIR__=`reallink -f $__DIR__`
elif command -v grealpath;then
	__DIR__=`grealpath $__DIR__`
else
	__DIR__=`pwd`
fi

source $__DIR__/global.sh

$__DIR__/cleanup.stacks.sh


# run mysql
echo [${CONTAINER_NAME_LIST[0]}] starting
docker run \
-d \
--name ${CONTAINER_NAME_LIST[0]} \
-e MYSQL_ALLOW_EMPTY_PASSWORD=yes \
mysql:5.7
echo [${CONTAINER_NAME_LIST[0]}] started

# run php

FROM_APP_ROOT=$(pwd)/
FROM_DATA_ROOT=$(pwd)/../${REPO}
TO_ROOT=/var/www

echo [${CONTAINER_NAME_LIST[1]}] starting
docker run \
-d \
--restart=always \
--name ${CONTAINER_NAME_LIST[1]} \
--link ${CONTAINER_NAME_LIST[0]}:mysql \
-p ${DOCKER_SERVER_PORT}:80 \
-v ${FROM_APP_ROOT}:${TO_ROOT}/html \
-v ${FROM_DATA_ROOT}.storage:${TO_ROOT}/${REPO}.storage \
nutspie/php:7-apache
echo [${CONTAINER_NAME_LIST[1]}] started

echo '##################################################'
echo '# remember!'
echo '# step 1: echo "create database '${DOCKER_DB_DATABASE}'" | docker exec -i '${CONTAINER_NAME_LIST[0]}' mysql'
echo '# step 2: ./cmd.sh migrate:install && ./cmd.sh migrate'
echo '##################################################'

exit 0
