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

exec "$@"
