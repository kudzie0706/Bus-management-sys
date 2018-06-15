<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM drivers");

if(!($result->num_rows))
{
   echo '<div align="center" style="padding-top: 30px;">There is no driver right now. ';

echo '</div><br><br>';
}
else
{
echo '<table class="table-fill"><thead><tr><th class="text-left">ID</th><th class="text-left">Name</th><th class="text-left">Email</th></tr></thead>
<tbody class="table-hover">';
while($row = $result->fetch_array(MYSQLI_ASSOC)) {

$user_id=$row["user_id"];
$name = $dbc->query("SELECT name FROM users WHERE user_id = '$user_id'")->fetch_object()->name;
$email = $dbc->query("SELECT email FROM users WHERE user_id = '$user_id'")->fetch_object()->email;

echo '<tr>';
echo '<td class="text-left"><a href="#"  onclick="setDriver(\''.$row["d_id"].'\');">' . $row["d_id"] . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setDriver(\''.$row["d_id"].'\');">' . $name . '</a></td>';
echo '<td class="text-left"><a href="#" onclick="setDriver(\''.$row["d_id"].'\');">' . $email . '</a></td>';
echo '</tr>';
}
echo '</tbody></table><br>';

  }

mysqli_close($dbc);
?>