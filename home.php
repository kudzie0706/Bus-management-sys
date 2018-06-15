<?php $title="Home"; ?>

<?php include('core/dbconnect.php'); ?>
<?php include('includes/header.html'); ?>

<?php 

if(isset($_SESSION['type']))
{
	
	
if($_SESSION['type'] == 0 || $_SESSION['type'] == 1 || $_SESSION['type'] == 4)
{
	if ($_SESSION['type'] == 0){
			include('includes/staff-menu.html');
		}elseif($_SESSION['type'] == 1){
			include('includes/admin-menu.html');
		} 
		elseif($_SESSION['type'] == 4){
			include('includes/user-menu.html');
		} 
?>
<div id="content" style="width:99.3%;">

<?php if($_SESSION['type'] != 4){ ?>

<div id="leftContent" class="basic-grey" style="float:left;width:65%;background:none;border-bottom:none;">
<h1>Outgoing Buses</h1>

<?php 

$result= $dbc->query("SELECT * FROM bus where status='Outgoing'"); 

echo '<table class="table-fill" style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th style="
    text-align: left;
    font-size: 13px;
">Route ID</th><th style="
    text-align: left;
    font-size: 13px;
">Departure Time</th><th style="
    text-align: left;
    font-size: 13px;
">Arrival Time</th><th style="
    text-align: left;
    font-size: 13px;
">Bus Number</th><th colspan="3" style="
    text-align: left;
    font-size: 13px;
">Route (Departure to Destination)</th></tr></thead>
<tbody class="table-hover">';

while($row = $result->fetch_array(MYSQLI_ASSOC)) {

$bno = $row['bno'];

$route = $dbc->query("SELECT * FROM route where bno='$bno'");




while($routeRow = $route->fetch_array(MYSQLI_ASSOC)) {

$dtime = strtotime($routeRow["d_time"]);
$newd = date('H:i A', $dtime);


$atime = strtotime($routeRow["a_time"]);
$newa = date('H:i A', $atime);


echo '<tr>';
echo '<td class="text-left" style="font-size:15px"><span>' . $routeRow["rid"] . '</span></td>';
echo '<td class="text-left" style="font-size:15px"><span>' . $newd . '</span></td>';
echo '<td class="text-left" style="font-size:15px"><span>' . $newa . '</span></td>';
echo '<td class="text-left" style="font-size:15px"><span>' . $routeRow["bno"] . '</span></td>';
echo '<td style="
    border-right: none;
    text-align: center;
"><span>' . $routeRow["d_station"] . '</span></td>';
echo '<td class="text-left" style="
    border-right: none;
"><img src="images/arrows.gif" style="
    height: 56%;
"></td>';
echo '<td style="
    text-align: center;
"><span>' . $routeRow["a_station"] . '</span></td>';

echo '</tr>';


}
}

echo '</tbody></table>';

?>

</div>

<div id="rightContent" style="float:right;padding-right:10%;">


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
            <div class="statusContainer" style="
    margin-bottom: 10px;
">
                <p>
                Current fuel: <span class="loadingStatus">0%</span> <br />
                </p>
<br>
<?php if ($_SESSION['type'] == 1)
{
	echo '<span style="font-family: tahoma;"><a href="add_fuel.php">Top up now!</a></span>';
}
?>
            </div>
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

        function onChange(e) {
            $(".loadingStatus").text(e.value + "%");
        }

        function onComplete(e) {
        
            $(".loadingInfo h2").text("Tank is filled");
            
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
      
     
    </style>

<!-- -->

</div>

<?php } else { ?>

    
     <script type="text/javascript" src="includes/jssor.core.js"></script>
    <script type="text/javascript" src="includes/jssor.utils.js"></script>
    <script type="text/javascript" src="includes/jssor.slider.js"></script>
        <script>

        jssor_slider1_starter = function (containerId) {

            var _SlideshowTransitions = [
            //Fade
            { $Duration: 1200, $Opacity: 2 }
            ];

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 3000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 10,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$(containerId, options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
                else
                    $JssorUtils$.$Delay(ScaleSlider, 30);
            }

            ScaleSlider();
            $JssorUtils$.$AddEvent(window, "load", ScaleSlider);


            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $JssorUtils$.$OnWindowResize(window, ScaleSlider);
            }

            //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
            //    $JssorUtils$.$AddEvent(window, "orientationchange", ScaleSlider);
            //}
            //responsive code end
        };
    </script>
    
<script>

function searchRoute()
{
	var departure = document.getElementById("departure").value;
	var destination = document.getElementById("destination").value;
	
	if(departure === "default" || destination === "default")
	{
		document.getElementById("searchContent").innerText = "Please select both location first.";
	}
	else
	{
	  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("searchContent").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","search_route.php?d_s=" + departure + "&a_s=" + destination,true);
  xmlhttp.send();
	}
	
}
</script>
<div class="basic-grey">
<h1>Welcome, <?php echo $_SESSION['name'] . "." ?> <span>Feel free to contact us if you have any questions.</span></h1>

<div align="center">
        <span>Search route:</span>
        <select name="departure" id="departure" style="width:20%;">
         <option value="default">Departure station</option>
        <?php 
		
		$result= $dbc->query("SELECT DISTINCT d_station FROM route");
		
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
		 echo '<option value="'.$row['d_station'].'">'.$row['d_station'].'</option>';	
		}

		
		?>
        </select>
        
        <span> to </span>
        <select name="destination" id="destination" style="width:20%;"><option value="default">Arrival station</option>
        
                <?php 
		
		$result= $dbc->query("SELECT DISTINCT a_station FROM route");
		
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
		 echo '<option value="'.$row['a_station'].'">'.$row['a_station'].'</option>';	
		}

		
		?>
        
        </select>
        
    <a onclick="searchRoute();" class="button" style="
    padding: 10px 25px 10px 25px;
    font-family: "Courier New", Courier, monospace;
">Search</a>
</div>
<div style="clear:both"></div>
<div id="searchContent" align="center" style="
    padding-bottom: 10px;
">
</div>

<div align="center" style="
    border-top: 1px solid #E4E4E4;
    padding-top: 10px;
">
    <!-- Jssor Slider Begin -->
    <!-- You can move inline styles to css file or css block. -->
    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden; ">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 600px; height: 300px; overflow: hidden;">
            <div>
                <img u="image" src="images/slider1.jpg" />
            </div>
            <div>
                <img u="image" src="images/slider2.jpg" />
            </div>
            <div>
                <img u="image" src="images/slider3.jpg" />
            </div>
        </div>

       <!-- Bullet Navigator Skin Begin -->
        <style>
            /* jssor slider bullet navigator skin 05 css */
            /*
            .jssorb05 div           (normal)
            .jssorb05 div:hover     (normal mouseover)
            .jssorb05 .av           (active)
            .jssorb05 .av:hover     (active mouseover)
            .jssorb05 .dn           (mousedown)
            */
            .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
                background: url(images/slider_bullet.png) no-repeat;
                overflow: hidden;
                cursor: pointer;
            }

            .jssorb05 div {
                background-position: -7px -7px;
            }

                .jssorb05 div:hover, .jssorb05 .av:hover {
                    background-position: -37px -7px;
                }

            .jssorb05 .av {
                background-position: -67px -7px;
            }

            .jssorb05 .dn, .jssorb05 .dn:hover {
                background-position: -97px -7px;
            }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb05" style="position: absolute; bottom: 16px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 16px; HEIGHT: 16px;"></div>
        </div>
        <!-- Bullet Navigator Skin End -->
        <!-- Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 12 css */
            /*
            .jssora12l              (normal)
            .jssora12r              (normal)
            .jssora12l:hover        (normal mouseover)
            .jssora12r:hover        (normal mouseover)
            .jssora12ldn            (mousedown)
            .jssora12rdn            (mousedown)
            */
            .jssora12l, .jssora12r, .jssora12ldn, .jssora12rdn {
                position: absolute;
                cursor: pointer;
                display: block;
                background: url(images/slider_arrow.png) no-repeat;
                overflow: hidden;
            }

            .jssora12l {
                background-position: -16px -37px;
            }

            .jssora12r {
                background-position: -75px -37px;
            }

            .jssora12l:hover {
                background-position: -136px -37px;
            }

            .jssora12r:hover {
                background-position: -195px -37px;
            }

            .jssora12ldn {
                background-position: -256px -37px;
            }

            .jssora12rdn {
                background-position: -315px -37px;
            }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora12l" style="width: 30px; height: 46px; top: 123px; left: 0px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora12r" style="width: 30px; height: 46px; top: 123px; right: 0px">
        </span>
        <!-- Arrow Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">responsive carousel</a>
        <!-- Trigger -->
        <script>
            jssor_slider1_starter('slider1_container');
        </script>

    </div>
    <!-- Jssor Slider End -->
