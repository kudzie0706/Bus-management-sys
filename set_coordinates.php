<?php

include('core/dbconnect.php');

$bno = $_GET['bno'];
$la = $_GET['la'];
$lo = $_GET['lo'];

if($bno && $la && $lo)
{
	$result = $dbc->query("Select * from bus_location where bno= '$bno'");
	
	if($result->num_rows)
	{
	        $query  = "UPDATE bus_location ";
        $query .= "SET latitude='$la',longitude='$lo' WHERE bno='$bno' ";
		
		$add = $dbc->query($query);

        if(!$add){
            
			echo $add;
        }
	}
	else
	{
			$query = "INSERT INTO bus_location (bno,latitude,longitude) VALUES('$bno','$la','$lo')";
			
			$insert = $dbc->query($query);
			
			if(!$insert)
			{
				echo $insert;	
			}
	}
	
	  $query1  = "UPDATE bus ";
        $query1 .= "SET status='Outgoing' WHERE bno='$bno' ";

			$add1 = $dbc->query($query1);
			
			if(!$add1)
			{
				echo $add1;	
			}
			
}
else
{
	echo 'Unable to get coordinates..';	
}
mysqli_close($dbc);
?>