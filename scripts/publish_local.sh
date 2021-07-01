#!/bin/bash

sudo rm -rf $TARGET_PUBLISH_ROOT/*

cd $TARGET_BUILD_ROOT

sudo cp -r . $TARGET_PUBLISH_ROOT