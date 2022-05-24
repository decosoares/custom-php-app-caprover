FROM php:7.2-apache
LABEL maintainer="ono.naoyaa@gmail.com"

# Install the required packages and remove the apt cache.
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && \
  apt-get -y install curl git libicu-dev libpq-dev zlib1g-dev zip && \
  docker-php-ext-install intl mbstring pcntl pdo_mysql pdo_pgsql zip

# Enable PHP extensions
#RUN docker-php-ext-install pdo_mysql mysqli

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Add cake command to system path
ENV PATH="${PATH}:/var/www/html/lib/Cake/Console"
ENV PATH="${PATH}:/var/www/html/app/Vendor/bin"

# Copy the code into /var/www/html/ inside the image
COPY . /var/www/html
COPY /master /var/www/html/master

# COPY site conf file
#COPY ./apache/site.conf /etc/apache2/sites-available/000-default.conf

# Set default working directory
#WORKDIR ./app

# Create tmp directory and make it writable by the web server
RUN usermod -u 1000 www-data && \
  usermod -a -G users www-data && \
  chown -R www-data:www-data /var/www/html

RUN mkdir -p \
    master/tmp/cache/models \
    master/tmp/cache/persistent \
  && chown -R :www-data \
    master \
  && chmod -R 777 \
    master 

# Enable Apache modules and restart
RUN a2enmod rewrite \
  && service apache2 restart

EXPOSE 80
