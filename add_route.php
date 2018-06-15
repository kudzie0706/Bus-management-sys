<?php $title = 'Add Route'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	
	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['driver_id'])){
        $errors['driver_id'] = 'Please fill in driver number';
    }else{

$driver_id = mysqli_real_escape_string($dbc,trim($_POST['driver_id']));

 if($check = $dbc->query("SELECT d_id FROM drivers WHERE d_id = '$driver_id'")){
            if(!($check->num_rows)){
                        $errors['driver_id'] = 'The driver number does not exist';
            }
}
            else
            {
              $errors['driver_id'] = 'The query did not work';
             }

    }

    if(empty($_POST['bno'])){
        $errors['bno'] = 'Please fill in bus number';
    }else{
        $bno = mysqli_real_escape_string($dbc,trim($_POST['bno']));

 if($check = $dbc->query("SELECT bno FROM bus WHERE bno = '$bno'")){
            if(!($check->num_rows)){
                        $errors['bno'] = 'The bus number does not exist';
            }
}
            else
            {
              $errors['bno'] = 'The query did not work';
             }


    }

    if(empty($_POST['d_station'])){
        $errors['d_station'] = 'Please fill in departure';
    }else if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['d_station'])){
	$errors['d_station'] = 'The departure should contains only letters and spaces';
    }else{
        $d_station = mysqli_real_escape_string($dbc,trim($_POST['d_station']));
    }

    if(empty($_POST['a_station'])){
        $errors['a_station'] = 'Please fill in destination';
    }else if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['a_station'])){
	$errors['a_station'] = 'The destination should contains only letters and spaces';
    }else{
        $a_station = mysqli_real_escape_string($dbc,trim($_POST['a_station']));
    }
	

    if(empty($_POST['d_time'])){
        $errors['d_time'] = 'Please fill in departure time';
    }else{
        $d_time = mysqli_real_escape_string($dbc,trim($_POST['d_time']));
    }

    if(empty($_POST['a_time'])){
        $errors['a_time'] = 'Please fill in destination time';
    }else{
        $a_time = mysqli_real_escape_string($dbc,trim($_POST['a_time']));
    }

    if(empty($_POST['distance'])){
        $errors['distance'] = 'Please fill in distance';
    }else if(!preg_match('/^(\w*(\d+[a-zA-Z])\w*)+$/', $_POST['distance'])){
	$errors['distance'] = 'The distance should something like 80km';
    }else{
        $distance = mysqli_real_escape_string($dbc,trim($_POST['distance']));
    }

    if(empty($errors)){

do {
  
  $rid = '';
  for ($i = 0; $i < 5; $i++) {
    $rid .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('A'), ord('Z')));
  }
 if($check = $dbc->query("SELECT rid FROM route WHERE rid = '$rid'")){
            if($check->num_rows){
                $exist = true;
            }
            else
           {
              $exist = false;
            }
        }
} while ($exist);

        $query  = "INSERT INTO route ";
        $query .= "(rid,bno,d_station,a_station,distance_km,d_id,d_time,a_time) ";
        $query .= "VALUES ('$rid','$bno','$d_station','$a_station','$distance','$driver_id','$d_time','$a_time')";

        $add = $dbc->query($query);

        if($add){
            $message = "A new route: ". $rid . " has been added.";
			
			$bmi = $dbc->query("SELECT bmileage FROM bus WHERE bno = '$bno'")->fetch_object()->bmileage;
			
			$sum = $bmi + ($distance * 100);
			
			 $query1  = "UPDATE bus ";
        $query1 .= "SET bmileage='$sum' WHERE bno='$bno' ";

if(!($query1))
{
  echo $query1;	
}
			
        }else{
            echo $query;
        }
    }
}
?>

<script>
function viewDrivers() {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tblDrivers").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_drivers.php",true);
  xmlhttp.send();
}

function viewBuses() {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tblBuses").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_buses.php",true);
  xmlhttp.send();
}

function setBus(str)
{
   document.getElementById("bno").value =str;
   document.getElementById("tblBuses").innerHTML = '';
} 

function setDriver(str)
{
   document.getElementById("driver_id").value =str;
   document.getElementById("tblDrivers").innerHTML = '';
} 
</script>

<div id="content">
<form action="add_route.php" method="post" class="basic-grey">
    <h1>Add Route<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1>

<label>
        <span>Driver Id :</span>
        <input id="driver_id" type="text" name="driver_id" placeholder="Driver number" style="width: 60%;">

        <a href="#driver_id" style="font-size:10px"  onclick="viewDrivers();">Select driver</a>
    
    </label>
<div id="tblDrivers"></div>
    <label>
        <span>Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number"style="width: 60%;">

        <a href="#bno" style="font-size:10px"  onclick="viewBuses();">Select bus</a>
    </label>
    <div id="tblBuses"></div>
    <label>
        <span>Departure  :</span>
        <input id="d_station" type="text" name="d_station" placeholder="Departure of station">
    </label>
    
    <label>
        <span>Destination  :</span>
        <input id="a_station" name="a_station" placeholder="Destination of station" type="text">
    </label> 

  <label>
        <span>Departure Time :</span>
        <input type="time" name="d_time">
    </label>

  <label>
        <span>Destination Time :</span>
        <input type="time" name="a_time">
    </label>

<label>
        <span>Distance :</span>
        <input id="distance" type="text" name="distance" placeholder="Exp: 80km">
    </label>
     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Add"> 
    </label> 
</form>
</div>
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>