<?php $title = 'Edit Bus'; // In this line I am defining the Title of the page which works with the design of the header.html?>
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
      document.getElementById("tblBuses").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_editable_buses.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('id'); //get the id from tr
        //make your ajax call populate items or what even you need
$("#boxtitle").text('Bus Number: '+ getIdFromRow);
$("#make").text( $(event.target).closest('a').data('make'));
$("#model").text( $(event.target).closest('a').data('model'));
$("#year").text( $(event.target).closest('a').data('year'));
$("#capacity").text( $(event.target).closest('a').data('capacity'));
$("#bmi").text( $(event.target).closest('a').data('bmi'));
$("#bno").val($(event.target).closest('a').data('id'));
$("#status").text($(event.target).closest('a').data('status'));
    });
});

</script>

<div id="tblBuses"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

<div class="basic-grey">
   <input id="bno" type="hidden" name="bno" >
   
   <table class="imagetable">
<tr>
	<th>Make</th><td id="make"></td>
</tr>
<tr>
	<th>Model</th><td id="model"></td>
</tr>
<tr>
	<th>Year</th><td id="year"></td>
</tr>
<tr>
	<th>Capacity</th><td id="capacity"></td>
</tr>
<tr>
	<th>Bus Mileage</th><td id="bmi"></td>
</tr>
<tr>
	<th>Status</th><td id="status"></td>
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