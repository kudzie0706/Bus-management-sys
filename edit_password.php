
<?php include('core/dbconnect.php');?>
<?php
	
	if ($_SERVER['REQUEST_METHOD']=='POST'){


   if(empty($_POST['name'])){
        $errors['name'] = 'Please fill in username';//name
    }else{
        $name = mysqli_real_escape_string($dbc,trim($_POST['name']));
    }


 if(empty($_POST['email'])){
        $errors['email'] = 'Please fill in email';
    }else{
        $email = mysqli_real_escape_string($dbc,trim($_POST['email']));
    }

 if(empty($_POST['o'])){
        $errors['oldpass'] = 'Please fill in old password';
    }else{
        $oldpass = mysqli_real_escape_string($dbc,trim($_POST['o']));
    }
 if(empty($_POST['p'])){
        $errors['pass1'] = 'Please fill in password';
    }else{
        $pass = mysqli_real_escape_string($dbc,trim($_POST['p']));
    }



    if(empty($errors)){

$check = $dbc->query("SELECT * from users where name='$name' and email='$email' and password='$oldpass'");

if(!($check->num_rows))
{
	echo 'Information is wrong!';	
}
else
{

       $query  = "UPDATE users SET ";
       $query .= "password='$pass' WHERE name='$name' and email='$email'";

        $edit = $dbc->query($query);

echo 'Password reset successfully, redirecting in 3 seconds..';
}

    }
    else
   {
      echo 'Opss. Something wrong.. Below is the error:<br>';
      echo implode($errors, '<br>');
    }
}
?>
