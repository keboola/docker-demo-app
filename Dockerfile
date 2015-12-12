FROM quay.io/keboola/base-php56

ENV APP_VERSION 0.0.2

WORKDIR /home

# Initialize 
COPY . /home/
RUN composer install --no-interaction

ENTRYPOINT php ./src/run.php --data=/data
