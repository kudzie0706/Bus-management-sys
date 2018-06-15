<?php $title = "Login"; ?>
<?php include('includes/header.html'); ?>
<?php
	if(isset($_SESSION['user_id'])){
		header("location: home.php");
	}

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$errors = array();

		if(empty($_POST['email'])){
			$errors['email'] = 'please enter email';
		}else{
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
		}

		if(empty($_POST['pass'])){
			$errors['pass'] = 'Please enter password';
		}else{
			$pass = $_POST['pass'];
			//$pass = sha1($pass);
		}

		if (empty($errors)) {
			$query = "SELECT * FROM users WHERE email = '$email' AND password = '$pass' LIMIT 1";

			if($check = $dbc->query($query)){
				$count = $check->num_rows;
				if($count == 1){
					$_SESSION['pass'] = $pass;

					$query = "SELECT * FROM users WHERE email ='$email' LIMIT 1";
					if($result = $dbc->query($query)){
						$row = $result->fetch_object();

						$_SESSION['user_id'] = $row->user_id;
						$_SESSION['name'] = $row->name;
						$_SESSION['type']= $row->usertype;
						$_SESSION['email'] = $row->email;
						header("location: home.php");
					}
				}else{
					$message = 'the information you have entered is incorrect';
				}
			}else{
				echo 'the query didn\'t work';
			}
		}
	}
?>

<script>

function showRegister()
{
	document.getElementById("login").style.display = "none";
	document.getElementById("register").style.display = "block";	


document.getElementById("spanDiv").style.paddingLeft = "15px";
document.getElementById("spanDiv").style.background = "white";
document.getElementById("searchRoute").style.paddingTop = "15px";

}

function showReset()
{
	document.getElementById("login").style.display = "none";	
	document.getElementById("reset").style.display = "block";

document.getElementById("spanDiv").style.paddingLeft = "15px";
document.getElementById("spanDiv").style.background = "white";
document.getElementById("searchRoute").style.paddingTop = "15px";

}


function validatePassForm(){

document.getElementById("spanStatus").innerHTML = '';

	var oldpass = document.getElementById("eoldpass").value;
	var pass1 = document.getElementById("epass1").value;
	var pass2 = document.getElementById("epass2").value;

	document.getElementById("ename").value = document.getElementById("nameR").value;
	document.getElementById("eemail").value = document.getElementById("emailR").value;

	
		  var name = document.getElementById("ename").value;
var email = document.getElementById("eemail").value;


var isNull = false;
	var errorMsg = 'Opss.. Something wrong!';

	
    if (name==null || name=="") {
        errorMsg += "<br>Please enter the name.";
        isNull = true;
    }
		    if (email==null || email=="") {
        errorMsg += "<br>Please enter the email.";
        isNull = true;
    }

	    if (oldpass==null || oldpass=="") {
        errorMsg += "<br>Please enter the old password.";
        isNull = true;
    }

	    if (pass1==null || pass1=="") {
        errorMsg += "<br>Please enter the new password.";
        isNull = true;
    }
	    if (pass2==null || pass2=="") {
        errorMsg += "<br>Please enter the confirmation password.";
        isNull = true;
    }
	
		if ( (oldpass !=null && oldpass != "" )&&(pass1 != null && pass1 !="" ) &&(pass2 != null && pass2 !="")) {
		
		if(pass1 != pass2)
		{
			errorMsg += "<br>Confirmed password not match.";
			isNull = true;
		}
    }

if(isNull)
	{document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = errorMsg;
		return false;
	}
else
{


	var reason = "";


  reason += validatePassword(document.getElementById("epass1"));
      


  if (reason != "") {


document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = "Some fields need correction:<br>" + reason;

    return false;
  }
  else
  {
		

 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

      if(xmlhttp.responseText.indexOf("success") != -1)
	{
		document.getElementById("spanStatus").style.color = "green";
		document.getElementById("spanStatus").innerHTML = xmlhttp.responseText;	

setTimeout(function () { // wait 3 seconds and reload
    window.location = "index.php";
  }, 3000);

	}
	else
	{
		document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = xmlhttp.responseText;	
	}
     }
  }

  xmlhttp.open("POST","edit_password.php", true);  
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

				  xmlhttp.send("name="+ name + "&email=" + email + "&o=" + oldpass + "&p=" + pass1);
  }



}


}


