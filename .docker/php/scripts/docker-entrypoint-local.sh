#!/bin/bash

# change to workdir
cd /var/www/html

# maintenance mode ON
#cp /tmp/health-check-500.php health-check.php

# running composer
[ -f composer.json ] && composer install

# maintenance mode OFF
#cp /tmp/health-check.php .
echo "App is ready..."

exec "$@"
