
<?php include('core/dbconnect.php');?>
<?php
	
	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['name'])){
        $errors['name'] = 'Please fill in username';//name
    }else{
        $name = mysqli_real_escape_string($dbc,trim($_POST['name']));
    }

    if(empty($_POST['address'])){
        $errors['address'] = 'Please fill in address';
    }else{
        $address = mysqli_real_escape_string($dbc,trim($_POST['address']));
    }

    if(empty($_POST['phone'])){
        $errors['phone'] = 'Please fill in phone';
    }
else if(!(is_numeric($_POST['phone']))){
        $errors['phone'] = 'Phone number should only in numeric format.';
    }
    else
    {
        $phone = mysqli_real_escape_string($dbc,trim($_POST['phone']));
    }
	
	
    if(empty($_POST['sex'])){
        $errors['sex'] = 'Please fill in sex';
    }else{
		
		if( $_POST['sex'] == 'default')
		{
			$errors['sex'] = 'Please select your gender';
		}
		else{	
        $sex = mysqli_real_escape_string($dbc,trim($_POST['sex']));
		}
    }

    if(empty($_POST['email'])){
        $errors['email'] = 'Please fill in email';
    }else{
        $email = mysqli_real_escape_string($dbc,trim($_POST['email']));

        if($check = $dbc->query("SELECT * FROM users WHERE email = '$email'")){
            if($check->num_rows){
                $errors['email'] = 'Email in use';
            }
        }else{
            $errors['email'] = 'the qeury did not work';
        }
    }


    if(empty($_POST['pass1'])){
        $errors['pass1'] = 'Please fill in password';
    }else{
        $pass1 = $_POST['pass1'];
    }

    if(empty($_POST['pass2'])){
        $errors['pass2'] = 'Please verify password';
    }else{
        $pass2 = $_POST['pass2'];

        if($pass1!=$pass2){
            $errors ['pass2'] = 'passwords do not match';
        }else{
            $password = mysqli_real_escape_string($dbc,trim($_POST['pass1']));
           // $password = sha1($password);
        }
    }
    if(empty($errors)){
        $query  = "INSERT INTO users ";
        $query .= "(name,address,phone,sex,email,password,usertype,nid) ";
        $query .= "VALUES ('$name','$address','$phone','$sex','$email','$password','4','-1')";

        $register = $dbc->query($query);

            
			header("Location: index.php");
die();
    }
    else
   {
      echo 'Opss. Something wrong.. Below is the error:<br>';
      echo implode($errors, '<br>');
    }
}
?>
