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
echo '</span><br><br>';
echo '<table class="table-fill"><thead><tr><th class="text-left">Route Id</th><th class="text-left">Bus No</th><th class="text-left">Driver Id</th><th class="text-left">From</th><th class="text-left">To</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

echo '<tr>';
echo '<td class="text-left"><a href="#" onclick="setRoute(\''.$row["rid"].'\');">' . $row["rid"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setRoute(\''.$row["rid"].'\');">' . $row["bno"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setRoute(\''.$row["rid"].'\');">' . $row["d_id"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setRoute(\''.$row["rid"].'\');">' . $row["d_station"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setRoute(\''.$row["rid"].'\');">' . $row["a_station"] . '</a></td>';
echo '</tr>';
}
echo '</tbody></table><br>';
}
mysqli_close($dbc);
?>