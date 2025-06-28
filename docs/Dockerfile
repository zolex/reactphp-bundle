FROM php:8.4-cli AS build

RUN apt-get update && apt-get install -y --no-install-recommends \
	acl \
	file \
	gettext \
	git \
    libpq-dev \
    libicu-dev \
    libzip-dev \
	&& rm -rf /var/lib/apt/lists/*

RUN set -eux; \
	docker-php-ext-install \
		intl \
		opcache \
        pcntl \
        pdo_pgsql \
		zip \
	; \
	pecl install apcu \
    ;

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

SHELL ["/bin/bash", "-eo", "pipefail", "-c"]

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

ENV APP_RUNTIME "Zolex\\ReactPhpBundle\\Runtime\\ReactPhpRuntime"
ENV REACT_HOST "0.0.0.0"

COPY . .
RUN composer install

CMD [ "php", "/app/public/index.php" ]
