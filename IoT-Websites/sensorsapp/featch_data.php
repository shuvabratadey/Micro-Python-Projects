<?php
$db = new SQLite3('data.db');
date_default_timezone_set('Asia/Kolkata');

$data = new \stdClass();

$current_date = date('d-m-Y');
$current_time = date('H:i:s',strtotime('-1 minute'));

$last_update_date = 0;
$last_update_time = 0;

$data->current_date = $current_date;

$result=$db->query('SELECT * FROM sensortable');
while ($row = $result->fetchArray())
{
	$data->temp = $row['Temp'];
	$data->hum = $row['Hum'];
	$data->pre = $row['Pre'];
	$last_update_date = $row['Date'];
	$last_update_time = $row['Time'];
}
if(($current_date == $last_update_date)&&($last_update_time>=$current_time))
{
	$data->status_text = "Status Online";
	$data->status_colour = "lime";
	$data->status_img = "pictures/online.png";
}

else if(($current_date != $last_update_date)||($current_date == $last_update_date)&&($last_update_time<$current_time))
{
	$data->status_text = "Status Offline";
	$data->status_colour = "red";
	$data->status_img = "pictures/offline.png";
}

$json_data = json_encode($data);

echo $json_data;
?>