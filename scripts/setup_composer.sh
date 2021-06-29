#!/bin/bash

apt-get install wget php

cd $BACKEND_FOLDER

rm -r composer.phar

wget http://getcomposer.org/composer.phar

php composer.phar install
