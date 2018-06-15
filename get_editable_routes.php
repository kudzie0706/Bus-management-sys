<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM route");

if(!($result->num_rows))
{
   echo '<div align="center" style="padding-top: 30px;">There is no route right now. ';

echo '</div><br><br>';
}
else
{


echo '<table class="table-fill" style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th style="
    text-align: left;
    font-size: 13px;
">ID</th><th style="
    text-align: left;
    font-size: 13px;
">Bus Number</th><th colspan="3" style="
    text-align: left;
    font-size: 13px;
">Route (Departure to Destination)</th>
<th style="
    text-align: left;
    font-size: 13px;
">Action</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {


$dtime = strtotime($row["d_time"]);
$newd = date('H:i A', $dtime);

$atime = strtotime($row["a_time"]);
$newa = date('H:i A', $atime);


echo '<tr>';
echo '<td class="text-left"><span>' . $row["rid"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["bno"] . '</span></td>';
echo '<td style="
    border-right: none;
    text-align: center;
"><span>' . $row["d_station"] . '</span></td>';
echo '<td class="text-left" style="
    border-right: none;
"><img src="images/arrows.gif" style="
    height: 56%;
"></td>';
echo '<td style="
    text-align: center;
"><span>' . $row["a_station"] . '</span></td>';
echo '<td class="text-left">';
if(strpos($_SERVER['HTTP_REFERER'],'edit_route.php') == true)
{
echo '<a href="#" data-toggle="modal" data-id="' . $row["rid"] . '" data-d_id="' . $row["d_id"] . '" data-bno="' . $row["bno"] . '" data-d_station="' . $row["d_station"] . '" data-a_station="' . $row["a_station"] . '" data-distance="' . $row["distance_km"] . '" data-d_time="' . $row["d_time"] . '" 
data-a_time="' . $row["a_time"] . '"  data-target="#orderModal">Edit</a><a href="/kayliner/edit_route.php?delete='.$row["rid"].'" style="margin-left:10px;"> Delete</a>';
}
else
{
	echo '<a href="#" data-toggle="modal" 
	
data-id="' . $row["rid"] . '" 
data-d_id="' . $row["d_id"] . '" 
data-bno="' . $row["bno"] . '" 
data-d_station="' . $row["d_station"] . '" 
data-a_station="' . $row["a_station"] . '" 
data-distance="' . $row["distance_km"] . '"
data-d_time="' . $newd . '" 
data-a_time="' . $newa . '" 
data-target="#orderModal">View</a>';
}

echo '</td>';
echo '</tr>';
}
echo '</tbody></table><br>';


  }

mysqli_close($dbc);
?>