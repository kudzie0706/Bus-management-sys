<?php $title = 'Fuel Tank Report'; // In this line I am defining the Title of the page which works with the design of the header.html?>
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
      document.getElementById("tblFuels").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_editable_fuels.php",true);
  xmlhttp.send();



</script>

<div id="tblFuels"></div>


</div>
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>