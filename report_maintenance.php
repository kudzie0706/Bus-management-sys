<?php $title = 'View Bus Maintenance Report'; // In this line I am defining the Title of the page which works with the design of the header.html?>
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
      document.getElementById("tblMaintenance").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_maintenance.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('id'); //get the id from tr
        //make your ajax call populate items or what even you need

$("#boxtitle").text('Record Id: '+ getIdFromRow);
$("#bno").text( $(event.target).closest('a').data('bno'));
$("#l_service").text( $(event.target).closest('a').data('l_service'));
$("#ls_date").text( $(event.target).closest('a').data('ls_date'));
$("#s_description").text( $(event.target).closest('a').data('s_description'));
$("#servicedate").text( $(event.target).closest('a').data('servicedate'));
$("#n_service").text($(event.target).closest('a').data('n_service'));
    });
});

</script>

<div id="tblMaintenance"></div>

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
	<th>Last service</th><td id="l_service"></td>
</tr>
<tr>
	<th>Last service date</th><td id="ls_date"></td>
</tr>
<tr>
	<th>Description</th><td id="s_description"></td>
</tr>
<tr>
	<th>Service date</th><td id="servicedate"></td>
</tr>
<tr>
	<th>Next service</th><td id="n_service"></td>
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