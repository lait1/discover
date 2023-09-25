FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    cron \
    nano \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql zip

RUN echo "* * * * * /usr/local/bin/php /symfony/bin/console parse:exchange" > /etc/cron.d/symfony-cron
RUN chmod 0644 /etc/cron.d/symfony-cron
RUN crontab /etc/cron.d/symfony-cron

CMD ["cron", "-f"]