</div>
    </div>
<?php }?>
</div>


<?php 

include('includes/footer.html'); 

}
else if($_SESSION['type'] == 3 )
{ //starts

if ($_SERVER['REQUEST_METHOD']=='POST'){
	
	  $errors = array();
    if(empty($_POST['bno'])){
        $errors['bno'] = 'Please select the bus.';
    }else if(!preg_match('/^[a-zA-Z\d]+$/', $_POST['bno'])){
	$errors['bno'] = 'The bus number should contains only numbers and letters';
    }else{

$bno = mysqli_real_escape_string($dbc,trim($_POST['bno']));

    }
	    if(empty($_POST['rid'])){
        $errors['rid'] = 'Please select the route.';
    }else if(!preg_match('/^[a-zA-Z\d]+$/', $_POST['rid'])){
	$errors['rid'] = 'The route id should contains only numbers and letters';
    }else{

$rid = mysqli_real_escape_string($dbc,trim($_POST['rid']));

    }
	
	   if(($_POST['ddate-h']) == "default" ||  ($_POST['ddate-m']) == "default" || ($_POST['ddate-ap']) == "default"){
        $errors['ddate'] = 'Please enter the departure time.';
    }else{

$h = mysqli_real_escape_string($dbc,trim($_POST['ddate-h']));
$m = mysqli_real_escape_string($dbc,trim($_POST['ddate-m']));
$ap = mysqli_real_escape_string($dbc,trim($_POST['ddate-ap']));

$dtime = $h . ':' . $m . ' '. $ap;

    }
	
	   if(empty($_POST['sbmi'])){
        $errors['sbmi'] = 'Please enter the start mileage.';
    }else{

$sbmi = mysqli_real_escape_string($dbc,trim($_POST['sbmi']));

    }
	
	   if(empty($_POST['ebmi'])){
        $errors['ebmi'] = 'Please enter the end mileage.';
    }else if(!preg_match('/^[\d]+$/', $_POST['ebmi'])){
	$errors['ebmi'] = 'The end mileages should contains only numbers';
    }else{
		
$ebmi = mysqli_real_escape_string($dbc,trim($_POST['ebmi']));

if($ebmi <= $sbmi)
{
	$errors['ebmi'] = 'Something wrongs with the end mileage.';
}

    }
	
   if(($_POST['adate-h']) == "default" || ($_POST['adate-m']) == "default" || ($_POST['adate-ap']) == "default"){
        $errors['adate'] = 'Please enter the arrival time.';
    }else{

$ah = mysqli_real_escape_string($dbc,trim($_POST['adate-h']));
$am = mysqli_real_escape_string($dbc,trim($_POST['adate-m']));
$aap = mysqli_real_escape_string($dbc,trim($_POST['adate-ap']));

$atime = $ah . ':' . $am . ' '. $aap;

    }
	
	   if(($_POST['tdate-y']) == "default" || ($_POST['tdate-m']) == "default" || ($_POST['tdate-d']) == "default"){
        $errors['tdate'] = 'Please enter the route date.';
    }else{

$ty = mysqli_real_escape_string($dbc,trim($_POST['tdate-y']));
$tm = mysqli_real_escape_string($dbc,trim($_POST['tdate-m']));
$td = mysqli_real_escape_string($dbc,trim($_POST['tdate-d']));
 
$tdate = $ty . "-" . $tm . "-" . $td;

    }
	
	
	if(empty($errors)){

		$user_id = $_SESSION['user_id'];
		
		$d_id = $dbc->query("SELECT d_id FROM drivers WHERE user_id = '$user_id'")->fetch_object()->d_id;
		
		$query  = "INSERT INTO trip ";
        $query .= "(bno,rid,s_mileage,dtime,e_mileage,atime,date,d_id) ";
        $query .= "VALUES ('$bno','$rid','$sbmi','$dtime','$ebmi','$atime','$tdate','$d_id')";
		
		$add = $dbc->query($query);
		
		if($add)
		{
			  $query1  = "UPDATE bus ";
        $query1 .= "SET bmileage='$ebmi', status='Ready' WHERE bno='$bno' ";

			$add1 = $dbc->query($query1);
			
			if($add1)
			{
				$message = "Your trip has been submitted!";	
			}
		}
		else
		{
			$message = "Your trip has not been submitted!<br>Error: " . $query;	
		}
	}
	
}

?>
<div id="cssmenu">
		<div id="content" style="width:99.3%;">
        
<script>

//viewBuses
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


//setBus(str)
function setBus(str)
{

   document.getElementById("bno").value =str;
   
   
     var bmi =document.getElementById( str + "+bmileage").innerText;
	  		
	document.getElementById("lblSbmi").innerHTML = '<span id="spanSmi">Start Mileage :</span><input id="sbmi" type="text" name="sbmi" placeholder="Bus start mileage" value="'+bmi+'">';
   
		
     if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
	        
		
	document.getElementById("lblRoute").innerHTML = '<span id="spanRid">Route No :</span><input id="rid" type="text" name="rid" placeholder="Select the route.." >';
		
			
      document.getElementById("tblBuses").innerHTML=xmlhttp.responseText;
    }
  }
  
  xmlhttp.open("GET","get_routes_byID.php?id="+str,true);
  xmlhttp.send();
   
      
	  
} 

