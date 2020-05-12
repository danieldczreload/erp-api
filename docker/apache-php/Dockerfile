FROM php:7.2.30-apache
RUN docker-php-ext-install mysqli pdo_mysql
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y fish
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/php.ini
COPY conf/000-default.conf /etc/apache2/sites-available/000-default.conf
