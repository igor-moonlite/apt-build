<?php

function ini_load($filename)
{
    return parse_ini_file($filename);
}

function ini_save($filename, $ini)
{
    $output="";
    foreach ($ini as $inikey => $iniline) {
        $output.="".$inikey." = \"".addcslashes($iniline, "\"")."\"\n";
    }
    file_put_contents($filename, $output);
}

$BASEPATH = '/opt/moonlite/build/tmp/p9/data/usr/share/moonlite/';

$EngFile = "modules/IframeAppWebclient/i18n/English.ini";
$Eng = ini_load($BASEPATH.$EngFile);
$Eng["HEADING_BROWSER_TAB"] = "Calendar";
$Eng["LABEL_SETTINGS_TAB"] = "Calendar";
$Eng["HEADING_SETTINGS_TAB"] = "Calendar";
$Eng["LABEL_ALLOW_IFRAMEAPP"] = "Enable Calendar";
$Eng["LABEL_IFRAME_URL"] = "Calendar URL";
$Eng["LABEL_APP_NAME"] = "Calendar label";
$Eng["OPTION_AURORA_CREDS"] = "MoonLite user credentials";
ini_save($BASEPATH.$EngFile, $Eng);

$RusFile = "modules/IframeAppWebclient/i18n/Russian.ini";
$Rus = ini_load($BASEPATH.$RusFile);
$Rus["HEADING_BROWSER_TAB"] = "Календарь";
$Rus["LABEL_SETTINGS_TAB"] = "Календарь";
$Rus["HEADING_SETTINGS_TAB"] = "Календарь";
$Rus["LABEL_ALLOW_IFRAMEAPP"] = "Включить Календарь";
$Rus["LABEL_IFRAME_URL"] = "URL Календаря";
$Rus["LABEL_APP_NAME"] = "Метка Календарь";
$Rus["OPTION_AURORA_CREDS"] = "Учетные данные MoonLite";
ini_save($BASEPATH.$RusFile, $Rus);
