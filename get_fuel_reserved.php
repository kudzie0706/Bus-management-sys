<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM fuel");

if(!($result->num_rows))
{
   echo '<div align="center">There is no fuel record right now. ';

echo '</div><br><br>';
}
else
{
echo '<table class="table-fill" style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th class="text-left">Bus no</th><th class="text-left">Route id</th><th class="text-left">Fuel Allocated</th><th class="text-left">Time</th><th class="text-left">Action</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><span>' . $row["bno"] .  '</span></td>';
echo '<td class="text-left"><span>' . $row["rid"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["Fuel_allocated"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["Date"] . '</span></td>';
echo '<td class="text-left">';
echo '<a href="#" data-toggle="modal" 

data-id="' . $row["f_id"] . '" 
data-bno="' . $row["bno"] . '" 
data-rid="' . $row["rid"] . '" 
data-fuel_allocated="' . $row["Fuel_allocated"] . '" 
data-date="' . $row["Date"] . '" 
data-fuel_reserve="' . $row["Fuel_Reserve"] . '" 

data-target="#orderModal">View</a>';

echo '</td></tr>';
}
echo '</tbody></table><br>';
}
  

mysqli_close($dbc);
?>