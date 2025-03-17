#!/bin/bash
POSTGRES_ENV_FILE="postgres-variables.env"
SYMFONY_ENV_FILE="symfony-variables.env"
if [ ! -f "$POSTGRES_ENV_FILE" ] || [ ! -f "$SYMFONY_ENV_FILE" ]; then
  #vars
  read -p "Enter APP_ENV value: " APP_ENV
  ROOT_PASSWORD=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c${1:-32};echo;`
  PASSWORD=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c${1:-32};echo;`
  SYMFONY_APP_SECRET=`< /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c${1:-32};echo;`
  USER_DATABASE=`basename $PWD`
  DB_CONTAINER="db"
  #postgres file
  echo "POSTGRES_PASSWORD=$PASSWORD" > "$POSTGRES_ENV_FILE"
  echo "POSTGRES_DB=$USER_DATABASE" >> "$POSTGRES_ENV_FILE"
  echo "POSTGRES_USER=$USER_DATABASE" >> "$POSTGRES_ENV_FILE"
  echo "POSTGRES_VERSION=17" >> "$POSTGRES_ENV_FILE"
  #symfony file
  echo "APP_ENV=$APP_ENV" > "$SYMFONY_ENV_FILE"
  echo "APP_SECRET=$SYMFONY_APP_SECRET" >> "$SYMFONY_ENV_FILE"
  echo "DATABASE_URL=postgresql://$USER_DATABASE:$PASSWORD@$DB_CONTAINER:5432/$USER_DATABASE?serverVersion=17.4" >> "$SYMFONY_ENV_FILE"
  echo 'CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$' >> "$SYMFONY_ENV_FILE"
fi
docker compose up -d
if [ $? -ne 0 ]; then
  echo "Docker compose failed"
  exit 1
fi

# shellcheck disable=SC2046
docker exec -it $(basename $PWD | awk '{print tolower($0)}')-php-1 bash shell/up.sh
