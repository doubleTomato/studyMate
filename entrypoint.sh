#!/bin/sh
set -e
set -x # 디버깅 용

# 캐시 초기화 및 재생성
cd /var/www/html/src

rm -f .env

echo " APP_ENV: $APP_ENV"
echo "=========================================="

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
# php artisan config:cache


php artisan config:cache --env=production

echo "start php-fpm"
php-fpm -D

mkdir -p /var/log/nginx

echo "sleep 5"
sleep 5

echo "start nginx..."
# Nginx 실행
nginx -g 'daemon off;'


exec php-fpm