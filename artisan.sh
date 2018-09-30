#!/bin/sh

php /app/artisan migrate --force
php /app/artisan db:seed --force
