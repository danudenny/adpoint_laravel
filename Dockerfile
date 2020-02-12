FROM php:7.2
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring mysqli pdo_mysql
WORKDIR /app
COPY . /app
RUN composer install --ignore-platform-reqs

CMD php artisan config:cache; php artisan serve --host=0.0.0.0 --port=8188
EXPOSE 8188