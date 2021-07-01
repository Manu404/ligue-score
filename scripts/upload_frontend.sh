#!/bin/bash

PUBLISH_ARCHIVE=fedh.tgz

cd $FRONTEND_FOLDER

rm -rf $PUBLISH_ARCHIVE

cd $FRONTEND_TARGET_BUILD_ROOT

tar -czvf ../$PUBLISH_ARCHIVE .

scp -P 11122 ../$PUBLISH_ARCHIVE elman@51.178.17.89:/home/elman/

ssh -t -p 11122 elman@51.178.17.89 'bash -s' < $REP_ROOT/scripts/remote_deploy_frontend.sh