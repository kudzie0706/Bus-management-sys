<?php

include('core/dbconnect.php');


	if ($_SERVER['REQUEST_METHOD']=='GET'){


	$name = $_GET['n'];
	$email = $_GET['e'];

        $query  = "SELECT * FROM users WHERE email='$email'";

        $check = $dbc->query($query);
	$got = false;



if($check->num_rows)
{
	while($row = $check->fetch_array(MYSQLI_ASSOC)) {

		if($row['name'] == $name)
		{
			echo 'Found';
			$got = true;
			break;
		}	
		else
		{
			$got = false;
		}


	}

	if($got == false)
	{

			echo 'Information is incorrect!';
	}
			
}
else
{
	echo 'Email does not exist!';
}



	}
?>