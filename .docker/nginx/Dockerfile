FROM nginx:1.17
LABEL maintainer="gabriel_ulbrich@outlook.com"

# install additional packages
RUN apt-get update && apt-get install -y \
    cron \
    curl \
    certbot \
    python-certbot-nginx \
    && apt-get clean && rm -rf /var/lib/apt/list 

# add nginx settings
COPY ./docker/nginx/etc/nginx.conf /etc/nginx/
COPY ./docker/nginx/etc/default-production.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/nginx/cache && chmod 777 /var/nginx/cache

# add crontab settings
ADD ./docker/nginx/etc/crontab.conf /tmp/crontab.conf
RUN grep -v "^#" /tmp/crontab.conf | crontab -

EXPOSE 80 443