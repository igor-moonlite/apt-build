<?php

// DEFINITIONS

$BASEPATH = '/opt/moonlite/build/tmp/p9/data/usr/share/moonlite/';
$MODSPATH = '/opt/moonlite/build/tmp/p9/data/usr/share/moonlite/modules/';

// HELPER FUNCTION DECLARATIONS

function json_load($filename)
{
    return json_decode(file_get_contents($filename));
}

function json_save($filename, $json)
{
    file_put_contents($filename, json_encode($json, JSON_PRETTY_PRINT));
}

function deltree($dir)
{
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}

function delfile($dir, $names)
{
    if (is_dir($dir)) {
        $files=scandir($dir);
        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($dir.$file) && !in_array($file, $names)!==false) {
                    unlink($dir.$file);
                }
            }
        }
    }
}

require './autoload.php';
$html = new IvoPetkov\HTML5DOMDocument();

// 1. CONVERTING TEMPLATES (can only be done once)

$modpath = $MODSPATH.'CoreWebclient/templates/HeaderView.html';
$html->loadHTMLFile($modpath, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$divs = $html->getElementsByTagName('div');
for ($i = $divs->length; --$i >= 0;) {
    $div = $divs->item($i);
    if ($div->getAttribute('class') == 'tabsbar') {
        $attr = $html->createAttribute('style');
        $attr->value = 'height: 40px;';
        $div->appendChild($attr);
    }

    if ($div->getAttribute('class') == 'spacer') {
        $div1 = $html->createElement('div');
        $attr = $html->createAttribute('style');
        $attr->value = 'padding-right: 12px; padding-left: 12px; width:179px; height:36px; border: 0;';
        $div1->appendChild($attr);

        $frame1 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/time.html';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '179';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame1->appendChild($attr);
        $div1->appendChild($frame1);

        $div2 = $html->createElement('div');
        $attr = $html->createAttribute('style');
        $attr->value = 'padding-right: 12px; padding-left: 12px; width:50px; height:36px; border: 0;';
        $div2->appendChild($attr);

        $frame2 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/time-tmp.html';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '50';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame2->appendChild($attr);
        $div2->appendChild($frame2);

        $div3 = $html->createElement('div');
        $attr = $html->createAttribute('style');
        $attr->value = 'margin: 0; padding: 0; width:220px; height:36px; border: 0;';
        $div3->appendChild($attr);

        $frame3 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/radio.html';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '220';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame3->appendChild($attr);
        $div3->appendChild($frame3);

        $div->parentNode->insertBefore($div3, $div->nextSibling);
        $div->parentNode->insertBefore($div2, $div->nextSibling);
        $div->parentNode->insertBefore($div1, $div->nextSibling);
    }
}

$links = $html->getElementsByTagName('a');
for ($i = $links->length; --$i >= 0;) {
    $link = $links->item($i);
    if ($link->getAttribute('class') == 'item logo') {
        $attr = $html->createAttribute('style');
        $attr->value = 'display: block; margin-left: 0px; margin-right: 0px;';
        $link->appendChild($attr);

        $img = $html->createElement('img');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/moon-30.png';
        $img->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'height: 30px; width: 30px;';
        $img->appendChild($attr);
        $link->appendChild($img);
    }
}

file_put_contents($modpath, $html->saveHTML());


$modpath = $MODSPATH.'StandardLoginFormWebclient/templates/LoginView.html';
$html->loadHTMLFile($modpath, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
for ($i = $divs->length; --$i >= 0;) {
    $div = $divs->item($i);
    if ($div->getAttribute('class') == 'header') {
        while ($div->hasChildNodes()) {
            $div->removeChild($div->firstChild);
        }
        $div->removeAttribute("data-bind");
        $attr = $html->createAttribute('style');
        $attr->value = 'margin-bottom: 52px;';
        $div->appendChild($attr);

        $img = $html->createElement('img');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/moonlite-128.png';
        $img->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'width: 128px; height: 128px;';
        $img->appendChild($attr);
        $div->appendChild($img);
    }

    if ($div->getAttribute('class') == 'languages') {
        $attr = $html->createAttribute('style');
        $attr->value = 'top: -5px; right: 30px;';
	$div->appendChild($attr);

        $span0 = $html->createElement('span');
        $attr = $html->createAttribute('style');
        $attr->value = 'height:36px;';
        $span0->appendChild($attr);

        $span1 = $html->createElement('span');
        $attr = $html->createAttribute('style');
        $attr->value = 'padding-right: 12px; padding-left: 12px; width:179px; height:36px; border: 0;';
        $span1->appendChild($attr);

        $frame1 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/time.html';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '179';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame1->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame1->appendChild($attr);
        $span1->appendChild($frame1);

        $span2 = $html->createElement('span');
        $attr = $html->createAttribute('style');
        $attr->value = 'padding-right: 12px; padding-left: 12px; width:50px; height:36px; border: 0;';
        $span2->appendChild($attr);

        $frame2 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/time-tmp.html';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '50';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame2->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame2->appendChild($attr);
        $span2->appendChild($frame2);

        $span3 = $html->createElement('span');
        $attr = $html->createAttribute('style');
        $attr->value = 'margin: 0; padding: 0; padding-right: 30px; width:220px; height:36px; border: 0;';
        $span3->appendChild($attr);

        $frame3 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/radio.html';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('width');
        $attr->value = '220';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('height');
        $attr->value = '36';
        $frame3->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0;';
        $frame3->appendChild($attr);
        $span3->appendChild($frame3);

	$span0->appendChild($span1);
	$span0->appendChild($span2);
	$span0->appendChild($span3);
	$div->insertBefore($span0, $div->firstChild);
    }
}
file_put_contents($modpath, $html->saveHTML());

$modpath = $MODSPATH.'MailWebclient/templates/FoldersView.html';
$html->loadHTMLFile($modpath, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

$divs = $html->getElementsByTagName('div');
for ($i = $divs->length; --$i >= 0;) {
    $div = $divs->item($i);
    if ($div->getAttribute('class') == 'items_list collapsible') {
        $div0 = $html->createElement('div');
        $attr = $html->createAttribute('style');
        $attr->value = 'display: block; text-align: center; margin-left: 15px; margin-top: 40px; width: 230px; height: 310px;';
        $div0->appendChild($attr);

        $frame0 = $html->createElement('iframe');
        $attr = $html->createAttribute('src');
        $attr->value = '/mlite/content/weather.html';
        $frame0->appendChild($attr);
        $attr = $html->createAttribute('scrolling');
        $attr->value = 'no';
        $frame0->appendChild($attr);
        $attr = $html->createAttribute('style');
        $attr->value = 'border: 0; width: 230px; height: 310px;';
        $frame0->appendChild($attr);
        $div0->appendChild($frame0);

        $div->appendChild($div0);
    }
}

file_put_contents($modpath, $html->saveHTML());

$admpath = $BASEPATH.'adminpanel/main.html';
$html->loadHTMLFile($admpath, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$title=$html->getElementsByTagName('title')[0];
$title->nodeValue = "MoonLite Admin";
file_put_contents($admpath, $html->saveHTML());

// 2. REMOVING MODULES

$dirs = glob($BASEPATH."modules". '/*', GLOB_ONLYDIR);
foreach ($dirs as $dir) {
    deltree($dir."/.git");
    deltree($dir."/.githooks");
    deltree($dir."/.github");
    delfile($dir."/i18n/", ["English.ini", "Russian.ini"]);
}
