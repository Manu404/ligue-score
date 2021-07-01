#!/bin/bash

TARGET_FOLDER=/var/www/html/bedh

cd ~/

rm -rf $TARGET_FOLDER

mkdir $TARGET_FOLDER

tar -xzvf ~/bedh.tgz -C $TARGET_FOLDER