//setRoute(str)
function setRoute(str)
{

   document.getElementById("rid").value =str;
   document.getElementById("tblBuses").innerHTML = '';
     
} 

//setCoordinates
function setCoordinates(la,lo)
{	  
	  var bno = document.getElementById("bno").value;

	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    document.getElementById("h1Status").innerHTML = "Trip started<span  style=\"color:green\" id=\"spanStatus\">Locating bus no: "+bno+"..</span>";
    }
  }
  xmlhttp.open("GET","set_coordinates.php?bno=" + bno + "&la=" + la + "&lo="+ lo ,true);
  xmlhttp.send();
	  
}

	
//getCurrentLocation
function getCurrentLocation()
{
	var bno = document.getElementById("bno").value;
	var ddate_h = document.forms["myForm"]["ddate-h"].value;
	var ddate_m = document.forms["myForm"]["ddate-m"].value;
	var ddate_ap = document.forms["myForm"]["ddate-ap"].value;
	
	if(bno && (ddate_h != "default") && (ddate_m != "default") && (ddate_ap != "default"))
	{
	var gc = document.getElementById("gC").innerText;
	
	if(gc === "Start")
	{
		document.getElementById("gC").innerText = "Stop";
		var content;

	
 document.getElementById("h1Status").innerHTML = "Start a trip <span  style=\"color:green\" id=\"spanStatus\">Locating bus..</span>";

		 // Try HTML5 geolocation
		  if(navigator.geolocation) {
			navigator.geolocation.watchPosition(function(position) {
			  var latitude = position.coords.latitude;
			  var longitude = position.coords.longitude;
		

			 setCoordinates(latitude,longitude);
			  
			}, function(error) {


			  
			      switch (error.code) {
        case error.PERMISSION_DENIED:
            content = "This website does not have permission to use the Geolocation API, error message: " + error.message;
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";
            break;
        case error.POSITION_UNAVAILABLE:
            content = "You need a stable internet connection, error message: " + error.message;
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";
            break;
        case error.PERMISSION_DENIED_TIMEOUT:
            content = "The current position could not be determined within the specified timeout period, error message: " + error.message;
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";            
            break;
	 case error.TIMEOUT:
	content = "Could not determined the current location, have you enabled your GPS in phone?, error message: " + error.message;
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";   
	 case error.UNKNOWN_ERROR:
	content = "An unknown error occured, error message: " + error.message;
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";      
    }

document.getElementById("gC").innerText = "Start";

			},{enableHighAccuracy: true});
		  } else {
			// Browser doesn't support Geolocation

    var content = 'Error: Your device doesn\'t support geolocation.';
document.getElementById("h1Status").innerHTML = "Start a trip <span style=\"color:red;\">"+content+"</span>";


document.getElementById("gC").innerText = "Start";
		  }
  
	}
	else
	{
		document.getElementById("gC").style.display = "none";
		document.getElementById("sB").style.display = "block";
		
		document.getElementById("lblEbmi").innerHTML = '<span id="spanEmi">End Mileage :</span><input id="ebmi" type="text" name="ebmi" placeholder="Bus end mileage">';
		
		        
		
		document.getElementById("lblAtime").innerHTML = '<span id="spanAtime">Arrival time :</span><select name="adate-h" style="width:20%"><option value="default">Hours (Arrival Time)</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select><select name="adate-m" id="adate-m" style="width:20%"><option value="default">Minutes (Arrival Time)</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option></select><select name="adate-ap" style="width:20%"><option value="am">AM</option><option value="pm">PM</option></select>';
		
				document.getElementById("tDate").innerHTML = '<span id="spanRdate">Route date :</span><select name="tdate-y" id="tdate-y" style="width:20%"><option value="default">Year (Route Date)</option><option value="2014">2014</option></select><select name="tdate-m" id="tdate-m" style="width:20%"><option value="default">Month (select year first)</option></select><select name="tdate-d" id="tdate-d" style="width:20%"><option value="default">Day (select month first)</option></select>';		
	}
	}
	else
	{
		 document.getElementById("h1Status").innerHTML = "Start a trip<span style=\"color:red;\"> Please make sure the bus number and departure time is set correctly.</span>"	;
	}
}

