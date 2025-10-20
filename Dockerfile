# node build관련 추가
FROM node:18 AS build
WORKDIR /app

COPY src/package*.json src/vite.config.js ./

RUN npm ci

# 복사후 build
COPY src/resources ./resources
COPY src/public ./public
RUN npm run build


# php + nginx
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

RUN docker-php-ext-install bcmath opcache
RUN docker-php-ext-install exif
RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-freetype \
 && docker-php-ext-install gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/src

COPY . .


# build파일 복사
COPY --from=build /app/public/build ./public/build

RUN mkdir -p src/bootstrap/cache

RUN chown -R www-data:www-data src/storage src/bootstrap/cache
RUN chmod -R 775 src/storage src/bootstrap/cache

# 복사
COPY nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf


COPY entrypoint.sh /usr/local/bin/

# 권한부여
RUN chmod +x /usr/local/bin/entrypoint.sh


CMD ["entrypoint.sh"]
#에러확인용
#CMD ["sleep", "infinity"]


EXPOSE 8080