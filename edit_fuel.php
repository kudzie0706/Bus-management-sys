<?php $title = 'Edit Fuel'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');


	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['current'])){
        $errors['current'] = 'Please fill in current fuel';
    }else if(!preg_match('/^[\d]+$/', $_POST['current'])){
	$errors['current'] = 'The current should contains only numbers';
    }else{

$current = mysqli_real_escape_string($dbc,trim($_POST['current']));

    }

    if(empty($_POST['max'])){
        $errors['max'] = 'Please fill in max capacity for fuel tank';
    }else if(!preg_match('/^[\d]+$/', $_POST['max'])){
	$errors['max'] = 'The max should contains only numbers';
    }else{
        $max = mysqli_real_escape_string($dbc,trim($_POST['max']));

    }

if(empty($errors)){

$date = mysqli_real_escape_string($dbc,trim($_POST['date']));

        $query  = "UPDATE fuel_tank ";
        $query .= "SET current='$current',max='$max' WHERE date='$date' ";

        $add = $dbc->query($query);

        if($add){
            $message = "Fuel tank has been edited successfully.";
        }else{
            echo $query;
        }
    }

}
?>

<div style="
    
    margin-top: 10px;
    font-size: 15px;
"><?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if($errors) {echo '<span style="color: red;">Unable to save edited fuel tank:</span><br><br><span>'.implode("<br>",$errors) . '</span>';}else { echo '<span style="color:red;">'.$message .'</span>';} } ?></div>

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

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
         
$("#boxtitle").text('Time: ' + $(event.target).closest('a').data('date'));
$("#current").val($(event.target).closest('a').data('current'));
$("#max").val($(event.target).closest('a').data('max'));
$("#date").val($(event.target).closest('a').data('date'));
    });
});

</script>

<div id="tblFuels"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

<form action="edit_fuel.php" method="post" class="basic-grey" style="margin:0px;">
<input id="date" type="hidden" name="date">
  
<label>
        <span>Current :</span>
        <input id="current" type="text" name="current" placeholder="Current fuel">
    
    </label>

    <label>
        <span>Capacity :</span>
        <input id="max" type="text" name="max" placeholder="Max capacity of fuel tank">
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