<?php $title = 'Add Fuel'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');


?>



<div id="content">


<link href="includes/kendo.common.min.css" rel="stylesheet" />
<link href="includes/kendo.default.min.css" rel="stylesheet" />
<script src="includes/jquery.min.js"></script>
<script src="includes/angular.min.js" ></script>
<script src="includes/kendo.all.min.js" ></script>




<!-- -->

        <div class="loading" align="center">
            <div id="loadingProgressBar"></div>
        </div>
        <div class="loadingInfo" align="center">
            <h2>Fuel tank</h2>
            <div class="statusContainer">
                <p>
                Current fuel: <span class="loadingStatus">0%</span> <br />
                </p>
            </div>
            <input type="text" id="reloadAmount" class="reloadTextbox" name="reloadAmount" /><br><br><button class="k-button reloadButton">Top up</button>
        </div>

    <script>
        $(document).ready(function () {

            $("#loadingProgressBar").kendoProgressBar({
                orientation: "vertical",
                showStatus: false,
                animation: false,
                complete: onComplete,
change: onChange
            });

            load(<?php $result = $dbc->query("SELECT * FROM fuel_tank ORDER BY date DESC LIMIT 1"); 

while($row = $result->fetch_array(MYSQLI_ASSOC)) {

 $current = ($row['current'] / $row['max']) * 100;
echo $current;	
}
	?>,<?php $result = $dbc->query("SELECT * FROM fuel_tank ORDER BY date DESC LIMIT 1"); 

while($row = $result->fetch_array(MYSQLI_ASSOC)) {

 $current = ($row['current'] / $row['max']) * 100;
echo $current;	
}
	?>);
          $(".reloadButton").show();
        });

        function onChange(e) {
            $(".loadingStatus").text(e.value + "%");
        }

        function onComplete(e) {
        
            $(".loadingInfo h2").text("Tank is filled");
          $(".reloadButton").hide();
            
        }
      
        function load(currentFuel,newFuel) {
            var pb = $("#loadingProgressBar").data("kendoProgressBar");
            pb.value(currentFuel); /*current fuel*/

            var interval = setInterval(function () {
                if (pb.value() < newFuel) { /*new fuel*/
                    pb.value(pb.value() + 0.1);
                } else {
                    clearInterval(interval);
                }
if(pb.value() > 80)
{
  document.getElementById("loadingProgressBar").children[0].style.background = "green";
document.getElementById("loadingProgressBar").children[0].style.border = "1px solid green";
}
else if(pb.value() > 60)
{
  document.getElementById("loadingProgressBar").children[0].style.background = "rgb(214, 255, 0)";
document.getElementById("loadingProgressBar").children[0].style.border = "1px solid rgb(214, 255, 0)";
}
else if(pb.value() > 40)
{
  document.getElementById("loadingProgressBar").children[0].style.background = "orange";
document.getElementById("loadingProgressBar").children[0].style.border = "1px solid orange";
}
else if(pb.value() > 20)
{
  document.getElementById("loadingProgressBar").children[0].style.background = "rgb(255, 62, 2)";
document.getElementById("loadingProgressBar").children[0].style.border = "1px solid rgb(255, 62, 2)";
}
else if(pb.value() > 0)
{
  document.getElementById("loadingProgressBar").children[0].style.background = "red";
document.getElementById("loadingProgressBar").children[0].style.border = "1px solid red";
}
            }, 30);
 $(".loadingInfo h2").text("Fuel tank");
        }
      
         $(".reloadButton").click(function () {
            
var amount = $("#reloadAmount").val();
var current = $(".loadingStatus").text();

 $.ajax({
                type: "POST",
                url: "insert_fuel.php", //Your required php page
                data: "amount="+ amount, //pass your required data here
                success: function(response){
                    $(".loadingInfo h2").text("Reloading fuel..");
 if(response.indexOf("fuel") ==-1){   load(current,response);} else { $(".loadingInfo h2").text(response);}

                }
            });


        });
      
    </script>
    <style scoped>
        .k-progressbar
        {
            width: 108px;
            height: 300px;
        }
        
        #loadingProgressBar
        {
            margin-left: 10px;
        }
        
        .loading
        {
            margin-top: 50px;
        }
        .loadingInfo
        {
            margin: 20px 0 0 30px;
        }
      
        .reloadButton
        {
 margin-left:auto;
    margin-right:auto;
    //max-width: 500px;
    background: #F7F7F7;
    padding: 10px 0px 10px 0px;
    font: 12px Georgia, "Times New Roman", Times, serif;
    color: #888;
    text-shadow: 1px 1px 1px #FFF;
    border:1px solid #E4E4E4;
width:15%;
margin-bottom:10px;
        }


       .reloadTextbox
        {
  margin-left:auto;
    margin-right:auto;
    //max-width: 500px;
    background: #F7F7F7;
    padding: 10px 0px 10px 0px;
    font: 12px Georgia, "Times New Roman", Times, serif;
    color: #888;
    text-shadow: 1px 1px 1px #FFF;
    border:2px solid #960;
width:60%;
margin-top:10px;
text-align:center;
        }
    </style>

<!-- -->

</div>
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>