#!/bin/sh
set -e

# Self-update composer on startup, only if NO_COMPOSER_SELFUPDATE is NOT set
if [ -z "${NO_COMPOSER_SELFUPDATE+x}" ]; then
  /usr/local/bin/composer self-update --no-progress --2
fi

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- apache2-foreground "$@"
fi

# Only adjust www-data if USER_ID and GROUP_ID are set
if [ -n "$USER_ID" ] && [ -n "$GROUP_ID" ]; then
    echo "Adjusting www-data UID/GID to $USER_ID:$GROUP_ID"
    # Change group first
    groupmod -o -g "$GROUP_ID" www-data || true
    # Change user and assign to new group
    usermod -o -u "$USER_ID" -g "$GROUP_ID" www-data || true
    # Fix ownership of key directories
    chown -R www-data:www-data /var/www /.composer /usr/local/etc/php/conf.d || true
fi

exec "$@"