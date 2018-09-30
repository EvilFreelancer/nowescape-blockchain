FROM evilfreelancer/dockavel:5.7.0

COPY ["./laravel", "/app"]
COPY ["./entrypoint.sh", "./artisan.sh", "/"]

RUN apk add --update --no-cache npm \
 && composer install \
 && npm install \
 && npm run dev \
 && apk del npm \
 && rm -Rf node_modules
