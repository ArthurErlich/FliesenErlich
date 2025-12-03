FROM php:8.4-apache-bookworm

ARG TARGETARCH

# Abhängigkeiten und Tools
RUN apt-get update -y && apt-get install --no-install-recommends -y libc-client-dev libkrb5-dev libfreetype6-dev \
  libjpeg62-turbo-dev libwebp-dev libmcrypt-dev libpng-dev libxslt1-dev libsodium-dev \
  libzip-dev libldap2-dev libonig-dev zip rsync wget git nano webp dos2unix \
  \
  # MySQL CLI Tools (DB Dump Handling)
  default-mysql-client && \
  rm -rf /var/lib/apt/lists/*

## Install supported PHP extensions
# Install the helper script used to install many PHP extensions
# (https://github.com/mlocati/docker-php-extension-installer)
RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o /usr/local/bin/install-php-extensions && \
  chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions imap iconv sodium mysqli pdo_mysql gd opcache zip ldap mbstring bcmath intl gmp soap sockets xdebug apcu amqp pcntl solr ftp

# PHP Config
COPY ./php/php.ini /usr/local/etc/php/conf.d/user2.ini

# Apache Config
COPY ./apache/server.crt /etc/ssl/certs/server.crt
COPY ./apache/server.key /etc/ssl/certs/server.key
COPY ./apache/000-default.conf /etc/apache2/sites-enabled/
COPY ./apache/default-ssl.conf /etc/apache2/sites-enabled/

# Composer including workaround for WSL
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --2 && \
  chown -R www-data:www-data /usr/local/etc/php/conf.d && \
  chmod -R a+w /usr/local/etc/php/conf.d && \
  mkdir -p /.composer/cache && \
  chmod -R a+w /.composer && \
  mkdir -p /var/www/.composer/cache && \
  chown -R www-data:www-data /var/www && \
  chmod -R a+w /usr/local/bin/

# Fix git unsave directory error
RUN git config --system --add safe.directory /var/www/html && \
  # Fix ld config
  ldconfig && \
  # Enable apache2-foreground modules
  a2enmod rewrite expires headers ssl

# Environment Variables
ENV COMPOSER_ALLOW_SUPERUSER=1

# Entrypoint script
COPY ./entrypoint.sh /usr/local/bin/
RUN dos2unix /usr/local/bin/entrypoint.sh && \
  chmod u+x /usr/local/bin/entrypoint.sh && \
  ln -s /usr/local/bin/entrypoint.sh / # backwards compat
ENTRYPOINT ["entrypoint.sh"]

# Default command from php docker repository
CMD ["apache2-foreground"]
