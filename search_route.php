<?php

include('core/dbconnect.php');

$departure = $_GET["d_s"];
$destination = $_GET["a_s"];

$result= $dbc->query("SELECT * FROM route WHERE d_station = '$departure' AND a_station = '$destination'");

if(!($result->num_rows))
{
   echo '<span>There is no route from '.$departure . ' to '.$destination .'.</span>';
}
else
{
echo "<span style=\"color:green;\">". $result->num_rows . " found(s)<span>";
echo '<table>';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

$bno = $row['bno'];
$status = $dbc->query("SELECT status FROM bus WHERE bno = '$bno'")->fetch_object()->status;

if($status == "Ready")
{
	$status = "<span style=\"color:green;font-family:segoe ui;\">Stand by<span>";
}
else
{
	$status = "<span style=\"color:red;font-family:segoe ui;\">Going<span>";
}

echo '<tr>';
echo '<td style="font-family:segoe ui;">#'.$row["rid"].'</td>';
echo '<td style="font-family:segoe ui;">'.$row["d_station"].'<img src="images/arrows.gif" style="
    height: 56%;padding-left:10px;padding-right:10px;;
">'.$row["a_station"].'</td>';
echo '<td>'.$status.'</td>';
echo '</tr>';
}
echo '</table><br>';

  }

mysqli_close($dbc);
?>