function validateResetForm(){

document.getElementById("spanStatus").innerHTML = '';

  var name = document.getElementById("nameR").value;
var email = document.getElementById("emailR").value;

var isNull = false;
	var errorMsg = 'Opss.. Something wrong!';

	
    if (name==null || name=="") {
        errorMsg += "<br>Please enter the name.";
        isNull = true;
    }
		    if (email==null || email=="") {
        errorMsg += "<br>Please enter the email.";
        isNull = true;
    }

if(isNull)
	{document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = errorMsg;
		return false;
	}
	else
	{


 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      if(xmlhttp.responseText == "Found")
	{



//starts

if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

      if(xmlhttp.responseText.indexOf("sent") == -1 )
	{
document.getElementById("spanStatus").style.color = "red";
document.getElementById("spanStatus").innerHTML = xmlhttp.responseText ;
	}
else
{
document.getElementById("spanStatus").style.color = "green";
document.getElementById("spanStatus").innerHTML = xmlhttp.responseText ;
document.getElementById("resetPass").style.display = "block";
document.getElementById("reset").style.display="none";

//here
}
		
	}
    }
		  xmlhttp.open("POST","reset_password.php", true);  
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

				  xmlhttp.send("name="+ name + "&email=" + email);
//ends


	}
	else
	{
document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = xmlhttp.responseText ;

		
	}
    }
  }
  xmlhttp.open("GET","check_exist_user.php?n="+name + "&e="+email,true);
  xmlhttp.send();

	
	}


}



/*functions for validating*/
function validateUsername(fld) {
    var error = "";

fld.style.border="";

    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if ((fld.value.length < 5) || (fld.value.length > 10)) {
        fld.style.border = '1px solid red';  
        error = "The username should more than 5 characters and less than 10 characters. <br>";
    } else if (illegalChars.test(fld.value)) {
        fld.style.border = '1px solid red'; 
        error = "The username contains illegal characters.<br>";
    } else {
fld.style.border="";
    } 
    return error;
}

function validatePassword(fld) {
    var error = "";
fld.style.border="";
    
    if ((fld.value.length < 4) || (fld.value.length > 10)) {
        error = "The password should more than 4 characters and less than 10 characters. <br>";
         fld.style.border = '1px solid red'; 
    }else {
fld.style.border="";
    }
   return error;
}  

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
} 

function validateEmail(fld) {
    var error="";
fld.style.border="";
    var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    
    if (!emailFilter.test(tfld)) {              //test email for illegal characters
        fld.style.border = '1px solid red'; 
        error = "Please enter a valid email address.<br>";
    } else if (fld.value.match(illegalChars)) {
        fld.style.border = '1px solid red'; 
        error = "The email address contains illegal characters.<br>";
    } else {
fld.style.border="";
    }
    return error;
}


function validatePhone(fld) {
    var error = "";
fld.style.border="";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');     

   if (isNaN(parseInt(stripped))) {
        error = "The phone number contains illegal characters.<br>";
        fld.style.border = '1px solid red'; 
    } else if (!(stripped.length == 10)) {
        error = "The phone number should have 10 digits. Make sure you included an area code.<br>";
        fld.style.border = '1px solid red'; 
    } else
	{
fld.style.border="";
}
    return error;
}

