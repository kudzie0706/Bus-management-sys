<?php $title = 'Add Bus'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	
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

	
    if(empty($errors)){

do {
  
  $bno = '';
  for ($i = 0; $i < 5; $i++) {
    $bno .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('A'), ord('Z')));
  }
 if($check = $dbc->query("SELECT bno FROM bus WHERE bno = '$bno'")){
            if($check->num_rows){
                $exist = true;
            }
            else
           {
              $exist = false;
            }
        }
} while ($exist);

        $query  = "INSERT INTO bus ";
        $query .= "(bno,make,model,year,capacity,bmileage,status) ";
        $query .= "VALUES ('$bno','$make','$model','$year','$capacity','$bmi','Ready')";

        $add = $dbc->query($query);

        if($add){
            $message = "A new bus: ". $bno . " has been added.";
        }else{
            echo $query;
        }
    }
}
?>

<div id="content">
<form action="add_bus.php" method="post" class="basic-grey">
    <h1>Add Bus<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1>

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
        <input id="bmi" type="text" name="bmi" placeholder="Exp: 80">
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