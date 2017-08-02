#!/bin/bash

__DIR__=$( dirname "${BASH_SOURCE[0]}" )
source $__DIR__/global.sh

docker exec -it ${DOCKER_DB_NAME} mysql --default-character-set=utf8 ${DOCKER_DB_DATABASE}
