<?php 
$raw_body = file_get_contents('php://input');
$data = json_decode($raw_body);
echo $data->year . " " . $data->month . " " . $data->day . " " . $data->weekday . " " . $data->time;
?>