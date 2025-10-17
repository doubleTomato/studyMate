#!/bin/sh
set -e

echo "start php-fpm"
php-fpm &

mkdir -p /var/log/nginx

echo "sleep 2"
sleep 2

echo "start nginx..."
# Nginx 실행
nginx -g 'daemon off;'