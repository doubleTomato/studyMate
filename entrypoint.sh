#!/bin/sh
set -e

echo "start php-fpm"
php-fpm -D

mkdir -p /var/log/nginx

echo "sleep 5"
sleep 5

echo "start nginx..."
# Nginx 실행
nginx -g 'daemon off;'