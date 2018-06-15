<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM maintanance");

if(!($result->num_rows))
{
   echo '<div align="center" style="padding-top: 30px;">There is no bus maintenance record right now. ';

echo '</div><br><br>';
}
else
{
echo '<table class="table-fill" style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th class="text-left">Bus no</th><th class="text-left">Previous service</th><th class="text-left">Newest Service</th><th class="text-left">Next mileage</th><th class="text-left">Action</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><span>' . $row["bno"] .  '</span></td>';
echo '<td class="text-left"><span>' . $row["ls_Date"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["servicedate"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["n_service"] . '</span></td>';
echo '<td class="text-left">';
echo '<a href="#" data-toggle="modal" 

data-id="' . $row["main_id"] . '" 
data-bno="' . $row["bno"] . '" 
data-l_service="' . $row["l_service"] . '" 
data-ls_date="' . $row["ls_Date"] . '" 
data-s_description="' . $row["s_description"] . '" 
data-servicedate="' . $row["servicedate"] . '" 
data-n_service="' . $row["n_service"] . '"


data-target="#orderModal">View</a>';

echo '</td></tr>';
}
echo '</tbody></table><br>';
}
  

mysqli_close($dbc);
?>