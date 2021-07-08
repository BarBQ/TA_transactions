FROM yiisoftware/yii2-php:7.4-fpm

# Install modules
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libmagickwand-dev \
        libmagickcore-dev \
        libpng-dev \
        libxslt1-dev \
        zip unzip graphviz \
        iproute2 \
        --no-install-recommends

RUN usermod -u 1000 www-data && chown -R www-data:www-data ~www-data

RUN rm -rf /usr/local/etc/php-fpm.d
COPY ./pools /usr/local/etc/php-fpm.d
COPY ./php.ini /usr/local/etc/php/
COPY ./php-fpm.conf /usr/local/etc/php-fpm.conf

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/bin

CMD ["php-fpm"]
