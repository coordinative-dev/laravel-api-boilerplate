FROM php:7.3-fpm

ARG HOST_UID=1000

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y gnupg2

RUN apt-get update && apt-get install -y apt-utils
RUN apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        libpcre3-dev \
        git \
        nano \
        zip \
        cron \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        supervisor \
        libzip-dev \
    && docker-php-ext-install -j$(nproc) iconv exif bcmath intl zip pgsql pdo_pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo Europe/London > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata

# Install Xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
    > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install node.js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
    && DEBIAN_FRONTEND=noninteractive apt-get install nodejs --no-install-recommends -yqq

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn

COPY ./.bashrc /root/.bashrc
COPY ./php.ini /usr/local/etc/php/

# Install composer
RUN set -x && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN usermod -u ${HOST_UID} www-data && groupmod -g ${HOST_UID} www-data && chsh -s /bin/bash www-data

# Setup cron
ADD ./crontab /etc/cron.d/cron-jobs
RUN chmod 0644 /etc/cron.d/cron-jobs && touch /var/log/cron.log

# setup supervisor
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000

CMD ["/usr/bin/supervisord"]
