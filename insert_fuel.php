<?php

include('core/dbconnect.php');

$amount= $_POST['amount']; //The data that is passed from tha ajax function

$current = $dbc->query("SELECT current FROM fuel_tank ORDER BY date DESC LIMIT 1")->fetch_object()->current;
$max = $dbc->query("SELECT max FROM fuel_tank ORDER BY date DESC LIMIT 1")->fetch_object()->max;

$new = $amount+$current;

$left = $max - $current;

if($new > $max)
{

echo 'Max fuel : '. $max .' / Fuel space left : ' . $left;
}
else
{
$query =  "INSERT INTO fuel_tank (current,max) VALUES ($new,$max)";

$insert = $dbc->query($query);

if($insert)
{
 $percent = ($new / $max) * 100;
echo $percent;
}
else
{
 echo 'Something wrong when adding fuel.';
}
}
?>