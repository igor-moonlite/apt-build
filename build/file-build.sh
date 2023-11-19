#!/bin/bash
PRODNAME="moonfile"
rm -rf ./tmp/p9
mkdir -p ./out
mkdir -p ./tmp/p9/data/usr/share/moonfile
mkdir -p ./tmp/p9/data/usr/share/doc/moonfile
mkdir -p ./tmp/p9/data/etc/moonfile
cd /opt/moonlite/build/tmp/p9/data/usr/share/moonfile
git clone https://github.com/igor-moonlite/moonfile .
php /opt/moonlite/build/file-compose.php

yes | php composer.phar install
cp -r /opt/moonlite/build/hotfix/. /opt/moonlite/build/tmp/p9/data/usr/share/moonfile
cp -r /opt/moonlite/build/override/. /opt/moonlite/build/tmp/p9/data/usr/share/moonfile

cd /opt/moonlite/build/tmp/p9/data/usr/share/moonfile
npm install
cd modules/AdminPanelWebclient/vue
npm install
npm install -g @quasar/cli
cd ../../..
cd /opt/moonlite/build/
php ./file-iframe.php
cd /opt/moonlite/build/tmp/p9/data/usr/share/moonfile
npm run styles:build --themes=Default,DefaultDark,DeepForest,Funny,Sand
npm run js:build
cd modules/AdminPanelWebclient/vue
npm run build-production
cd ../../..
rm -rf ./.git
rm -rf ./system/.git
rm -rf ./system/.githooks
rm -rf ./vendor/afterlogic/dav/.git
rm -rf ./vendor/afterlogic/googleauthenticator/.git
rm -rf ./vendor/afterlogic/mailso/.git
rm -rf ./node_modules
rm -rf ./modules/AdminPanelWebclient/vue/node_modules
rm -rf ./modules/IframeAppWebclient/.git
rm -rf ./modules/IframeAppWebclient/.githooks
cd /opt/moonlite/build
php ./file-build.php

cp ./file-in/p9/moonlite.php ./tmp/p9/data/usr/share/moonfile/moonlite.php
cp -r /opt/moonlite/build/content /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/content
cp -r  /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/static/styles/themes/DeepForest /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/static/styles/themes/MoonLite
cp /opt/moonlite/build/content/background.jpg /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/static/styles/themes/MoonLite/images/background.jpg
cp /opt/moonlite/build/content/favicon.ico /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/favicon.ico
cp /opt/moonlite/build/content/favicon.ico /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/adminpanel/favicon.ico
cp /opt/moonlite/build/content/moonlite-128.png /opt/moonlite/build/tmp/p9/data/usr/share/moonfile/static/styles/images/logo_140x140.png

chown www-data:www-data -R ./tmp/p9/data/usr/share/moonfile/

mkdir ./tmp/p9/control

INST_SIZE=`du -sk ./tmp/p9/data/usr/share/moonfile/ | awk '{print $1}'`
cp -f ./file-in/stable/control ./tmp/p9/control/control
sed -i "s/%S%/$INST_SIZE/g" ./tmp/p9/control/control
VERNUM=`cat ./tmp/p9/data/usr/share/moonfile/VERSION`
VERNUM=`echo $VERNUM | cut -d'-' -f1`
sed -i "s/%V%/$VERNUM/g" ./tmp/p9/control/control
sed -i "s/%P%/$PRODNAME/g" ./tmp/p9/control/control

cp -f ./file-in/changelog ./tmp/p9/control/changelog
sed -i "s/%V%/$VERNUM/g" ./tmp/p9/control/changelog
sed -i "s/%P%/$PRODNAME/g" ./tmp/p9/control/changelog
sed -i "s/%S%/stable/g" ./tmp/p9/control/changelog

find ./tmp/p9/data/usr/share/moonfile/ -type f -exec md5sum "{}" + > ./tmp/p9/control/md5sums
sed -i "s/.\/tmp\/p9\/data//g" ./tmp/p9/control/md5sums

cp ./file-in/conffiles ./tmp/p9/control/conffiles

cp ./file-in/apache.conf ./tmp/p9/data/etc/moonfile/apache.conf
cp ./file-in/copyright ./tmp/p9/data/usr/share/doc/moonfile/copyright
cp ./tmp/p9/control/changelog ./tmp/p9/data/usr/share/doc/moonfile/changelog
gzip ./tmp/p9/data/usr/share/doc/moonfile/changelog

cp ./file-in/p9/postinst ./tmp/p9/control/postinst
chown 0755 ./tmp/p9/control/postinst
cp ./file-in/p9/preinst ./tmp/p9/control/preinst
chown 0755 ./tmp/p9/control/preinst
cp ./file-in/p9/postrm ./tmp/p9/control/postrm
chown 0755 ./tmp/p9/control/postrm
cp ./file-in/p9/prerm ./tmp/p9/control/prerm
chown 0755 ./tmp/p9/control/prerm

cd ./tmp/p9/data
tar czf ../data.tar.gz [a-z]*
cd ../control
tar czf ../control.tar.gz *

cd ..
echo 2.0 > debian-binary
ar r ../../out/moonfile_`echo $VERNUM`_all.deb debian-binary control.tar.gz data.tar.gz
rm -f /opt/moonlite/build/moonfile.zip
cd /opt/moonlite/build/tmp/p9/data/usr/share/moonfile
zip -rq /opt/moonlite/build/moonfile.zip ./
