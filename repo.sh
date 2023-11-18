#!/bin/bash
ROOTDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd)"
rm -rf $ROOTDIR/repo
mkdir $ROOTDIR/repo
cp -f $ROOTDIR/build/out/*.deb $ROOTDIR/repo
cp -f $ROOTDIR/moonlite.asc $ROOTDIR/repo/moonlite.asc

cd $ROOTDIR/repo
dpkg-scanpackages -m . /dev/null > Packages
gzip --keep --force -9 Packages

cat $ROOTDIR/distributions > Release
echo -e "Date: `LANG=C date -Ru`" >> Release
echo -e 'MD5Sum:' >> Release
printf ' '$(md5sum Packages.gz | cut --delimiter=' ' --fields=1)' %16d Packages.gz' $(wc --bytes Packages.gz | cut --delimiter=' ' --fields=1) >> Release
printf '\n '$(md5sum Packages | cut --delimiter=' ' --fields=1)' %16d Packages' $(wc --bytes Packages | cut --delimiter=' ' --fields=1) >> Release
echo -e '\nSHA256:' >> Release
printf ' '$(sha256sum Packages.gz | cut --delimiter=' ' --fields=1)' %16d Packages.gz' $(wc --bytes Packages.gz | cut --delimiter=' ' --fields=1) >> Release
printf '\n '$(sha256sum Packages | cut --delimiter=' ' --fields=1)' %16d Packages' $(wc --bytes Packages | cut --delimiter=' ' --fields=1) >> Release
gpg --clearsign --digest-algo SHA512 --local-user "Igor MoonLite" --yes -o InRelease Release
