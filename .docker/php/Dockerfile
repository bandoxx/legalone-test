FROM php:8.1-fpm

RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            cron \
            nano \
            zlib1g-dev \
            libzip-dev \
            unzip \
            supervisor; \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y librabbitmq-dev && pecl install amqp
RUN docker-php-ext-enable amqp

RUN docker-php-ext-install zip pdo pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer;

COPY ./.docker/php/conf/crontab /etc/crontab
RUN chmod 0644 /etc/crontab
RUN touch /var/log/cron.log
RUN crontab /etc/crontab

WORKDIR /var/www/html

EXPOSE 9000

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]