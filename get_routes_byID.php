<?php

include('core/dbconnect.php');

$bno = $_GET['id'];

$result= $dbc->query("SELECT * FROM route where bno ='$bno'");


if($result->num_rows)
{
echo '<table class="table-fill"><thead><tr><th class="text-left" style="
    font-size: 17px;
">Route ID</th><th class="text-left" style="
    font-size: 17px;
">Bus NO</th><th class="text-left" style="
    font-size: 17px;
">Driver ID</th><th class="text-left" style="
    font-size: 17px;
">From</th><th class="text-left" style="
    font-size: 17px;
">To</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

if(strpos($_SERVER['HTTP_REFERER'],'home.php') == false)
{
echo '<tr>';
echo '<td class="text-left" style="
    font-size: 12px;
"><a href="#" >' . $row["rid"] . '</a></td>';
echo '<td class="text-left"><span>' . $row["bno"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["d_id"] . '</span></td>';
echo '<td class="text-left"><span >' . $row["d_station"] . '</span></td>';
echo '<td class="text-left"><span >' . $row["a_station"] . '</span></td>';
echo '</tr>';
}
else
{
	echo '<tr>';
echo '<td class="text-left" style="
    font-size: 12px;
"><a href="#" onclick=setRoute("'. $row["rid"].'")>' . $row["rid"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick=setRoute("'. $row["rid"].'")>' . $row["bno"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick=setRoute("'. $row["rid"].'")>' . $row["d_id"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick=setRoute("'. $row["rid"].'")>' . $row["d_station"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick=setRoute("'. $row["rid"].'")>' . $row["a_station"] . '</a></td>';
echo '</tr>';

}
}
echo '</tbody></table><br>';

}
else
{
	echo '<div align="center">There is not route in this bus.</div><br>';	
}
mysqli_close($dbc);
?>