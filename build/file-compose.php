<?php

$comp = file_get_contents("/opt/moonlite/build/tmp/p9/data/usr/share/moonfile/composer.json");
$jcomp = json_decode($comp, TRUE);

$lock = file_get_contents("https://raw.githubusercontent.com/afterlogic/aurora-corporate-8/master/composer.lock");
$jlock = json_decode($lock, TRUE);
foreach ($jlock["packages"] as $pentry) {
    $pack[$pentry["name"]] = $pentry["version"];
}

foreach ($jcomp["require"] as $reqk=>$reqv) {
    if (isset($pack[$reqk])) {
	$jcomp["require"][$reqk] = $pack[$reqk];
    }
}

file_put_contents("/opt/moonlite/build/tmp/p9/data/usr/share/moonfile/composer.json", json_encode($jcomp, JSON_PRETTY_PRINT));

