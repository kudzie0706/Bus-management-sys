<?php

include('core/dbconnect.php');

$bno = $_GET['bno'];

$result= $dbc->query("SELECT * FROM bus_location where bno = '$bno' LIMIT 1");


if(($result->num_rows))
{
	  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
		$string = $row['latitude'] . "/" . $row['longitude'];
		echo $string;
	  }
}

mysqli_close($dbc);
?>