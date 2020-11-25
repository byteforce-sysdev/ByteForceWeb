# build environment
FROM php:7.4-fpm as build
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    curl
RUN curl -L https://npmjs.org/install.sh | sh
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
WORKDIR /app
ENV PATH /app/node_modules/.bin:$PATH
COPY package.json ./
COPY composer.json ./
RUN npm install yarn
RUN yarn install
COPY . ./
COPY ./.env.example ./.env
RUN composer self-update --1
RUN composer install \
    --optimize-autoloader \
    --no-interaction
RUN yarn run prod

# production environment
FROM images.docker.byteforce.id/repository/byteforceid-images/nginx-php-fpm:latest
USER root
COPY ./.nginx/nginx.conf /etc/nginx/conf.d/byteforce.id.nginx.conf
COPY --from=build /app /usr/share/nginx/html/byteforceid
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk add --update php7 php7-tokenizer
WORKDIR /usr/share/nginx/html/byteforceid
RUN chmod 777 -R /usr/share/nginx/html/byteforceid
USER nobody
RUN php artisan key:generate
RUN php artisan config:cache