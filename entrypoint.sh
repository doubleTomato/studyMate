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
# 캐시 초기화 및 재생성
cd /var/www/html
#php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache

exec php-fpm