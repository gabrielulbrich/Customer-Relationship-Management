# Create new domain free SSL Certificate with LetsEncrypt

Run script
```
$ cd nginx-proxy/certs/
$ ./create-letsencrypt-ssl-cert.sh domain.com.br
```

# Create new domain self-signed certificate

```
$ cd nginx-proxy/certs/
$ ./create-self-signed-certificate.sh domain.com.br
```

# Create localhost self-signed certificate for localhost

```
$ cd nginx-proxy/certs/
$ ./create-self-signed-certificate.sh localhost
```