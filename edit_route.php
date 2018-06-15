<?php $title = 'Edit Route'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	
	if (isset($_REQUEST['delete'])) {
$dbc->query("DELETE FROM route WHERE rid='{$_REQUEST['delete']}'");

}

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

$id = mysqli_real_escape_string($dbc,trim($_POST['rid']));

        $query  = "UPDATE route ";
        $query .= "SET bno='$bno',d_station='$d_station',a_station='$a_station',distance_km='$distance',d_id='$driver_id',d_time='$d_time',a_time='$a_time' WHERE rid='$id' ";

        $add = $dbc->query($query);

        if($add){
            $message = "Route ID: ". $id . " edited successfully.";
        }else{
            echo $query;
        }
    }
}
?>

<div style="
    
    margin-top: 10px;
    font-size: 15px;
"><?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if($errors) {echo '<span style="color: red;">Unable to save edited route:</span><br><br><span>'.implode("<br>",$errors) . '</span>';}else { echo '<span style="color:red;">'.$message .'</span>';} } ?></div>

<div id="content">
<script type="text/javascript" src="includes/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="includes/bootstrap-combined.min.css" />


<script>
 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tblRoutes").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_editable_routes.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('id'); //get the id from tr
        //make your ajax call populate items or what even you need
$("#boxtitle").text('Route ID: '+ getIdFromRow);
$("#driver_id").val($(event.target).closest('a').data('d_id'));
$("#bno").val($(event.target).closest('a').data('bno'));
$("#d_station").val($(event.target).closest('a').data('d_station'));
$("#a_station").val($(event.target).closest('a').data('a_station'));

var d_t = $(event.target).closest('a').data('d_time');
var arrd_t = d_t.split(" ");
$("#d_time").val(arrd_t[0]+"T"+arrd_t[1]);

var a_t = $(event.target).closest('a').data('a_time');
var arra_t = a_t.split(" ");

$("#a_time").val(arra_t[0]+"T"+arra_t[1]);

$("#distance").val($(event.target).closest('a').data('distance'));
$("#rid").val($(event.target).closest('a').data('id'));
    });
});

</script>

<div id="tblRoutes"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

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

<form action="edit_route.php" method="post" class="basic-grey" style="margin:0px;">
<input id="rid" type="hidden" name="rid" >
<label>
        <span>Driver Id :</span>
        <input id="driver_id" type="text" name="driver_id" placeholder="Driver number" style="width: 50%;">

        <a href="#driver_id" style="font-size:10px"  onclick="viewDrivers();">Select driver</a>
    
    </label>
<div id="tblDrivers"></div>
    <label>
        <span>Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number"style="width: 50%;">

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
        <input type="time" id="d_time" name="d_time">
    </label>

  <label>
        <span>Destination Time :</span>
        <input type="time"   id="a_time" name="a_time">
    </label>

<label>
        <span>Distance :</span>
        <input id="distance" type="text" name="distance" placeholder="Exp: 80km">
    </label>
    <div class="modal-footer" style="
    margin-bottom: -26px;
">
     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Save"> 
<button class="button" data-dismiss="modal" aria-hidden="true">Close</button>
    </label> 
        
    </div>

</form>
</div>


</div>


</div>
<?php include('sidebar.php'); ?>
<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>