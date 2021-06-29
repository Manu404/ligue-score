#!/bin/bash

apt-get install wget php php-dom php-mysql

cd $BACKEND_FOLDER

rm -r composer.phar

wget http://getcomposer.org/composer.phar

php composer.phar install

ln -sf vendor/bin/propel propel