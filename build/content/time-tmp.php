<?php
$json = file_get_contents("https://api.truckersmp.com/v2/game_time");
$data = json_decode($json);
$resp = ["error"=>false,"time"=>strval($data->game_time),"fetch"=>time()];
echo json_encode($resp);
