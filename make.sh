#!/bin/bash
ROOTDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd)"
rm -rf $ROOTDIR/repo
mkdir $ROOTDIR/repo
cp -f $ROOTDIR/build/out/*.deb $ROOTDIR/repo
cp -f $ROOTDIR/moonlite.asc $ROOTDIR/repo/moonlite.asc
