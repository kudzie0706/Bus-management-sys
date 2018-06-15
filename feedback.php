<?php $title = 'Feedback'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/header.html');// Including the header of the page ?>
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 4){
		
		include('includes/user-menu.html');

if ($_SERVER['REQUEST_METHOD']=='POST'){


if(isset($_POST['email'])) {
 
     
 
 
    $email_to = "xxx@gmail.com";
 
    $email_subject = "Someone has giving you a feedback.";
 
     
 
     
 
    function died($error) {
 
 
        echo "<div id=\"content\" style=\"padding-left: 10px;\"><br />We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and enter again<br /><br /></div>";
 
 		include('user_sidebar.php');
		
        die();
 
    }
 
     
 
    if(!isset($_POST['first_name']) ||
 
        !isset($_POST['last_name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['subject']) ||
 
        !isset($_POST['details'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
 
    $first_name = $_POST['first_name']; // required
 
    $last_name = $_POST['last_name']; // required
 
    $email_from = $_POST['email']; // required
 
    $telephone = $_POST['subject']; // not required
 
    $comments = $_POST['details']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= '<span style="color:red">The Email Address you entered does not appear to be valid.<br /></span>';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= '<span style="color:red">The First Name you entered does not appear to be valid.<br /></span>';
 
  }
 
  if(!preg_match($string_exp,$last_name)) {
 
    $error_message .= '<span style="color:red">The Last Name you entered does not appear to be valid.<br /></span>';
 
  }
 
  if(strlen($comments) < 2) {
 
    $error_message .= '<span style="color:red">The Details you entered do not appear to be valid.<br /></span>';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
 
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Subject: ".clean_string($telephone)."\n";
 
    $email_message .= "Details: ".clean_string($comments)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  
 

$message = "<span style=\"color:green\">Thank you for contacting us. We will be in touch with you very soon.</span>";
 
}
	
}

?>



<div id="content">

<form name="contactform" method="post" action="feedback.php" class="basic-grey" >
 
 <h1>Feedback <span><?php if ($_SERVER['REQUEST_METHOD']=='POST'){
	
	if($error_message)
	{
		echo $error_message;	
	}
	
	if($message)
	{
		echo $message;	
	}
 } else
 {
	echo "Any feedback or suggestion? Feel free to tell us.";
 }?></span>
    </h1>
    

 
  <label for="first_name">First Name * </label>
  <input  type="text" name="first_name" maxlength="50" size="30" style="width: 90%;">

 

 
  <label for="last_name">Last Name *</label>
  <input  type="text" name="last_name" maxlength="50" size="30" style="width: 90%;">
 
 
  <label for="email">Email Address *</label>
  <input  type="text" name="email" maxlength="80" size="30" style="width: 90%;">
 
 
  <label for="subject">Subject</label>
  <input  type="text" name="subject" maxlength="30" size="30" style="width: 90%;">

  <label for="Details">Details *</label>
  <textarea  name="details" maxlength="1000" cols="25" rows="6" style="width: 90%;"></textarea>
 
 
  <input type="submit" value="Submit" class="button">
   
 </td>
 
</tr>
 
</table>
 
</form>

</div>
<?php include('user_sidebar.php'); ?>

<?php

	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>