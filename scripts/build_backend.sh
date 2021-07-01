#!/bin/bash

cd $BACKEND_FOLDER

rm -rf $TARGET_BUILD_ROOT

mkdir $TARGET_BUILD_ROOT

cp index.php $TARGET_BUILD_ROOT

cp -r core $TARGET_BUILD_ROOT
cp -r vendor $TARGET_BUILD_ROOT
cp -r Model $TARGET_BUILD_ROOT
cp htaccess $TARGET_BUILD_ROOT/.htaccess
