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
">Route ID</th><th style="
    text-align: left;
    font-size: 13px;
">Bus Number</th><th style="
    text-align: left;
    font-size: 13px;
">Departure Time</th><th style="
    text-align: left;
    font-size: 13px;
">Arrival Time</th><th colspan="3" style="
    text-align: left;
    font-size: 13px;
">Route (Departure to Destination)</th>
<th colspan="3" style="
    text-align: left;
    font-size: 13px;
">Status</th>
</tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

$bno = $row["bno"];

$status = $dbc->query("SELECT status FROM bus WHERE bno = '$bno'")->fetch_object()->status;

if($status == "Ready")
{
	$status = "images/waiting.gif";
}
else
{
	$status = "images/going.gif";
}

echo '<tr>';
echo '<td class="text-left"><span>' . $row["rid"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["bno"] . '</span></td>';

$dtime = strtotime($row["d_time"]);
$newd = date('H:i A', $dtime);

echo '<td class="text-left"><span>' . $newd . '</span></td>';

$atime = strtotime($row["a_time"]);
$newa = date('H:i A', $atime);

echo '<td class="text-left"><span>' . $newa . '</span></td>';
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
echo '<td class="text-left" style="
    border-right: none;
"><img src="'.$status.'" style="
    height: 56%;
"></td>';

echo '</tr>';
}
echo '</tbody></table><br>';


  }

mysqli_close($dbc);
?>