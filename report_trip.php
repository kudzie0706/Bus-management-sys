<?php $title = 'View Trip Report'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1 || $_SESSION['type'] == 0){

if ($_SESSION['type'] == 1)
{
	include('includes/admin-menu.html');
}
else
{
include('includes/staff-menu.html');
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
      document.getElementById("tblTrips").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_trip.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('id'); //get the id from tr
        //make your ajax call populate items or what even you need
$("#boxtitle").text('Trip Id: '+ getIdFromRow);
$("#bno").text( $(event.target).closest('a').data('bno'));
$("#rid").text( $(event.target).closest('a').data('rid'));
$("#s_mileage").text( $(event.target).closest('a').data('s_mileage'));
$("#e_mileage").text( $(event.target).closest('a').data('e_mileage'));
$("#dtime").text( $(event.target).closest('a').data('dtime'));
$("#atime").text($(event.target).closest('a').data('atime'));
$("#date").text( $(event.target).closest('a').data('date'));
$("#d_id").text($(event.target).closest('a').data('d_id'));
    });
});

</script>

<div id="tblTrips"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

<div class="basic-grey">
   
   <table class="imagetable">
<tr>
	<th>Bus number</th><td id="bno"></td>
</tr>
<tr>
	<th>Route id</th><td id="rid"></td>
</tr>
<tr>
	<th>Driver id</th><td id="d_id"></td>
</tr>
<tr>
	<th>Start mileage</th><td id="s_mileage"></td>
</tr>
<tr>
	<th>End mileage</th><td id="e_mileage"></td>
</tr>
<tr>
	<th>Departure time</th><td id="dtime"></td>
</tr>
<tr>
	<th>Arrival time</th><td id="atime"></td>
</tr>
<tr>
	<th>Date</th><td id="date"></td>
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
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>