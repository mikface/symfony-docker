#!/bin/bash
if [ ! -f "./.env" ]; then
  touch .env
fi
composer install
if [ $?  -ne 0 ]; then
  echo "Composer failed"
  exit 1
fi
if [ ! -f "./config/jwt/private.pem" ]; then
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
fi

grep -q "JWT_PASS_PHRASE=" .env

if [ $? -eq 1 ]
then
  read -p "Enter jwt pass phrase again please: " REPLY
  echo "" >> ./.env
  echo "JWT_PASS_PHRASE=$REPLY" >> ./.env
  echo "JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem" >> ./.env
  echo "JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem" >> ./.env
  chmod 640 config/jwt/private.pem
fi

if id "$1" &>/dev/null; then
    echo "adding user $1"
    useradd "$1"
else
    echo "user $1 found"
fi

chown -R "$1:www-data" ./*
