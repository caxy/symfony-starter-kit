#!/usr/bin/env bash
mkdir -p var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
caxy1234
caxy1234
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
caxy1234