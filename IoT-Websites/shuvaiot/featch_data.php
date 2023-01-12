<?php
$Update=$_GET["Update"];
$Light = 0;
$Fan = 0;
if($Update == "All")
{
	$db = new SQLite3('mydb.db');
	$qury="DELETE FROM myTable";
	$db->query($qury);
	$Light=$_GET["Light"];
	$Fan=$_GET["Fan"];
	$qury="INSERT INTO myTable(Light,Fan)VALUES('".$Light."','".$Fan."')";
	$result=$db->query($qury);

	if($result)
		echo "NEW RECORD INSERTED SUCCESSFULLY";
	else
		echo "ERROR SEND DATA";

}
else if($Update == "Light")
{
	$Light=$_GET["Light"];
	
	$db = new SQLite3('mydb.db');
	$result=$db->query('SELECT * FROM myTable');
	while ($row = $result->fetchArray())
	{
		$Fan = $row['Fan'];
	}
	$qury="INSERT INTO myTable(Light,Fan)VALUES('".$Light."','".$Fan."')";
	$result=$db->query($qury);

	if($result)
		echo "NEW RECORD INSERTED SUCCESSFULLY";
	else
		echo "ERROR SEND DATA";
}
else if($Update == "Fan")
{	
	$Fan=$_GET["Fan"];
	
	$db = new SQLite3('mydb.db');
	$result=$db->query('SELECT * FROM myTable');
	while ($row = $result->fetchArray())
	{
		$Light = $row['Light'];
	}
	$qury="INSERT INTO myTable(Light,Fan)VALUES('".$Light."','".$Fan."')";
	$result=$db->query($qury);

	if($result)
		echo "NEW RECORD INSERTED SUCCESSFULLY";
	else
		echo "ERROR SEND DATA";
}
else
{
	$db = new SQLite3('mydb.db');
	$data = new \stdClass();
	$result=$db->query('SELECT * FROM myTable');
	while ($row = $result->fetchArray())
	{
		$data->Light = $row['Light'];
		$data->Fan = $row['Fan'];
	}

	$json_data = json_encode($data);

	echo $json_data;
}
?>