function validateAddress(fld) {
    var error="";
	fld.style.border="";

    var requireChars = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9_-\s\,\.]+)$/;
    var illegalChars= /[\(\)\<\>\;\:\\\"\[\]]/ ;

    if (!fld.value.match(requireChars)) {              //test address for illegal characters
        fld.style.border = '1px solid red'; 
        error = "Address should contains a character and a number. Only - _ . , and space are allowed.<br>";
    } else if (fld.value.match(illegalChars)) {
        fld.style.border = '1px solid red'; 
        error = "The address contains illegal characters.<br>";
    } else {
fld.style.border="";
    }
    return error;
}

function validateForm() {
	
document.getElementById("spanStatus").innerHTML = '';

    var name = document.forms["myForm"]["name"].value;
	var address = document.forms["myForm"]["address"].value;
	var phone = document.forms["myForm"]["phone"].value;
	var sex = document.forms["myForm"]["sex"].value;
	var email = document.forms["myForm"]["email"].value;
	var pass1 = document.forms["myForm"]["pass1"].value;
	var pass2 = document.forms["myForm"]["pass2"].value;
	
	var isNull = false;
	var errorMsg = 'Opss.. Something wrong!';
	
    if (name==null || name=="") {
        errorMsg += "<br>Please enter the name.";
	document.forms["myForm"]["name"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["name"].style.border = "";
	}
		    if (email==null || email=="") {
        errorMsg += "<br>Please enter the email.";
	document.forms["myForm"]["email"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["email"].style.border = "";
	}
	    if (phone==null || phone=="" || isNaN(phone)) {
        errorMsg += "<br>Please enter the phone (only numbers).";
	document.forms["myForm"]["phone"].style.border = "1px solid red";
        isNull = true;
    }	
	    else
    {
document.forms["myForm"]["phone"].style.border = "";
	}
	
	    if (pass1==null || pass1=="") {
        errorMsg += "<br>Please enter the password.";
document.forms["myForm"]["pass1"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["pass1"].style.border = "";
	}
	    if (pass2==null || pass2=="") {
        errorMsg += "<br>Please enter the confirmation password.";
document.forms["myForm"]["pass2"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["pass2"].style.border = "";
	}
	
		if ( (pass1 != null && pass1 !="" ) &&(pass2 != null && pass2 !="")) {
		
		if(pass1 != pass2)
		{
			errorMsg += "<br>Confirmed password not match.";
			document.forms["myForm"]["pass2"].style.border = "1px solid red";
			isNull = true;
		}
    else
    {
document.forms["myForm"]["pass2"].style.border = "";
	}
    }
	
		    if (sex==null || sex=="default") {
        errorMsg += "<br>Please select your gender.";
	document.forms["myForm"]["sex"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["sex"].style.border = "";
	}
	
	    if (address==null || address=="") {
        errorMsg += "<br>Please enter the address.";
	document.forms["myForm"]["address"].style.border = "1px solid red";
        isNull = true;
    }
    else
    {
document.forms["myForm"]["address"].style.border = "";
	}


	
	if(isNull)
	{
		document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = errorMsg;
		return false;
	}
	else
	{


		var reason = "";

  reason = reason + validateUsername(document.forms["myForm"]["name"]);
  reason += validateAddress(document.forms["myForm"]["address"]);
  reason += validatePhone(document.forms["myForm"]["phone"]);
  reason += validateEmail(document.forms["myForm"]["email"]);
  reason += validatePassword(document.forms["myForm"]["pass1"]);
      


  if (reason != "") {


document.getElementById("spanStatus").style.color = "red";
		document.getElementById("spanStatus").innerHTML = '';
		document.getElementById("spanStatus").innerHTML = "Some fields need correction:<br>" + reason;

    return false;
  }
  else
  {
		return true;
  }
	
	}
}




</script>
<div id="content" class="login_background clearfix" style="position: relative;">
	<div class="login" id="login">
        <form action="index.php" method="post" name="Login">
            <h2 style="margin:5px" id="loginText">Login</h2>
            <span style="color:red"><?php if(isset($message)){ echo $message;} ?></span>
            <input type="text" name="email" placeholder="Email@kayliner.com" class="input-field" id="loginEmail">
            <?php if (isset($errors['email'])){echo '<p style="color: red;text-align:center;font-size:12px;">',$errors['email'],'</p>';}?>
            <input type="password" name="pass" placeholder="Password" class="input-field" id="loginPassword">
             <?php if (isset($errors['pass'])){echo '<p style="color: red;text-align:center;font-size:12px;">',$errors['pass'],'</p>';}?>

<div  id="registerDiv">
            <input type="submit" name="login" value="Login" class="MyButton"> 
<a id="registerBtn" style="font-size:12px;height:28px;cursor:pointer;color:blue;text-decoration:underline;" onClick="showRegister();">New user?</a>
</div>

 <?php if (isset($errors)){echo '<br><p style="text-align:center;font-size:12px;" id="resetP">Forgot your password? <br><a onclick="showReset();" style="cursor:pointer;color:blue;text-decoration:underline;">Reset here</a></p>';}?>
            
        </form>
        
    </div>
    
 <div  style="
    padding-left: 10px;display:none;
" id="reset">

            <h2 style="margin:5px">Reset Password</h2>
 <input id="nameR" type="text" name="name" placeholder="Username" class="input-field">
<br>
 <input id="emailR" type="email" name="email" placeholder="Example@email.com" class="input-field">
<br>
        <input type="button" name="submit" value="Submit" class="MyButton" onclick="validateResetForm()" > 
   
        
</div>


    <div  style="
    padding-left: 10px;display:none;
" id="register">
        <form action="register.php" method="post" name="Register" onsubmit="return validateForm()" id="myForm">
            <h2 style="margin:5px">Register</h2>
 <input id="name" type="text" name="name" placeholder="Username" class="input-field">

 <input id="email" type="email" name="email" placeholder="Example@email.com" class="input-field">
<br>
               <input id="phone" name="phone" placeholder="Phone Number" type="text" class="input-field">

  <select name="sex" class="input-field" style="width: 176px;">
                <option value="default">Choose your gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>

               
<br>
        <input id="pass1" type="password" name="pass1" placeholder="Password" class="input-field">

        <input id="pass2" type="password" name="pass2" placeholder="Confirm Password" class="input-field">
        
          

        
        <br>
        <input id="address" type="text" name="address" placeholder="Valid Address" class="input-field" style="
    width: 87.5%;
">

<br>
<input type="submit" name="submit" value="Submit" class="MyButton"> 

        </form>
        
</div>

  <div  style="
    padding-left: 10px;display:none;
" id="resetPass">
        
            <h2 style="margin:5px">Edit password</h2>

<input id="eoldpass" type="password" name="oldpass" placeholder="Sent Password" class="input-field">
<br>
       <input id="epass1" type="password" name="pass1" placeholder="New Password" class="input-field">
<br>
        <input id="epass2" type="password" name="pass2" placeholder="Confirm Password" class="input-field">

 <input type="hidden" id="ename" name="name">
 <input type="hidden" id="eemail" name="email">

<br>
               <input type="button" value="Submit" class="MyButton" onclick="validatePassForm();"> 
        
</div>

<div id="spanDiv" style="font-size:12px;">
<span id="spanStatus" style="font-family: segoe ui;"></span>
</div>



<div id="searchRoute" style="padding-left: 10px;position:absolute;bottom:3px;">
<a href="guest_view_routes.php"  class="guestButton" style="font-size: 14px;height: 30px;width: 270px;">View current available routes</a>
</div>

</div>
<div id="login-side-bar">
	<div class="animation-1 login-anigif1 clearfix" style="margin-left:10px"></div>
    <div class="animation-2 login-anigif2 clearfix"  style="margin-left:10px"></div>
</div>
<?php include('includes/footer.html'); ?>