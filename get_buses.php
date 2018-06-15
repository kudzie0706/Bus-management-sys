<?php

include('core/dbconnect.php');

if(strpos($_SERVER['HTTP_REFERER'],'locate.php') == true)
{
	$result= $dbc->query("SELECT * FROM bus where status='Outgoing'");
}
else
{
$result= $dbc->query("SELECT * FROM bus");
}

if(!($result->num_rows))
{
	if(strpos($_SERVER['HTTP_REFERER'],'locate.php') == true)
{
	echo '<div align="center" style="padding-top: 30px;">There is no bus outgoing right now. ';
}
else
{
   echo '<div align="center" style="padding-top: 30px;">There is no bus right now. ';

}

echo '</div><br><br>';
}
else
{

	if(strpos($_SERVER['HTTP_REFERER'],'home.php') == true)
{
echo '<table class="table-fill"><thead><tr><th class="text-left">Bus no</th><th class="text-left">Make</th><th class="text-left">Model</th><th class="text-left">Mileage</th></tr></thead>
<tbody class="table-hover">';
}
else
{
echo '<table class="table-fill"><thead><tr><th class="text-left">Bus no</th><th class="text-left">Make</th><th class="text-left">Model</th><th class="text-left">Mileage</th><th class="text-left">Status</th></tr></thead>
<tbody class="table-hover">';
}

while($row = $result->fetch_array(MYSQLI_ASSOC)) {


	if(strpos($_SERVER['HTTP_REFERER'],'home.php') == true)
{
echo '<tr>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["bno"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["make"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["model"] . '</a></td>';
echo '<td class="text-left"><a href="#" id="'.$row["bno"].'+bmileage" onclick="setBus(\''.$row["bno"].'\');">' . $row["bmileage"] . '</a></td>';
echo '</tr>';
}
else
{
echo '<tr>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["bno"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["make"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["model"] . '</a></td>';
echo '<td class="text-left"><a href="#" id="'.$row["bno"].'+bmileage" onclick="setBus(\''.$row["bno"].'\');">' . $row["bmileage"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setBus(\''.$row["bno"].'\');">' . $row["status"] . '</a></td>';
echo '</tr>';
}


}
echo '</tbody></table><br>';
}
  

mysqli_close($dbc);
?>