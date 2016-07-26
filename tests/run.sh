#!/bin/bash
echo "Starting tests" >&1
php --version \
    && composer --version \
    && composer install --dev \
    && /code/vendor/bin/phpcs --standard=psr2 -n --ignore=vendor --extensions=php . \
    && /code/vendor/bin/phpunit --coverage-clover build/logs/clover.xml \
    && /code/vendor/bin/test-reporter
