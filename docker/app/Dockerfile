FROM php:7.4-apache

# ドキュメントルートを public に設定する
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# PHP で必要なライブラリをインストール
RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip mariadb-client \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
# Xdebug をインストールして、有効にしている

# composer のインストール
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# ファイルのコピー
COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini

# ./docker/app/xdebug.iniを/usr/local/etc/php/conf.d/xdebug.iniに読み込み
# PHPを実行した時に、xdebug.iniが読み込まれて、設定が反映される
COPY ./docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
