<?php $title = 'Add Maintenance Record'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 0){
	include('includes/staff-menu.html');

	
	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
  
    if(empty($_POST['bno'])){
        $errors['bno'] = 'Please fill in bus number';
    }else{
        $bno = mysqli_real_escape_string($dbc,trim($_POST['bno']));

 if($check = $dbc->query("SELECT bno FROM bus WHERE bno = '$bno'")){
            if(!($check->num_rows)){
                        $errors['bno'] = 'The bus number does not exist';
            }
}
            else
            {
              $errors['bno'] = 'The query did not work';
             }


    }
	
    if(empty($_POST['s_description'])){
        $errors['s_description'] = 'Please fill in description';
    }else{
        $s_description = mysqli_real_escape_string($dbc,trim($_POST['s_description']));
    }

    if(empty($errors)){

$lsResult = $dbc->query("SELECT l_service from maintanance where bno = '$bno' ORDER BY main_id DESC LIMIT 1 ");

if( !($lsResult->lengths))
{
$l_service = $dbc->query("SELECT bmileage FROM bus WHERE bno = '$bno'")->fetch_object()->bmileage;
$ls_date = date("Y-m-d H:i:s");
$n_service = 5000 + $l_service;
$servicedate = $ls_date;
}
else
{
$l_service = $dbc->query("SELECT n_service FROM maintanance WHERE bno = '$bno' ORDER BY main_id DESC LIMIT 1")->fetch_object()->n_service;
$ls_date = $dbc->query("SELECT servicedate FROM maintanance WHERE bno = '$bno' ORDER BY main_id DESC LIMIT 1")->fetch_object()->servicedate;
$n_service = 5000 + $l_service;
$servicedate = date("Y-m-d H:i:s");
}

        $query  = "INSERT INTO maintanance ";
        $query .= "(bno,l_service,ls_Date,s_description,servicedate,n_service) ";
        $query .= "VALUES ('$bno','$l_service','$ls_date','$s_description','$servicedate','$n_service')";

        $add = $dbc->query($query);

        if($add){
            $message = "A new record for bus no: ". $bno . " has been added.";
        }else{
            echo $query;
        }
    }
}
?>

<script>

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

</script>

<div id="content">
<form action="add_maintenance.php" method="post" class="basic-grey">
    <h1>Add Maintenance Record<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1>


    <label>
        <span>Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number"style="width: 60%;">

        <a href="#bno" style="font-size:10px"  onclick="viewBuses();">Select bus</a>
    </label>
    <div id="tblBuses"></div>

<label>
        <span>Description :</span>
<textarea id="s_description" name="s_description" rows="10" cols="70"></textarea>
    </label>
     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Submit"> 
    </label> 
</form>
</div>
<?php include('sidebar.php'); ?>
<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>