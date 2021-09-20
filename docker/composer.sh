#!/bin/bash
export COMPOSER_CACHE_DIR="/var/www/.composer/cache"
export COMPOSER_HOME="/var/www/.composer"
export COMPOSER_MEMORY_LIMIT="-1"
composer $*
