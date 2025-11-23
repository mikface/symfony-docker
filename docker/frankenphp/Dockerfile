FROM dunglas/frankenphp:php8.5

# Install system dependencies and PHP extensions
# FrankenPHP is based on Alpine (usually) or Debian, the official image includes 'install-php-extensions' script
RUN install-php-extensions \
    pdo_pgsql \
    intl \
    zip \
    opcache

# Set timezone (matching your previous args request)
RUN echo "date.timezone=Europe/Prague" > /usr/local/etc/php/conf.d/timezone.ini

# Copy the Caddyfile (if you want custom Caddy config, otherwise the default works for most)
# We will rely on the default behavior or the mounted Caddyfile in docker-compose
# COPY docker/frankenphp/Caddyfile /etc/caddy/Caddyfile

WORKDIR /app

# In development, we usually mount the volume in docker-compose.
# However, permissions might be needed.
# formatting for Caddy to run correctly
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD [ "frankenphp", "run", "--config", "/etc/caddy/Caddyfile" ]