#!/bin/sh

set -e

echo "php-fpm"

set +e
php-fpm &

sleep 2; # php-fpm 소켓 파일 생성 시간동안 잠깐 멈춤

set -e

echo "php-fpm 끝 ngix시작"
nginx -g 'daemon off;'