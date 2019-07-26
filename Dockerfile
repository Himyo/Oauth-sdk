FROM php:apache

RUN apt-get update && apt-get install -y git vim
RUN a2enmod rewrite && service apache2 restart