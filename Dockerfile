FROM node:18 AS build

# 기본 값 설정
ARG VITE_APP_ENV="production"
ENV VITE_APP_ENV=${VITE_APP_ENV}

# node build관련 추가
WORKDIR /app/src

COPY src/package*.json src/vite.config.js ./


RUN npm ci

COPY src/ ./
# 복사후 build
# COPY src/resources ./resources
# COPY src/public ./public
RUN npm run build


FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    unzip \
    git \
    curl \
    vim \
    iputils-ping \
    telnet \
    netcat-traditional \
&& rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

RUN docker-php-ext-install bcmath opcache
RUN docker-php-ext-install exif
RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-freetype \
 && docker-php-ext-install gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

#캐시 파일 강제로 삭제
RUN rm -f src/bootstrap/cache/*.php

# composer 설치 주석 제거
RUN cd src && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# build 파일 복사 경로를 ./src/public/build 로 변경
COPY --from=build /app/src/public/build ./src/public/build

# 제대로 복사되었느지 확인
RUN ls -l /var/www/html/css/public/build

RUN rm -f /var/www/html/src/public/hot

RUN mkdir -p src/bootstrap/cache

RUN chown -R www-data:www-data src/storage src/bootstrap/cache src/public/build
RUN chmod -R 775 src/storage src/bootstrap/cache

# 복사
COPY nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /usr/local/bin/

# 권한부여
RUN chmod +x /usr/local/bin/entrypoint.sh

# window줄바꿈 제거 스크립트 오류 방지
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh

CMD ["entrypoint.sh"]
#에러확인용
#CMD ["sleep", "infinity"]

EXPOSE 8080