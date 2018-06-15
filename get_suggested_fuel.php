<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT * FROM fuel_allocation_formula");

if(($result->num_rows))
{

while($row = $result->fetch_array(MYSQLI_ASSOC)) {

$rid = $_GET["id"];

$distance = $dbc->query("SELECT distance_km FROM route WHERE rid='$rid'")->fetch_object()->distance_km;

$fuel_per_1km = $row["km"] / $row["liter"];
$fuel = $distance * $fuel_per_1km;

echo $fuel;
}

}
mysqli_close($dbc);
?>