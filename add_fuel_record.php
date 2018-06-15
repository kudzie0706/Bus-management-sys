<?php $title = 'Add Fuel Record'; // In this line I am defining the Title of the page which works with the design of the header.html?>
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

    if(empty($_POST['rid'])){
        $errors['rid'] = 'Please fill in route id';
    }else{
        $rid = mysqli_real_escape_string($dbc,trim($_POST['rid']));

 if($check = $dbc->query("SELECT rid FROM route WHERE rid = '$rid'")){
            if(!($check->num_rows)){
                        $errors['rid'] = 'The route id does not exist';
            }
}
            else
            {
              $errors['rid'] = 'The query did not work';
             }


    }
	
    if(empty($_POST['allocated'])){
        $errors['allocated'] = 'Please fill in fuel allocated';
    }else if(!preg_match('/^[\d]+$/', $_POST['allocated'])){
	$errors['allocated'] = 'The fuel should contains only numbers';
    }else{
        $allocated = mysqli_real_escape_string($dbc,trim($_POST['allocated']));

$sfuel = $_POST['inputfuel'];

$result = $allocated - $sfuel;

if($result > 30)
{
  $errors['allocated'] = 'Allocated fuel('. $allocated .') is way more than suggested fuel('. $sfuel .') [Over '.$result.']';
}

$current = $dbc->query("SELECT current FROM fuel_tank ORDER BY date DESC LIMIT 1")->fetch_object()->current;
$remain = $current - $allocated;

if($remain < 0 )
{
  $errors['allocated'] = 'Fuel is not enough for your request. (Current fuel: ' .$current. ' / Requested fuel: '.$allocated.')<br><br>Contact the admin for refilling the fuel.'; 
}
    }

    if(empty($_POST['time'])){
        $errors['time'] = 'Please fill in time';
    }else{
        $time = mysqli_real_escape_string($dbc,trim($_POST['time']));
    }


    if(empty($errors)){

$current = $dbc->query("SELECT current FROM fuel_tank ORDER BY date DESC LIMIT 1")->fetch_object()->current;
$max = $dbc->query("SELECT max FROM fuel_tank ORDER BY date DESC LIMIT 1")->fetch_object()->max;
$allocated = $_POST['allocated'];
$reserve = $current - $allocated;

      $query1  = "INSERT INTO fuel_tank ";
        $query1 .= "(current,max) VALUES ('$reserve','$max')";
$add1 = $dbc->query($query1);

        $query  = "INSERT INTO fuel ";
        $query .= "(bno,rid,Fuel_allocated,Date,Fuel_Reserve) ";
        $query .= "VALUES ('$bno','$rid','$allocated','$time','$reserve')";

        $add = $dbc->query($query);

        if($add && $add1){
            $message = "A new record for fuel on bus number: ". $bno . " has been added.";
        }else{
            echo $query;
 echo '<br>'. $query1;
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

function viewRoutes() {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tblRoutes").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_routes.php",true);
  xmlhttp.send();
}

function getSuggestedFuel(str) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("suggested").innerHTML= "Suggested fuel: <span id=\"fuel\">" + xmlhttp.responseText +"</span> liter";
      document.getElementById("inputfuel").value = xmlhttp.responseText;  
  }
  }

url= "get_suggested_fuel.php?id=" + str;

  xmlhttp.open("GET",url,true);
  xmlhttp.send();
}


function setBus(str)
{
   document.getElementById("bno").value =str;
   document.getElementById("tblBuses").innerHTML = '';
} 

function setRoute(str)
{
   document.getElementById("rid").value =str;
   document.getElementById("tblRoutes").innerHTML = '';
document.getElementById("allocated").style.width = '50%';
getSuggestedFuel(str);
} 

</script>

<div id="content">
<form action="add_fuel_record.php" method="post" class="basic-grey">
    <h1>Add Fuel Record<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1>

<input id="inputfuel" type="hidden" name="inputfuel">
    <label>
        <span>Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number"style="width: 60%;">

        <a href="#bno" style="font-size:10px"  onclick="viewBuses();">Select bus</a>
    </label>
    <div id="tblBuses"></div>
    <label>
        <span>Route Id :</span>
        <input id="rid" type="text" name="rid" placeholder="Route id"style="width: 60%;">

        <a href="#rid" style="font-size:10px"  onclick="viewRoutes();">Select route</a>
    </label>
    <div id="tblRoutes"></div>

<label>
        <span>Fuel Allocated :</span>
<input id="allocated" type="text" name="allocated" placeholder="Fuel">
<a style="font-size:10px" id="suggested"></a>
    </label>
<label>
        <span>Time :</span>
<input id="time" type="datetime-local" name="time">
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