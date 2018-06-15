<?php $title = 'Edit Route'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1 || $_SESSION['type'] == 0 || $_SESSION['type'] == 4){

if ($_SESSION['type'] == 1)
{
	include('includes/admin-menu.html');
}
else if ($_SESSION['type'] == 0)
{
include('includes/staff-menu.html');
}	
else
{
include('includes/user-menu.html');	
}
?>


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
$("#driver_id").text( $(event.target).closest('a').data('d_id'));
$("#bno").text( $(event.target).closest('a').data('bno'));
$("#d_station").text( $(event.target).closest('a').data('d_station'));
$("#a_station").text( $(event.target).closest('a').data('a_station'));

$("#d_time").text( $(event.target).closest('a').data('d_time'));
$("#a_time").text( $(event.target).closest('a').data('a_time'));

$("#distance").text( $(event.target).closest('a').data('distance') + ' km');
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

<div class="basic-grey">

<input id="rid" type="hidden" name="rid" >

<table class="imagetable">
<tr>
	<th>Driver ID</th><td id="driver_id"></td>
</tr>
<tr>
	<th>Bus Number</th><td id="bno"></td>
</tr>
<tr>
	<th>Departure</th><td id="d_station"></td>
</tr>
<tr>
	<th>Destination</th><td id="a_station"></td>
</tr>

<tr>
	<th>Departure Time</th><td id="d_time"></td>
</tr>
<tr>
	<th>Destination Time</th><td id="a_time"></td>
</tr>

<tr>
	<th>Distance</th><td id="distance"></td>
</tr>
</table>

<div class="modal-footer" style="
    margin-bottom: -26px;
" align="center">
 <button class="button1" data-dismiss="modal" aria-hidden="true">Close</button>
        
    </div>
</div>
</div>
</div>


</div>


</div>
<?php if($_SESSION['type'] == 4)
{
	include('user_sidebar.php'); 
}
else
{
	include('sidebar.php'); 
}?>
<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>