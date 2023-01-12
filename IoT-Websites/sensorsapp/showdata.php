<?php
$db = new SQLite3('data.db');

date_default_timezone_set('Asia/Kolkata');
$current_date = date('d-m-Y');
$current_time = date('H:i:s');

echo "
<html>
<body bgcolor='lime'>
<center>
<h1><font color='red' size='100%'>Total Readings are</font></h1>
<table border='2'>
<tr>
<th><center>Sl. No.</center></th>
<th><center>Temp</center></th>
<th><center>Hum</center></th>
<th><center>Moist</center></th>
<th><center>Time</center></th>
<th><center>Date</center></th>
</tr>";

$qury="SELECT * FROM sensortable";
$result=$db->query($qury);
$count = 1;
while ($row = $result->fetchArray())
{
	echo "
	<tr>
	<td><center>".$count++."</center></td>
	<td><center>".$row['Temp']."</center></td>
	<td><center>".$row['Hum']."</center></td>
	<td><center>".$row['Pre']."</center></td>
	<td><center>".$row['Time']."</center></td>
	<td><center>".$row['Date']."</center></td>
	</tr>";
}

echo "
</table></br>
<a href='showdata.php'><button>Refersh</button></a>
</center>
</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>
</body>
</html>";