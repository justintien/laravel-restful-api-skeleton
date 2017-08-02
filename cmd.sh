#!/bin/bash

__DIR__=$( dirname "${BASH_SOURCE[0]}" )
source $__DIR__/global.sh

docker exec ${DOCKER_SERVER_NAME} php artisan "$@"
