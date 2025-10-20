#!/bin/sh
set -e
set -x # 디버깅 용

# 캐시 초기화 및 재생성
cd /var/www/html/src

mkdir -p /var/www/html/src/storage/framework/views
chown -R www-data:www-data /var/www/html/src/bootstrap/cache /var/www/html/src/storage
#php artisan config:cache --env=production

echo "start php-fpm"
php-fpm -D

mkdir -p /var/log/nginx

echo "sleep 5"
sleep 5

echo "start nginx..."
# Nginx 실행
nginx -g 'daemon off;'
