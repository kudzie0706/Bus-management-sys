<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM bus");

if(!($result->num_rows))
{
   echo '<div align="center"style="padding-top: 30px;">There is no bus right now. ';
echo '</div><br><br>';
}
else
{
echo '<table class="table-fill"  style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th  style="
    text-align: left;
    font-size: 13px;
">Bus no</th><th  style="
    text-align: left;
    font-size: 13px;
">Make</th><th  style="
    text-align: left;
    font-size: 13px;
">Model</th><th  style="
    text-align: left;
    font-size: 13px;
">Status</th><th  style="
    text-align: left;
    font-size: 13px;
">Action</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><span>' . $row["bno"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["make"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["model"] . '</span></td>';
echo '<td class="text-left"><span>' . $row["status"] . '</span></td>';
echo '<td class="text-left">';
if(strpos($_SERVER['HTTP_REFERER'],'edit_bus.php') == true)
{
echo '<a href="#" data-toggle="modal" data-id="' . $row["bno"] . '" 
data-make="' . $row["make"] . '" 
data-model="' . $row["model"] . '" 
data-year="' . $row["year"] . '" 
data-capacity="' . $row["capacity"] . '" 
data-bmi="' . $row["bmileage"] . '" 
data-status="' . $row["status"] . '" 
data-target="#orderModal">Edit</a><a href="/kayliner/edit_bus.php?delete='.$row["bno"].'" style="margin-left:10px;"> Delete</a>';
}
else
{
	echo '<a href="#" data-toggle="modal" 
data-id="' . $row["bno"] . '" 
data-make="' . $row["make"] . '" 
data-model="' . $row["model"] . '" 
data-year="' . $row["year"] . '" 
data-capacity="' . $row["capacity"] . '" 
data-bmi="' . $row["bmileage"] . '"
data-status="' . $row["status"] . '" data-target="#orderModal">View</a>';
}
echo '</td>';
echo '</tr>';
}
echo '</tbody></table><br>';
}
  

mysqli_close($dbc);
?>