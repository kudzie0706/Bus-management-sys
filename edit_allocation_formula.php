<?php $title = 'Edit Allocation Formula'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['km'])){
        $errors['km'] = 'Please fill in km';
    }else if(!preg_match('/^[\d]+$/', $_POST['km'])){
	$errors['km'] = 'The km should contains only numbers';
    }else{

$km = mysqli_real_escape_string($dbc,trim($_POST['km']));

    }

     if(empty($_POST['liter'])){
        $errors['liter'] = 'Please fill in liter';
    }else if(!preg_match('/^[\d]+$/', $_POST['liter'])){
	$errors['liter'] = 'The liter should contains only numbers';
    }else{

$liter = mysqli_real_escape_string($dbc,trim($_POST['liter']));

    }

	
    if(empty($errors)){


        $query  = "UPDATE fuel_allocation_formula ";
        $query .= "SET km='$km',liter='$liter'";

        $add = $dbc->query($query);

        if($add){
            $message = "Allocation formula edited successfully.";
        }else{
            echo $query;
        }
    }
}
?>

<div id="content">


<form action="edit_allocation_formula.php" method="post" class="basic-grey" style="margin:0px;">
  
 <h1>Edit Allocation Formula<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1> 

<?php 

$km = $dbc->query("SELECT km FROM fuel_allocation_formula")->fetch_object()->km;
$liter = $dbc->query("SELECT liter FROM fuel_allocation_formula")->fetch_object()->liter;

?>
<label>
        <span>Km :</span>
        <input id="km" type="text" name="km" placeholder="Ex: 50" value="<?php echo $km;?>">
    
    </label>

    <label>
        <span>Liter :</span>
        <input id="liter" type="text" name="liter" placeholder="5" value="<?php echo $liter;?>">
    </label>

     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Save"> 
    </label> 
        
    </div>
</form>

</div>
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>