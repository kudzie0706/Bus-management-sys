<?php $title = 'Edit Bus'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	if (isset($_REQUEST['delete'])) {
$dbc->query("DELETE FROM bus WHERE bno='{$_REQUEST['delete']}'");

}

	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['make'])){
        $errors['make'] = 'Please fill in make';
    }else if(!preg_match('/^[^\W_]+$/', $_POST['make'])){
	$errors['make'] = 'The make should contains only numbers and letters';
    }else {

$make = mysqli_real_escape_string($dbc,trim($_POST['make']));

    }

    if(empty($_POST['model'])){
        $errors['model'] = 'Please fill in model';
    }else if(!preg_match('/^[^\W_]+$/', $_POST['model'])){
	$errors['model'] = 'The model should contains only numbers and letters';
    }else{
        $model = mysqli_real_escape_string($dbc,trim($_POST['model']));

    }

    if(empty($_POST['year'])){
        $errors['year'] = 'Please fill in year';
    }else if(!preg_match('/^[\d]+$/', $_POST['year'])){
	$errors['year'] = 'The year should contains only numbers';
    }else{
        $year = mysqli_real_escape_string($dbc,trim($_POST['year']));
    }

    if(empty($_POST['capacity'])){
        $errors['capacity'] = 'Please fill in capacity';
    }else if(!preg_match('/^[\d]+$/', $_POST['capacity'])){
	$errors['capacity'] = 'The capacity should contains only numbers';
    }else{
        $capacity = mysqli_real_escape_string($dbc,trim($_POST['capacity']));
    }
	
    if(empty($_POST['bmi'])){
        $errors['bmi'] = 'Please fill in bus mileage';
    }else if(!preg_match('/^[\d]+$/', $_POST['bmi'])){
	$errors['bmi'] = 'The mileage should something like 80';
    }else{
        $bmi = mysqli_real_escape_string($dbc,trim($_POST['bmi']));
    }


  if(empty($_POST['status'])){
        $errors['status'] = 'Please fill in status';
    }else{
		
		if( $_POST['status'] == 'default')
		{
			$errors['status'] = 'Please select the status';
		}
		else{	
        $status = mysqli_real_escape_string($dbc,trim($_POST['status']));
		}
    }
	
    if(empty($errors)){

$id = mysqli_real_escape_string($dbc,trim($_POST['bno']));

        $query  = "UPDATE bus ";
        $query .= "SET make='$make',model='$model',year='$year',capacity='$capacity',bmileage='$bmi',status='$status' WHERE bno='$id' ";

        $add = $dbc->query($query);

        if($add){
            $message = "Bus Number: ". $id . " edited successfully.";
        }else{
            echo $query;
        }
    }
}
?>

<div style="
    
    margin-top: 10px;
    font-size: 15px;
"><?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if($errors) {echo '<span style="color: red;">Unable to save edited bus:</span><br><br><span>'.implode("<br>",$errors) . '</span>';}else { echo '<span style="color:red;">'.$message .'</span>';} } ?></div>

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
$("#make").val($(event.target).closest('a').data('make'));
$("#model").val($(event.target).closest('a').data('model'));
$("#year").val($(event.target).closest('a').data('year'));
$("#capacity").val($(event.target).closest('a').data('capacity'));
$("#bmi").val($(event.target).closest('a').data('bmi'));
$("#bno").val($(event.target).closest('a').data('id'));
$("#status").val($(event.target).closest('a').data('status'));
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

<form action="edit_bus.php" method="post" class="basic-grey" style="margin:0px;">
   <input id="bno" type="hidden" name="bno" >
<label>
        <span>Make :</span>
        <input id="make" type="text" name="make" placeholder="Ex: Honda">
    
    </label>

    <label>
        <span>Model :</span>
        <input id="model" type="text" name="model" placeholder="Ex: D77">
    </label>

    <label>
        <span>Year  :</span>
        <input id="year" type="text" name="year" placeholder="Year of bus">
    </label>
    
    <label>
        <span>Capacity  :</span>
        <input id="capacity" name="capacity" placeholder="How many seats?" type="text">
    </label> 

<label>
        <span>Bus Mileage :</span>
        <input id="bmi" type="text" name="bmi" placeholder="Exp: 80 cm">
    </label>
             <label>
        <span>Status :</span><select name="status" id="status">
                <option value="default">--Choose the status--</option>
        <option value="Ready">Ready</option>
        <option value="Outgoing">Outgoing</option>
        </select>
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