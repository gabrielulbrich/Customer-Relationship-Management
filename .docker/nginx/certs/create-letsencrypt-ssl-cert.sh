#!/bin/bash
# maintainer: gabriel_ulbrich@outlook.com

. .env

if [ $# -eq 2 ]; then
  DOMAIN="$1 -d $2"
elif [ $# -eq 1 ]; then
  DOMAIN="$1"
else
  echo "usage: create-letsencrypt-ssl-cert.sh <domain>"
fi

# this folder needs to exist
[ ! -d letsencrypt ] && mkdir letsencrypt

docker run --rm -it --mount type=bind,source="$(pwd)"/letsencrypt,target=/etc/letsencrypt -p 443:443 \
  certbot/certbot certonly \
  --debug \
  --manual \
	--preferred-challenges=dns \
	-m $EMAIL \
	--agree-tos \
  --no-eff-email \
  --no-verify-ssl \
	-d $DOMAIN
