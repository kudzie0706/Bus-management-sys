<?php

include('core/dbconnect.php');

if(strpos($_SERVER['HTTP_REFERER'],'report_fuel_tank.php') == true)
{
$result= $dbc->query("SELECT * FROM fuel_tank ORDER BY date");
}
else
{
$result= $dbc->query("SELECT * FROM fuel_tank ORDER BY date DESC LIMIT 1");
}

echo '<table class="table-fill"  style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th  style="
    text-align: left;
    font-size: 13px;
">Time</th>';
if(strpos($_SERVER['HTTP_REFERER'],'edit_fuel.php') == true)
{

echo '<th  style="
    text-align: left;
    font-size: 13px;
">Current</th>';
}
else
{
echo '<th  style="
    text-align: left;
    font-size: 13px;
">Fuel</th>';
}
echo '<th  style="
    text-align: left;
    font-size: 13px;
">Capacity</th>';

if(strpos($_SERVER['HTTP_REFERER'],'edit_fuel.php') == true)
{

echo '<th  style="
    text-align: left;
    font-size: 13px;
">Action</th>';
}
echo '</tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><span>' . $row["date"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["current"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["max"] . '</span></td>';



if(strpos($_SERVER['HTTP_REFERER'],'edit_fuel.php') == true)
{
echo '<td class="text-left">';
echo '<a href="#" data-toggle="modal" 
data-date="' . $row["date"] . '" 
data-current="' . $row["current"] . '" 
data-max="' . $row["max"] . '"
data-target="#orderModal">Edit</a>';
echo '</td>';
}

echo '</tr>';
}
echo '</tbody></table><br>';
  

mysqli_close($dbc);
?>