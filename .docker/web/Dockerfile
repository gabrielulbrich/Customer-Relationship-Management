# ---(stage 1)----------------------------------
FROM node:12-buster-slim AS builder
LABEL maintainer="gabriel_ulbrich@outlook.com"
WORKDIR /app

# install dependencies
COPY ./src/web/package.json .
RUN yarn install --no-optional --production --silent --frozen-lockfile
RUN yarn global add @vue/cli @vue/cli-service-global
# latest react-scripts@3.4.1 dont work in 2020-03-28
# try to update when using

# copy source
COPY ./src/web/ .
RUN yarn build

# ---(stage 2)----------------------------------
FROM nginx:1.17
LABEL maintainer="gabriel_ulbrich@outlook.com"
WORKDIR /app

# install additional packages
RUN apt-get update && apt-get install -y \
  cron \
  curl \
  certbot \
  python-certbot-nginx \
  && apt-get clean && rm -rf /var/lib/apt/list

# nginx settings
COPY ./docker/web/etc/nginx.conf /etc/nginx
COPY ./docker/web/etc/default-production.conf /etc/nginx/conf.d
RUN mkdir -p /var/nginx/cache && chmod 777 /var/nginx/cache

# add crontab settings
ADD ./docker/web/etc/crontab.conf /tmp/crontab.conf
RUN grep -v "^#" /tmp/crontab.conf | crontab -

# copy source
COPY --chown=www-data:www-data ./docker/web/public/ /usr/share/nginx/html
COPY --chown=www-data:www-data --from=builder /app/build/ ./

EXPOSE 80 443
