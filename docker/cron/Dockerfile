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

#COPY crontab /etc/cron.d/crontab
#
#RUN chmod 0644 /etc/cron.d/crontab
RUN crontab -l | { cat; echo "*/30 * * * * /usr/local/bin/php /symfony/bin/console parse:serials >> /var/log/cron.log 2>&1"; } | crontab -

RUN touch /var/log/cron.log

CMD cron && tail -f /var/log/cron.log