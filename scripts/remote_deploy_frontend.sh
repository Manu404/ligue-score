#!/bin/bash

TARGET_FOLDER=/var/www/html/sedh

cd ~

rm -rf $TARGET_FOLDER

mkdir $TARGET_FOLDER

tar -xzvf ~/fedh.tgz -C $TARGET_FOLDER