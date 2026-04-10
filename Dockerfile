# -------------------------
# Étape 1 : build (composer + npm)
# -------------------------
FROM php:8.4-fpm-alpine AS build

# Dépendances système pour PHP et Node
RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    g++ \
    make \
    bash \
    git \
    curl \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    zlib-dev\
    imagemagick-dev

# Extensions PHP
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg



# Extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo_pgsql bcmath intl zip pcntl gd

# Installer Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Installer Imagick extension
RUN pecl install imagick && docker-php-ext-enable imagick

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier composer.json pour cache
COPY composer.json composer.lock ./

# Copier tout le projet
COPY . .

# Installer les dépendances PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist \
    --no-interaction \
    --no-progress

# lancer scripts laravel
RUN php artisan package:discover

# Build assets Vite
RUN npm install && npm run build

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# -------------------------
# Étape 2 : production
# -------------------------
FROM php:8.4-fpm-alpine AS production

# Dépendances système runtime seulement
RUN apk add --no-cache \
    bash \
    postgresql-libs \
    icu \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    libxml2 \
    oniguruma \
    curl\
    imagemagick

# copier extensions PHP compilées
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copier tout le projet
COPY --from=build /var/www/html /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Activer OPCache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 9000

CMD ["php-fpm"]