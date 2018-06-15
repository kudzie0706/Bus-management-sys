<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM trip");

if(!($result->num_rows))
{
   echo '<div align="center"style="padding-top: 30px;">There is no trip record right now. ';
echo '</div><br><br>';
}
else
{
echo '<table class="table-fill" style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th class="text-left">Bus no</th><th class="text-left">Route Id</th><th class="text-left">Start mileage</th><th class="text-left">End mileage</th><th class="text-left">Action</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><span>' . $row["bno"] .  '</span></td>';
echo '<td class="text-left"><span>' . $row["rid"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["s_mileage"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["e_mileage"] . '</span></td>';
echo '<td class="text-left">';
echo '<a href="#" data-toggle="modal" 

data-id="' . $row["tid"] . '" 
data-bno="' . $row["bno"] . '" 
data-rid="' . $row["rid"] . '" 
data-s_mileage="' . $row["s_mileage"] . '" 
data-dtime="' . $row["dtime"] . '" 
data-e_mileage="' . $row["e_mileage"] . '" 
data-atime="' . $row["atime"] . '" 
data-date="' . $row["date"] . '"
data-d_id="' . $row["d_id"] . '"


data-target="#orderModal">View</a>';

echo '</td></tr>';
}
echo '</tbody></table><br>';
}
  

mysqli_close($dbc);
?>