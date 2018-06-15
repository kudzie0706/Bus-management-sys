<?php $title = 'Edit Staff'; // In this line I am defining the Title of the page which works with the design of the header.html?>
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
      document.getElementById("tblStaffs").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_editable_staffs.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('s_id'); //get the id from tr
        //make your ajax call populate items or what even you need
$("#boxtitle").text('Staff ID: '+ getIdFromRow);
$("#name").text($(event.target).closest('a').data('name'));
$("#address").text($(event.target).closest('a').data('address'));
$("#phone").text($(event.target).closest('a').data('phone'));
$("#sex").text($(event.target).closest('a').data('sex'));
$("#email").text($(event.target).closest('a').data('email'));
$("#salary").text($(event.target).closest('a').data('salary'));
$("#hireddate").text( $(event.target).closest('a').data('hireddate'));
$("#nextname").text( $(event.target).closest('a').data('nextname'));
$("#nextaddress").text($(event.target).closest('a').data('nextaddress'));
$("#nextsex").text($(event.target).closest('a').data('nextsex'));
$("#nextphone").text( $(event.target).closest('a').data('nextphone'));
$("#s_id").val($(event.target).closest('a').data('s_id'));
$("#user_id").val($(event.target).closest('a').data('id'));
    });
});


</script>

<div id="tblStaffs"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

<div class="basic-grey">
<div style="
    text-align: center;
    margin-bottom: 10px;
margin-top: -16px;
"><span style="
    font-weight: bold;
    font-size: 20px;
">--Driver Information--</span></div>
<input id="s_id" type="hidden" name="s_id" >
<input id="user_id" type="hidden" name="user_id" >

<table class="imagetable">
<tr>
	<th>Name</th><td id="name"></td>
</tr>
<tr>
	<th>Address</th><td id="address"></td>
</tr>
<tr>
	<th>Phone</th><td id="phone"></td>
</tr>
<tr>
	<th>Sex</th><td id="sex"></td>
</tr>
<tr>
	<th>Email</th><td id="email"></td>
</tr>
<tr>
	<th>Password</th><td id="password">(Hided)</td>
</tr>
<tr>
	<th>Salary</th><td id="salary"></td>
</tr>
<tr>
	<th>Hired Date</th><td id="hireddate"></td>
</tr>
</table>

<br />
<div style="
    text-align: center;
    margin-bottom: 10px;
"><span style="
    font-weight: bold;
    font-size: 20px;
">--Next of Kin--</span></div>

<table class="imagetable">
<tr>
	<th>Name</th><td id="nextname"></td>
</tr>
<tr>
	<th>Address</th><td id="nextaddress"></td>
</tr>
<tr>
	<th>Sex</th><td id="nextsex"></td>
</tr>
<tr>
	<th>Phone</th><td id="nextphone"></td>
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