#!/bin/bash

sudo rm -rf $TARGET_PUBLISH_ROOT/*

sudo cp -r $TARGET_BUILD_ROOT/* $TARGET_PUBLISH_ROOT