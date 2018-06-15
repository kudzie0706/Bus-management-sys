<?php $title = 'Locate Bus'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1 || $_SESSION['type'] == 0 || $_SESSION['type'] == 4){
		if($_SESSION['type'] == 1)
	include('includes/admin-menu.html');
		else if($_SESSION['type'] == 0)
	include('includes/staff-menu.html');
	else if($_SESSION['type'] == 4){
			include('includes/user-menu.html');
		} 
		
	if ($_SERVER['REQUEST_METHOD']=='POST'){

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
  if(empty($errors)){

$id = mysqli_real_escape_string($dbc,trim($_POST['bno']));

$status = $dbc->query("SELECT status FROM bus WHERE bno = '$id' ")->fetch_object()->status;

            $message = "Bus no: <span id='busNo'>". $id . "</span> with the status: " . $status;
    }


}
?>



<div id="content">

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
  
  xmlhttp.open("GET","get_routes_byID.php?id="+str,true);
  xmlhttp.send();
   
      
	  
} 

</script>

<form action="locate.php" method="post" class="basic-grey" >

<h1>Locate Bus<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Enter bus number and search.'; } ?></span>
    </h1>



    <label>
        <span>Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number" style="width: 60%;">

        <a href="#bno" style="font-size:10px" onclick="viewBuses();">Select bus</a>
    </label>
    <div id="tblBuses"></div>
    
    
     


     <div align="center"><label>
         
         <?php if($_SERVER['REQUEST_METHOD'] != 'POST')
		 {
        echo '<input type="submit" class="button" value="Search">'; 
		
		 }
		 else
		 {
			  ?>
			 <script src="https://maps.googleapis.com/maps/api/js"></script>
             
             <script>
	
	  
	  $(window).load(function(){
		  
		       initialize()
			   });
			   		 
var map;
var marker;

function initialize() {
    var latlng = new google.maps.LatLng(0,0);
    var myOptions = {
        maxZoom: 20,
        zoom: 18,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

   marker = new google.maps.Marker({
                position: latlng,
            });
	marker.setMap(map);
}

	  var bno = document.getElementById("busNo").innerText;
	
	setInterval( function()
	{  
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var location = (xmlhttp.responseText);
	  location = location.split("/");
	  
	var myCenter = new google.maps.LatLng(parseFloat(location[0]), parseFloat(location[1]));
	
	 marker.setMap(null);
     map.setCenter(myCenter);
            marker = new google.maps.Marker({
                position: myCenter,
            });
			
			marker.setMap(map);
	 
    }
  }
  console.log(bno);
  xmlhttp.open("GET","get_coordinates.php?bno=" + bno,true);
  xmlhttp.send();
	},1000);
	  
	 

</script>

             <div id="map_canvas" style="width:500px;height:400px;background-color: #CCC;"></div>
             
		<?php } ?>
		
    </label></div> 
</form>
</div>
<?php if($_SESSION['type'] == 4)
{
	include('user_sidebar.php'); 
}
else
{
	include('sidebar.php'); 
}?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>