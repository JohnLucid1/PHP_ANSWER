FROM php:apache
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql

RUN a2enmod rewrite
RUN echo "Alias /api/v1/notebook /var/www/html" >> /etc/apache2/apache2.conf
RUN service apache2 restart
