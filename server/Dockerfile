FROM php:7.2.10-fpm

USER root

RUN apt -y update && apt install -y dos2unix && apt install zip unzip tree

# Required for working with Postgres
# libq est nécessaire pour instalelr pgsql
# gnupg2 sert pour installer Yarn. Ca code les choses envoyés par curl.
RUN apt-get update
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql pgsql \
&& apt-get install gnupg2 && apt-get install apt-transport-https

# Install yarn
# Add yarn repository
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
&& sudo apt-get update && sudo apt-get install yarn

# Install nodeJS to be able to run Yarn
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && apt-get install -y nodejs

RUN mkdir /var/www/html/code

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" && \
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;" && \
php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
rm /tmp/composer-setup.php

COPY ./docker-entrypoint.sh /

RUN chmod 777 /docker-entrypoint.sh

RUN dos2unix /docker-entrypoint.sh

COPY ./symfony/php-fpm_conf/etc /usr/local/etc
COPY ./application /var/www/html/code

WORKDIR /var/www/html/code

ENTRYPOINT ["/docker-entrypoint.sh"]
