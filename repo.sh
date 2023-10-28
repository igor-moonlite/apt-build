#!/bin/bash
ROOTDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd)"
cd $ROOTDIR/repo
dpkg-scanpackages -m . /dev/null > Packages
gzip --keep --force -9 Packages
