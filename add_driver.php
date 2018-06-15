<?php $title = 'Add Driver'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

	
	if ($_SERVER['REQUEST_METHOD']=='POST'){

    $errors = array();
    if(empty($_POST['name'])){
        $errors['name'] = 'Please fill in driver name';//name
    }else if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['name'])){
	$errors['name'] = 'The name should contains only letters and spaces';
    }else{
        $name = mysqli_real_escape_string($dbc,trim($_POST['name']));
    }

    if(empty($_POST['address'])){
        $errors['address'] = 'Please fill in address';
    }else if((!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9\_\-\s\,\.]+)$/', $_POST['address'])) || (preg_match('/[\(\)\<\>\;\:\\\"\[\]]/', $_POST['address']))){
	$errors['address'] = 'Address should contains a character and a number. Only - _ . , and space are allowed.';
    }else{
        $address = mysqli_real_escape_string($dbc,trim($_POST['address']));
    }

   $stripped = preg_replace('/[\(\)\.\-\ ]/', '', $_POST['phone']);

    if(empty($_POST['phone'])){
        $errors['phone'] = 'Please fill in phone';
    }else if(!(strlen($stripped) == 10) || !is_numeric($stripped)){
	$errors['phone'] = 'The phone number should have 10 digits.';
    }else{
        $phone = mysqli_real_escape_string($dbc,trim($_POST['phone']));
    }

    if(empty($_POST['salary'])){
        $errors['salary'] = 'Please fill in salary';
    }else if(!(preg_match('/^[\d]+$/', $_POST['salary']))){
	$errors['salary'] = 'Salary should contains only numbers.';
    }else{
        $salary = mysqli_real_escape_string($dbc,trim($_POST['salary']));
    }
	
	    if(empty($_POST['hireddate'])){
        $errors['hireddate'] = 'Please pick a date';
    }else{
        $hireddate = mysqli_real_escape_string($dbc,trim($_POST['hireddate']));
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
    }else if(!(preg_match('/^[^@]+@[^@.]+\.[^@]*\w\w$/', $_POST['email'])) || (preg_match('/[\(\)\<\>\,\;\:\\\"\[\]]/', $_POST['email']))){
	$errors['email'] = 'Email is not valid.';
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
    }else if((strlen($_POST['pass1']) < 4) || (strlen($_POST['pass1']) > 10)){
	$errors['pass1'] = 'The password should more than 5 characters and less than 10 characters. (Next of kin)';
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
        }
    }

    if(empty($_POST['nextname'])){
        $errors['nextname'] = 'Please fill in name (Next of kin)';//name
    }else if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['nextname'])){
	$errors['nextname'] = 'The name should contains only letters and spaces (Next of kin)';
    }else{
        $nextname = mysqli_real_escape_string($dbc,trim($_POST['nextname']));
    }

    if(empty($_POST['nextaddress'])){
        $errors['nextaddress'] = 'Please fill in address (Next of kin)';
    }else if((!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9\_\-\s\,\.]+)$/', $_POST['nextaddress'])) || (preg_match('/[\(\)\<\>\;\:\\\"\[\]]/', $_POST['nextaddress']))){
	$errors['nextaddress'] = 'Address should contains a character and a number. Only - _ . , and space are allowed. (Next of kin).';
    }else{
        $nextaddress = mysqli_real_escape_string($dbc,trim($_POST['nextaddress']));
    }

    if(empty($_POST['nextsex'])){
        $errors['nextsex'] = 'Please fill in sex (Next of kin)';
    }else{
		
		if( $_POST['nextsex'] == 'default')
		{
			$errors['nextsex'] = 'Please select the gender (Next of kin)';
		}
		else{	
        $nextsex = mysqli_real_escape_string($dbc,trim($_POST['nextsex']));
		}
    }
  $stripped_next = preg_replace('/[\(\)\.\-\ ]/', '', $_POST['nextphone']);
    if(empty($_POST['nextphone'])){
        $errors['nextphone'] = 'Please fill in phone (Next of kin)';
    }else if(!(strlen($stripped_next) == 10) || !is_numeric($stripped_next)){
	$errors['nextphone'] = 'The phone number should have 10 digits. (Next of kin)';
    }else{
        $nextphone = mysqli_real_escape_string($dbc,trim($_POST['nextphone']));
    }

    if(empty($errors)){
        $query  = "INSERT INTO users ";
        $query .= "(name,address,phone,sex,email,password,usertype) ";
        $query .= "VALUES ('$name','$address','$phone','$sex','$email','$password','3')";

$insertuser = $dbc->query($query);        

$user_id = $dbc->query("SELECT user_id FROM users WHERE email = '$email'")->fetch_object()->user_id;

do {  
  $driver_id = '';
  for ($i = 0; $i < 6; $i++) {
    $driver_id .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('A'), ord('Z')));
  }
 if($check = $dbc->query("SELECT d_id FROM drivers WHERE d_id = '$driver_id'")){
            if($check->num_rows){
                $exist = true;
            }
            else
           {
              $exist = false;
            }
        }
} while ($exist);

