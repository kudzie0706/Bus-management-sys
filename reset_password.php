
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


    if(empty($errors)){

	$tempPass = '';

 for ($i = 0; $i < 7; $i++) {
    $tempPass .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('A'), ord('Z')));
  }

        $query  = "UPDATE users SET ";
        $query .= "password='$tempPass' WHERE name='$name' and email='$email'";

        $edit = $dbc->query($query);

  $email_to = $email;
  $email_from = "Kayliner";

  $email_subject = "Password reset for Kayliner.";
  $email_message = "Your password has been reset! New password:". $tempPass;

$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  

echo 'Your password have been reset and sent through your email. Please change your password at here.';

die();
    }
    else
   {
      echo 'Opss. Something wrong.. Below is the error:<br>';
      echo implode($errors, '<br>');
    }
}
?>
