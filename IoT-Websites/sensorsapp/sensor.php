<?php
$db = new SQLite3('data.db');
$Temp=$_GET["Temp"];
$Hum=$_GET["Hum"];
$Pre=$_GET["Pre"];
if($Temp==NULL || $Hum==NULL || $Pre==NULL)
{
	echo "NULL data received.";
	header("HTTP/1.1 404 NOT FOUND");
}
else
{
	header("HTTP/1.1 200 OK");
	echo "Temp:".$Temp."<br>";
	echo "Hum:".$Hum."<br>";
	echo "Pre:".$Pre."<br>";

	date_default_timezone_set('Asia/Kolkata');
	$current_date = date('d-m-Y');
	$current_time = date('H:i:s');
	$qury="DELETE FROM sensortable WHERE id NOT IN (SELECT id FROM (SELECT id FROM sensortable ORDER BY id DESC LIMIT 49) foo);";
	$db->query($qury);

	$qury="INSERT INTO sensortable(Temp,Hum,Pre,Date,Time)VALUES('$Temp','$Hum','$Pre','$current_date','$current_time')";	//INSERT INTO `sensortable` (`id`, `Temp`, `Hum`, `Pre`) VALUES (NULL, '25', '45', '123456');

	$result=$db->query($qury);

	if($result)
	echo "NEW RECORD INSERTED SUCCESSFULLY";
	else
	echo "ERROR SEND DATA";

	
}
?>