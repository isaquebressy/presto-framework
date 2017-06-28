FROM php:5.6.30-apache

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite