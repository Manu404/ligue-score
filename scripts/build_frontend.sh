#!/bin/bash

cd $FRONTEND_FOLDER

ng build

cp htaccess $FRONTEND_TARGET_BUILD_ROOT/.htaccess