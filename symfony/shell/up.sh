#!/bin/bash
if [ ! -f "./.env" ]; then
  touch .env
fi
composer install
if [ $?  -ne 0 ]; then
  echo "Composer failed"
  exit 1
fi
if [ ! -f "./config/jwt/private.pem" ] || [ ! -f "./config/jwt/public.pem" ]; then
  echo "Generating JWT keys..."
  read -s -p "Enter JWT pass phrase please: " REPLY
  echo "" > ./.env
  echo "JWT_PASS_PHRASE=$REPLY" >> ./.env
  echo "JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem" >> ./.env
  echo "JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem" >> ./.env
  bin/console lexik:jwt:generate-keypair
fi

if id "$1" &>/dev/null; then
    echo "adding user $1"
    useradd "$1"
else
    echo "user $1 found"
fi

chown -R "$1:www-data" ./*
