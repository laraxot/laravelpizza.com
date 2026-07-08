#!/bin/sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php -r "unlink('composer.lock');"
rm composer.lock
rm package-lock.json

##############  ####################
php -d memory_limit=-1 composer.phar require -W illuminate/contracts

############################ DEV ###############################
php -d memory_limit=-1 composer.phar require -W --dev laravel/pint
php -d memory_limit=-1 composer.phar require -W --dev nunomaduro/collision
php -d memory_limit=-1 composer.phar require -W --dev larastan/larastan
php -d memory_limit=-1 composer.phar require -W --dev orchestra/testbench
php -d memory_limit=-1 composer.phar require -W --dev pestphp/pest
php -d memory_limit=-1 composer.phar require -W --dev pestphp/pest-plugin-arch
php -d memory_limit=-1 composer.phar require -W --dev pestphp/pest-plugin-laravel
php -d memory_limit=-1 composer.phar require -W --dev phpstan/extension-installer
php -d memory_limit=-1 composer.phar require -W --dev phpstan/phpstan-deprecation-rules
php -d memory_limit=-1 composer.phar require -W --dev phpstan/phpstan-phpunit
php -d memory_limit=-1 composer.phar require -W --dev spatie/laravel-ray
