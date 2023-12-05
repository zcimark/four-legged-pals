FROM --platform=linux/amd64 php:8.3-apache as base
WORKDIR /var/www/html
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo 'Mutex posixsem' >> /etc/apache2/apache2.conf

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get -y --no-install-recommends install apt-utils libxml2-dev gnupg apt-transport-https \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update \
    && apt-get install -y \
    nodejs \
    npm \
    git \
    gnupg \
    libpq-dev \
    libzip-dev \
    zip \
    redis \
    libz-dev \
    ssl-cert \
    libmemcached-dev \
    libmemcached11 \
    libmemcachedutil2 \
    build-essential \
    curl \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && cat /usr/local/etc/php/php.ini \
    && pear config-set php_ini /usr/local/etc/php/php.ini \
    && pecl install redis memcached \
    && apt-get remove -y build-essential libmemcached-dev libz-dev \
    && RUN yes | pecl install xdebug \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /tmp/pear \
    && docker-php-ext-install \
    iconv \
    pdo \
    pdo_pgsql \
    pgsql \
    intl \
    zip \
    && echo "XDEBUG_ENABLED=0" > /usr/local/etc/php/php.ini \
    && apt-get clean all

RUN docker-php-ext-enable redis
RUN docker-php-ext-install opcache

RUN apt-get update && apt-get install -y ca-certificates curl gnupg
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
     | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg; \
    NODE_MAJOR=18; \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" \
     > /etc/apt/sources.list.d/nodesource.list;
RUN apt-get update && apt-get install nodejs -y

RUN mkdir -p /var/www/var/cache/prod
RUN mkdir -p /var/www/var/log
RUN chown www-data:www-data /var/www/var/cache/prod /var/www/var/log

RUN a2enmod ssl \
    && a2ensite default-ssl.conf \
    && a2enmod rewrite headers

#RUN pear config-set php_ini /var/www/docker/php.ini
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/bin


ENV PHP_TIMEZONE America/Los Angeles
ENV PATH /root/.composer/vendor/bin:$PATH
EXPOSE 9000
EXPOSE 80
EXPOSE 443

FROM base as production
ENV DOCKER_ENV=production
COPY ./public /var/www/html
COPY . /var/www
COPY ./docker/php-production-mods.ini /usr/local/etc/php/conf.d/php-production.ini