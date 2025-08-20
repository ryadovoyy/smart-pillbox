FROM php:8.4-cli

RUN apt-get update && apt-get install --no-install-recommends -y \
    libpq-dev \
    procps \
    dos2unix \
    cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app

COPY . .

COPY cron/yii-cron /etc/cron.d/yii-cron

RUN dos2unix /etc/cron.d/yii-cron

RUN chmod 0644 /etc/cron.d/yii-cron

CMD ["cron", "-f"]