function validateForm() {
	

    var bno = document.forms["myForm"]["bno"].value;
	var rid = document.forms["myForm"]["rid"].value;
	var sbmi = document.forms["myForm"]["sbmi"].value;

var dtime_h = document.forms["myForm"]["ddate-h"].value;
var dtime_m = document.forms["myForm"]["ddate-m"].value;
var dtime_ap = document.forms["myForm"]["ddate-ap"].value;

	var ebmi = document.forms["myForm"]["ebmi"].value;

	var atime_h = document.forms["myForm"]["adate-h"].value;
var atime_m = document.forms["myForm"]["adate-m"].value;
var atime_ap = document.forms["myForm"]["adate-ap"].value;

	var tdate_y = document.forms["myForm"]["tdate-y"].value;
	var tdate_m = document.forms["myForm"]["tdate-m"].value;
	var tdate_d = document.forms["myForm"]["tdate-d"].value;
	
	var isNull = false;
	var errorMsg = 'Opss.. Something wrong.';
	
    if (bno==null || bno=="") {
        errorMsg += "<br>Please select the bus.";
        isNull = true;
    }
	    if (rid==null || rid=="") {
        errorMsg += "<br>Please select the route.";
        isNull = true;
    }
	    if (sbmi==null || sbmi=="") {
        errorMsg += "<br>Please enter the bus start mileage.";
        isNull = true;
    }
	    if (dtime_h == "default" || dtime_m == "default" || dtime_ap == "default") {
        errorMsg += "<br>Please enter the departure time.";
        isNull = true;
    }
	    if (ebmi==null || ebmi=="") {
        errorMsg += "<br>Please enter the bus end mileage.";
        isNull = true;
    }
	    if (atime_h=="default" || atime_m=="default" || atime_ap=="default") {
        errorMsg += "<br>Please enter the arrival time.";
        isNull = true;
    }
	    if (tdate_y == "default" || tdate_m == "default" || tdate_d == "default") {
        errorMsg += "<br>Please select the route date.";
        isNull = true;
    }

   if(ebmi <= sbmi)
{
   errorMsg += "<br>End mileage should more than start mileage."
   isNull = true;
}
	
	if(isNull)
	{document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = errorMsg;
		return false;
	}
	else
	{
		return true;	
	}
}

