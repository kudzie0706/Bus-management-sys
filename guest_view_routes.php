<?php $title="All routes"; ?>

<?php include('core/dbconnect.php'); ?>
<?php include('includes/header.html'); ?>

<div id="cssmenu">
		<div id="content" style="width:99.3%;">
        
        <div class="basic-grey" style="position: relative;" >
       <a href="index.php
              " class="button" style="
    position: absolute;
    right: 0;
    margin-right: 20px;                           
    margin-top: -5px;
    padding: 5px;
">Login here</a>
<h1 style="text-align:center;" id="h1Status">Available routes<span id="spanStatus">Login to access more features.</span>
    </h1>
    
    <img src="images/running_bus.gif" />
<img src="images/house.gif" style="
    margin-top: -65px;
    float: right;
">
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
      document.getElementById("tblRoutes").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_status.php",true);
  xmlhttp.send();

</script>

<div id="tblRoutes"></div>


</div>
</div>

</div>
     </div>
        </div>