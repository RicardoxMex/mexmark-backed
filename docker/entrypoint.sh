#!/bin/sh
set -eu

if [ "${AUTO_GENERATE_APP_KEY:-false}" = "true" ]; then
  if [ -f /var/www/html/.env ]; then
    if ! grep -q "^APP_KEY=base64:" /var/www/html/.env; then
      php /var/www/html/artisan key:generate --force
    fi
  fi
fi

exec "$@"
