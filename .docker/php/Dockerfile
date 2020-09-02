FROM php:7.0-fpm
LABEL maintainer="gabriel_ulbrich@outlook.com"

WORKDIR /var/www/html

# set timezone
ENV TZ America/Sao_Paulo 
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Get composer ~ /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=./.composer
ENV COMPOSER_MEMORY_LIMIT=-1

# Install additional packages
RUN apt-get update && apt-get install -y \
    vim-tiny procps cron wget zip unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/
COPY etc/crontab.conf /tmp/
RUN grep -v "^#" /tmp/crontab.conf | crontab 

# php-fpm settings, php.ini is into www.conf
COPY etc/www.conf /usr/local/etc/php-fpm.d/

# entrypoint script
COPY ./scripts/health-check*.php /tmp/
COPY ./scripts/docker-entrypoint.sh /
RUN chmod 775 /docker-entrypoint.sh

ENTRYPOINT [ "/docker-entrypoint.sh" ]

CMD ["php-fpm"]