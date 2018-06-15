
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1 || $_SESSION['type'] == 0){

$result= $dbc->query("SELECT * FROM bus");
$buses_message = array();

if($result->num_rows)
{
	
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$bno = $row['bno'];
		
		$nsResult = $dbc->query("SELECT n_service from maintanance where bno = '$bno' ORDER BY main_id DESC LIMIT 1 ");
		
		if($nsResult-> num_rows)
		{
			$ns = $nsResult->fetch_object()->n_service;
		}
		else
		{
		 	$ns = 5000;	
		}
		
	   if(((int)$ns - (int)$row['bmileage']) < 500)	
	   {
		   
		   $buses_message[$bno]="<span style=\"color:red\">Bus no: " . $bno. " need to service!</span>";   
	   }

	}
}
else
{
	$buses_message['empty'] = '<span style=\"color:red\">No buses right now.</span>';	
}

$result= $dbc->query("SELECT * FROM fuel_tank");

if($result->num_rows)
{
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
	
	$percentage = ($row['current'] / $row['max']) * 100;
	
	   if($percentage < 10)	
	   {
		   $fuel_tank_message = "Left: <span style=\"color:red\">" . $percentage. "%</span>";   
	   }
	   else
	   {
		   $fuel_tank_message = "Left: <span style=\"color:green\">" . $percentage. "%</span>";   
	   }
	}
}


?>


<div id="side-bar" class="show-me">

<div class="basic-grey">
<h1>Alerts
    </h1>
    <span style="
    font-weight: bold;
">Buses status:</span>
<p><?php  if($buses_message) { 	 echo implode($buses_message,"<br>"); } 	   else
	   {
		  echo '<span style="color:green">All buses are in good status.</span>';   
	   }?></p>
<br />
<span style="
    font-weight: bold;
">Fuel tank status:</span>
<p><?php echo $fuel_tank_message;?></p>
</div>
</div>
<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>