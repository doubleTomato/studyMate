FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
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

WORKDIR /var/www/html

COPY . .

RUN mkdir -p bootstrap/cache

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 복사
COPY entrypoint.sh /usr/local/bin/

# 권한부여
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["entrypoint.sh"]