<?php
$json = file_get_contents("https://api.truckersmp.com/v2/game_time");
$data = json_decode($json);
echo $data->game_time;
