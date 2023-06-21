FROM php:8.1-apache

RUN apt-get update && apt-get upgrade -y \
    libicu-dev

RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

RUN composer install

EXPOSE 80

CMD [ "apache2-foreground" ]
