FROM yiisoftware/yii2-php:8.4-fpm-nginx

COPY --chown=www-data composer.* .

RUN composer install --no-autoloader

COPY --chown=www-data . .

RUN composer dump-autoload
