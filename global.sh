#!/bin/bash

# 仓库名称 & APP_NAME & 挂载 storage 的路径 ../$REPO.storage
REPO=laravel-restful-api-skeleton

# run docker php name
DOCKER_SERVER_NAME=laravel-restful-api-skeleton
DOCKER_SERVER_PORT=3100

# run docker db name
DOCKER_DB_NAME=laravel-mysql
DOCKER_DB_DATABASE=laravel

CONTAINER_NAME_LIST=(
${DOCKER_DB_NAME}
${DOCKER_SERVER_NAME}
)