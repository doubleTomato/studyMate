#!/bin/sh

set -e

echo "php-fpm"

set +e
php-fpm &

set -e

echo "php-fpm 끝 ngix시작"
nginx -g 'daemon off;'