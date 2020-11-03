#!/bin/bash
set -e

# Picking up laradock
if [ ! -e ./laradock ]; then
    echo "Installing laradock..."
    git clone https://github.com/Laradock/laradock.git ./laradock
    rm -rf ./laradock/.git
fi

# Overrides all preferences.
cp -rf ./build/laradock/. ./laradock/
cp -rf ./build/service ./volume/build/

# Docker Compose
BASE_CMD="docker-compose -f ./laradock/docker-compose.yml --env-file=./laradock/.env"
RUN_CMD=$BASE_CMD" exec --user=laradock workspace bash -c "

$BASE_CMD down
$BASE_CMD up -d nginx php-fpm redis mysql
$RUN_CMD "$(cat ./volume/script/bootstrap.sh)"
