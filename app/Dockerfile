FROM php:7.2-apache

# change time zone
ENV TZ Asia/Tokyo

RUN a2enmod rewrite
RUN apt-get update
RUN pecl install xdebug

# Install Postgre PDO
# RUN apt-get install -y libpq-dev libicu-dev \
#     && docker-php-ext-configure mysql -with-mysql=/usr/local/mysql \
#     && docker-php-ext-install pdo pdo_mysql mysql mysqli mbstring intl \
#     && apt-get install -y zip unzip

RUN apt-get update && \
    apt-get install -y curl git zip unzip libicu-dev && \ 
    # php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    # php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    # php composer-setup.php && \
    # php -r "unlink('composer-setup.php');" && \
    # mv composer.phar /usr/local/bin/composer && \
    docker-php-ext-install intl pdo_mysql mbstring

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker-config/php.ini /usr/local/etc/php/
COPY ./docker-config/apache2.conf /etc/apache2/
COPY ./docker-config/000-default.conf /etc/apache2/sites-available/

# COPY ./composer.json /var/www/html
# COPY ./composer.lock /var/www/html
# CMD composer install

# Install CakePHP by super user
# ENV COMPOSER_ALLOW_SUPERUSER 1
# ENV COMPOSER_NO_INTERACTION 1
# RUN composer create-project --prefer-dist -n cakephp/app:3.6.0 .
