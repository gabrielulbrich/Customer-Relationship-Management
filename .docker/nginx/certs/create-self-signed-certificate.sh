#!/usr/bin/env bash

# maintainer: gabriel_ulbrich@outlook.com
# references: https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/configuring-https-ssl.html
#             https://gist.github.com/andrewconnell/6c2c14e80ef45b232d11e2f4706489b5

. .env
DOMAIN=$1

if [ $# -ne 1 -o "$DOMAIN" = "" ]; then
  cat<<EOF
usage: create-self-signed-certificate.sh <domain>

Please check .env file, need these variables:
COUNTRY=BR 
STATE=Parana 
CITY=Curitiba 
ORG="Ciencia da Computacao"
DEPTO="Technology"
EMAIL="gabriel_ulbrich@outlook.com"
EOF
  exit
fi

NAME=$(echo $DOMAIN | sed 's/\./-/g')

# this folder needs to exist
[ ! -d selfsigned ] && mkdir selfsigned

cd selfsigned

if [ "$DOMAIN" = "localhost" ]; then
  ALTERNATE_NAMES="DNS.1=localhost"$'\n'"DNS.2=localhost.localdomain"$'\n'"DNS.3=127.0.0.1"
else
  ALTERNATE_NAMES="DNS.1=$DOMAIN"$'\n'"DNS.2=www.$DOMAIN"
fi

cat <<EOF >/tmp/openssl.cnf
[ req ]
default_bits        = 2048
default_keyfile     = $NAME.key
distinguished_name  = subject
req_extensions      = req_ext
x509_extensions     = x509_ext
string_mask         = utf8only

# The Subject DN can be formed using X501 or RFC 4514 (see RFC 4519 for a description).
#   Its sort of a mashup. For example, RFC 4514 does not provide emailAddress.
[ subject ]
countryName         = Country Name (2 letter code)
countryName_default = $COUNTRY

stateOrProvinceName         = State or Province Name (full name)
stateOrProvinceName_default = $STATE

localityName          = Locality Name (eg, city)
localityName_default  = $CITY

organizationName         = Organization Name (eg, company)
organizationName_default = $ORG

# Use a friendly name here because its presented to the user. The server's DNS
#   names are placed in Subject Alternate Names. Plus, DNS names here is deprecated
#   by both IETF and CA/Browser Forums. If you place a DNS name here, then you
#   must include the DNS name in the SAN too (otherwise, Chrome and others that
#   strictly follow the CA/Browser Baseline Requirements will fail).
commonName          = Common Name (e.g. server FQDN or YOUR name)
commonName_default  = $DOMAIN

emailAddress         = Email Address
emailAddress_default = $EMAIL

# Section x509_ext is used when generating a self-signed certificate. I.e., openssl req -x509 ...
[ x509_ext ]

subjectKeyIdentifier    = hash
authorityKeyIdentifier  = keyid,issuer

# You only need digitalSignature below. *If* you don't allow
#   RSA Key transport (i.e., you use ephemeral cipher suites), then
#   omit keyEncipherment because that's key transport.
basicConstraints  = CA:FALSE
keyUsage          = digitalSignature, keyEncipherment
subjectAltName    = @alternate_names
nsComment         = "OpenSSL Generated Certificate"

# RFC 5280, Section 4.2.1.12 makes EKU optional
#   CA/Browser Baseline Requirements, Appendix (B)(3)(G) makes me confused
#   In either case, you probably only need serverAuth.
# extendedKeyUsage  = serverAuth, clientAuth

# Section req_ext is used when generating a certificate signing request. I.e., openssl req ...
[ req_ext ]

subjectKeyIdentifier        = hash

basicConstraints    = CA:FALSE
keyUsage            = digitalSignature, keyEncipherment
subjectAltName      = @alternate_names
nsComment           = "OpenSSL Generated Certificate"

# RFC 5280, Section 4.2.1.12 makes EKU optional
#   CA/Browser Baseline Requirements, Appendix (B)(3)(G) makes me confused
#   In either case, you probably only need serverAuth.
# extendedKeyUsage  = serverAuth, clientAuth

[ alternate_names ]

$ALTERNATE_NAMES

# DNS.1       = example.com
# DNS.2       = www.example.com
# DNS.3       = mail.example.com
# DNS.4       = ftp.example.com

# Add these if you need them. But usually you don't want them or
#   need them in production. You may need them for development.
# DNS.5       = localhost
# DNS.6       = localhost.localdomain
# DNS.7       = 127.0.0.1

# IPv6 localhost
# DNS.8     = ::1
EOF

openssl genrsa 2048 > $NAME.key
openssl req -new -key $NAME.key -out $NAME.csr -config /tmp/openssl.cnf
#openssl x509 -req -days 365 -in $NAME.csr -signkey $NAME.key -out $NAME.crt

rm /tmp/openssl.cnf
