<?php $title = 'Edit Driver'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 1){
	include('includes/admin-menu.html');

if (isset($_REQUEST['delete'])) {
$dbc->query("DELETE FROM nextofkin WHERE user_id={$_REQUEST['delete']}");
$dbc->query("DELETE FROM drivers WHERE user_id={$_REQUEST['delete']}");
$dbc->query("DELETE FROM users WHERE user_id={$_REQUEST['delete']}");

}

	
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
	$uid  = $_POST['user_id'];

        if($check = $dbc->query("SELECT * FROM users WHERE email = '$email' and user_id != '$uid'")){
            if($check->num_rows){
                $errors['email'] = 'Email in use';
            }
        }else{
            $errors['email'] = 'the qeury did not work';
        }
    }



    if(empty($_POST['pass2']) && empty($_POST['pass1'])){
$userid = mysqli_real_escape_string($dbc,trim($_POST['user_id']));
        $password = $dbc->query("SELECT password FROM users WHERE user_id = '$userid'")->fetch_object()->password;
    }else if((strlen($_POST['pass1']) < 4) || (strlen($_POST['pass1']) > 10)){
	$errors['pass1'] = 'The password should more than 5 characters and less than 10 characters. (Next of kin)';
    }else{
        $pass2 = $_POST['pass2'];
        $pass1 = $_POST['pass1'];

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

$did = mysqli_real_escape_string($dbc,trim($_POST['d_id']));
$userid = mysqli_real_escape_string($dbc,trim($_POST['user_id']));

        $query  = "UPDATE users ";
        $query .= "SET name='$name',address='$address',phone='$phone',sex='$sex',email='$email',password='$password' WHERE user_id='$userid' ";

        $add = $dbc->query($query);

        $query1  = "UPDATE drivers ";
        $query1 .= "SET salary='$salary',hireddate='$hireddate' WHERE user_id='$userid' ";

$add1 = $dbc->query($query1);

        $query2  = "UPDATE nextofkin ";
        $query2 .= "SET name='$nextname',address='$nextaddress',sex='$nextsex',phone='$nextphone' WHERE user_id='$userid' ";

$add2 = $dbc->query($query2);

        if($add && $add1 && $add2){
            $message = "Driver ID: ". $did . " edited successfully.";
        }else{
            echo $query . '<br>';
echo $query1 . '<br>';
echo $query2 . '<br>';
        }
    }
}
?>

<div style="
    
    margin-top: 10px;
    font-size: 15px;
"><?php if ($_SERVER['REQUEST_METHOD']=='POST'){ if($errors) {echo '<span style="color: red;">Unable to save edited driver:</span><br><br><span>'.implode("<br>",$errors) . '</span>';}else { echo '<span style="color:red;">'.$message .'</span>';} } ?></div>

<div id="content">
<script type="text/javascript" src="includes/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="includes/bootstrap-combined.min.css" />


<script>
 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("tblDrivers").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","get_editable_drivers.php",true);
  xmlhttp.send();

$(function(){
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show:false,
        
    }).on('show', function(){ //subscribe to show method
          var getIdFromRow = $(event.target).closest('a').data('d_id'); //get the id from tr
        //make your ajax call populate items or what even you need
$("#boxtitle").text('Driver ID: '+ getIdFromRow);
$("#name").val($(event.target).closest('a').data('name'));
$("#address").val($(event.target).closest('a').data('address'));
$("#phone").val($(event.target).closest('a').data('phone'));
$("#sex").val($(event.target).closest('a').data('sex'));
$("#email").val($(event.target).closest('a').data('email'));
$("#salary").val($(event.target).closest('a').data('salary'));
$("#hireddate").val($(event.target).closest('a').data('hireddate'));
$("#nextname").val($(event.target).closest('a').data('nextname'));
$("#nextaddress").val($(event.target).closest('a').data('nextaddress'));
$("#nextsex").val($(event.target).closest('a').data('nextsex'));
$("#nextphone").val($(event.target).closest('a').data('nextphone'));
$("#d_id").val($(event.target).closest('a').data('d_id'));
$("#user_id").val($(event.target).closest('a').data('id'));
    });
});


</script>

<div id="tblDrivers"></div>

<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3 id="boxtitle"></h3>

    </div>
    <div id="orderDetails" class="modal-body" style="padding:0px;max-height:500px;">

<form action="edit_driver.php" method="post" class="basic-grey">
<div style="
    text-align: center;
    margin-bottom: 10px;
margin-top: -16px;
"><span">--------------Driver Information--------------</span></div>
<input id="d_id" type="hidden" name="d_id" >
<input id="user_id" type="hidden" name="user_id" >
    <label>
        <span>Name :</span>
        <input id="name" type="text" name="name" placeholder="Full Name">
    </label>
    
    <label>
        <span>Address :</span>
        <input id="address" type="text" name="address" placeholder="Valid Address">
    </label>
    
    <label>
        <span>Phone :</span>
        <input id="phone" name="phone" placeholder="Current Number" type="text">
    </label> 
     <label>
        <span>Sex :</span><select name="sex" id="sex">
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
        <input id="pass1" type="password" name="pass1" placeholder="Leave empty if you are not changing password">
    </label><label>
        <span>Password :</span>
        <input id="pass2" type="password" name="pass2" placeholder="Leave empty if you are not changing password">
    </label>    
    <label>
        <span>Salary :</span>
        <input id="salary" type="text" name="salary" placeholder="Salary">
    </label>
    <label>
        <span>Hired Date :</span>
        <input type="date" id="hireddate"  value="yyyy-mm-dd" name="hireddate" onkeypress="return false">
    </label>    
<div style="
    text-align: center;
    margin-bottom: 10px;
"><span">--------------Next of Kin--------------</span></div>
    <label>
        <span>Name :</span>
        <input type="text" name="nextname" id="nextname" placeholder="Full name">
    </label> 
    <label>
        <span>Address :</span>
        <input type="text" name="nextaddress" id="nextaddress" placeholder="Valid Address">
    </label>  
     <label>
        <span>Sex :</span><select name="nextsex" id="nextsex">
                <option value="default">--Choose the gender--</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
    </label>
    <label>
        <span>Phone :</span>
        <input type="text" name="nextphone" id="nextphone" placeholder="Must be valid">
    </label>   
   <div class="modal-footer" style="
    margin-bottom: -26px;
">
     <label>
        <span>&nbsp;</span> 
        <input type="submit" class="button" value="Save"> 
<button class="button" data-dismiss="modal" aria-hidden="true">Close</button>
    </label> 
        
    </div>
</form>
</div>


</div>


</div>
<?php include('sidebar.php'); ?>
<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>