FROM php:8.2.0 as php

RUN apt-get update -y 
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmatch

WORKDIR /app
COPY . .

COPY package*.json ./

# COPY --from=composer:2.4.2 /usr/bin/composer /usr/bin/composer

ENV PORT=8000

CMD [ "npm", "start" ]
# ENTRYPOINT [ "docker/entrypoint.sh" ]