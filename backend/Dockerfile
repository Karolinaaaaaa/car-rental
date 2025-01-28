FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  libicu-dev \
  libpq-dev \
  libonig-dev \
  libzip-dev \
  && docker-php-ext-install intl pdo pdo_mysql opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /app

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
