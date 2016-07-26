FROM php:7

WORKDIR /code

COPY . /code/

RUN curl -sS https://getcomposer.org/installer | php \
  && mv /code/composer.phar /usr/local/bin/composer \
  && composer install

ENTRYPOINT php /code/run.php --data=/data