</script>
       
        <form action="home.php" method="post" class="basic-grey" style="position: relative;"  id="myForm" onsubmit="return validateForm()">
       <a href="logout.php
              " class="button" style="
    position: absolute;
    right: 0;
    margin-right: 20px;                           
    margin-top: -5px;
    padding: 5px;
">Logout</a>
<h1 style="text-align:center;" id="h1Status">Start a trip<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong! Click start and stop again to re-submit it.</span><span>'.implode("<br>",$errors);}} else { echo '<span id="spanStatus">Enter bus number and go.'; } ?></span>
    </h1>



    <label style="text-align:center">
        <span id="spanBno">Bus No :</span>
        <input id="bno" type="text" name="bno" placeholder="Bus number" style="width: 60%;">

        <a href="#bno" style="font-size:10px" onclick="viewBuses();">Select bus</a>
    </label>
    
        <label id="lblSbmi" style="text-align:center">

    </label>
    
    <label id="lblRoute" style="text-align:center">
    </label>
    
  <label style="text-align:center">
        <span id="spanDtime">Departure time :</span>

	<select name="ddate-h" style="width:20%">
<option value="default">Hours (Departure time)</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>

</select>

<script>

$(document).ready( function(){
 var select = document.getElementById("ddate-m");

 for(var i=1; i <= 60; i++)
{
  var option = document.createElement("option");

  if(i<10)
  {
    option.text = "0" + i;
  }
  else
  {
    option.text = i;
  }
  select.add(option);
 }

});


