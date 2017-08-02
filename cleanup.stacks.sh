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

#####################
# cleanup container #
#####################

for n in ${CONTAINER_NAME_LIST[@]}; do
    echo [$n] check
    state=`docker inspect -f {{.State.Status}} ${n}`
    code=$?
    if [ $code -eq 0 ];then
        echo [$n] exist
        echo [$n] removing
        docker rm --force $n
        echo [$n] removed
    fi
done