$query2 =  "INSERT INTO drivers (d_id,user_id,salary,hireddate) VALUES ('$driver_id','$user_id','$salary','$hireddate')";

$insertdriver = $dbc->query($query2);

$query3 =  "INSERT INTO nextofkin (user_id,name,address,sex,phone) VALUES ('$user_id','$nextname','$nextaddress','$nextsex','$nextphone')";

$insertnext = $dbc->query($query3);

$nid = $dbc->query("SELECT nid FROM nextofkin WHERE user_id = '$user_id'")->fetch_object()->nid;


$query4 = "UPDATE users SET nid='$nid' WHERE user_id = '$user_id'";

$updatenid = $dbc->query($query4);

        if($insertuser && $insertdriver && $insertnext && $updatenid){
            $message = $name . " has been added to bus drivers.";
        }else{
            echo $query . '<br>';
echo $query2 . '<br>';
echo $query3 . '<br>';
        }
    }
}
?>

<div id="content">
<form action="add_driver.php" method="post" class="basic-grey">
    <h1>Add Bus Driver<?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if(empty($errors)){ echo '<span style="color:red;">'.$message; }else { echo '<span style="color:red">Opps.. something wrong!</span><span>'.implode("<br>",$errors);}} else { echo '<span>Please fill all the texts in the fields.'; } ?></span>
    </h1>
<div style="
    text-align: center;
    margin-bottom: 10px;
margin-top: -16px;
"><span">--------------Driver Information--------------</span></div>
    <label>
        <span>Driver Name :</span>
        <input id="name" type="text" name="name" placeholder="Full Name">
    </label>
    
    <label>
        <span>Address :</span>
        <input id="address" type="text" name="address" placeholder="Valid Address">
    </label>
    
    <label>
        <span>Phone Number :</span>
        <input id="phone" name="phone" placeholder="Current Number" type="text">
    </label> 
     <label>
        <span>Sex :</span><select name="sex">
                <option value="default">--Choose your gender--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
    </label>
<label>
        <span>Email :</span>
        <input id="email" type="email" name="email" placeholder="example@email.com">
    </label>

<label>
        <span>Password :</span>
        <input id="pass1" type="password" name="pass1" placeholder="Password">
    </label><label>
        <span>Password :</span>
        <input id="pass2" type="password" name="pass2" placeholder="Confirm Password">
    </label>    
    <label>
        <span>Salary :</span>
        <input id="salary" type="text" name="salary" placeholder="Salary">
    </label>
    <label>
        <span>Hired Date :</span>
        <input type="date"   value="yyyy-mm-dd" name="hireddate" onkeypress="return false">
    </label>    
<div style="
    text-align: center;
    margin-bottom: 10px;
"><span">--------------Next of Kin--------------</span></div>
    <label>
        <span>Contact Name :</span>
        <input type="text" name="nextname" placeholder="Full name">
    </label> 
    <label>
        <span>Address :</span>
        <input type="text" name="nextaddress" placeholder="Valid Address">
    </label>  
     <label>
        <span>Sex :</span><select name="nextsex">
                <option value="default">--Choose the gender--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
    </label> 
    <label>
        <span>Contact Phone :</span>
        <input type="text" name="nextphone" placeholder="Must be valid">
    </label>   
     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Register"> 
    </label>    
</form>
</div>
<?php include('sidebar.php'); ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>