$(document).on("change","#tdate-y", function() {

    $('#tdate-m')
    .find('option')
    .remove()
    .end()
    .append('<option value="default">Select Month</option>');

 for(var i=1; i <= 12; i++)
		{
  			var option = document.createElement("option");

			  if(i<10)
  			 {
    				option.text = "0" + i;
  			}
  			else
  			{
    				option.text = i;
  			}
  			document.getElementById("tdate-m").add(option);
 		}	

    
});

$(document).on("change","#tdate-m" , function()
{
    var dselect = document.getElementById("tdate-d");

    $('#tdate-d')
    .find('option')
    .remove()
    .end();

	var sValue = document.getElementById("tdate-m").selectedIndex;

	if(sValue != 1 && sValue !=2 && sValue != 3 && sValue != 5 && sValue != 7 && sValue != 8 && sValue != 10 && sValue != 12)
	{
		 for(var i=1; i <= 30; i++)
		{
  			var option = document.createElement("option");

			  if(i<10)
  			 {
    				option.text = "0" + i;
  			}
  			else
  			{
    				option.text = i;
  			}
  			dselect.add(option);
 		}	
	}
	else if( sValue == 2)
        {
		if(isleapYear(parseInt(document.getElementById("tdate-y").value)))
		{
		 for(var i=1; i <= 29; i++)
		{
  			var option = document.createElement("option");

			  if(i<10)
  			 {
    				option.text = "0" + i;
  			}
  			else
  			{
    				option.text = i;
  			}
  			dselect.add(option);
 		}
		}
                else
                {
		 for(var i=1; i <= 28; i++)
		{
  			var option = document.createElement("option");

			  if(i<10)
  			 {
    				option.text = "0" + i;
  			}
  			else
  			{
    				option.text = i;
  			}
  			dselect.add(option);
 		}
                 }
         }
	else
         {
		 for(var i=1; i <= 31; i++)
		{
  			var option = document.createElement("option");

			  if(i<10)
  			 {
    				option.text = "0" + i;
  			}
  			else
  			{
    				option.text = i;
  			}
  			dselect.add(option);
 		}
          }
});

function isleapYear(year)
{
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}

</script>

	<select name="ddate-m" id="ddate-m" style="width:20%">
<option value="default">Minutes (Departure Time)</option>
</select>

<select name="ddate-ap" style="width:20%">
<option value="am">AM</option>
<option value="pm">PM</option>
</select>


    </label>  

    <label id="lblEbmi" style="text-align:center">

    </label>
    
      <label id ="lblAtime" style="text-align:center">

    </label>  
    
      <label id="tDate" style="text-align:center">

    </label>  
    
    
    <div id="tblBuses"></div>
    

     <div align="center">
     
     <label>
	 <a onclick="getCurrentLocation();" style="
    background: #960;border: none;padding: 10px 25px 10px 25px;      color: #FFF;box-shadow: 1px 1px 5px #B6B6B6;border-radius: 3px;text-shadow: 1px 1px 1px #9E3F3F;cursor: pointer;font-family:'Courier New', Courier, monospace;
" id="gC" >Start</a></label>
     
	 <input type="submit" class="button"  style="display:none;" id="sB" value="Submit"></label>
     


	
    </div> 
</form>
     </div>
        </div>
<?php 
}

}
else
{
	header("Location: index.php");	
}
?> 