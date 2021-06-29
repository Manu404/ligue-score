#!/bin/bash

cd $BACKEND_FOLDER

rm -r $TARGET_BUILD_ROOT

mkdir $TARGET_BUILD_ROOT

cp index.php $TARGET_BUILD_ROOT

cp -r core $TARGET_BUILD_ROOT/core
cp -r vendor $TARGET_BUILD_ROOT/core