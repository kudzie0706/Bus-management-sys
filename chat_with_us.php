<?php $title = 'Chat with us'; // In this line I am defining the Title of the page which works with the design of the header.html?>
<?php include('includes/livechat-header.html');// Including the header of the page ?>
<?php
	if ($_SESSION['type'] == 4 || $_SESSION['type'] == 0 || $_SESSION['type'] == 1){

if ($_SESSION['type'] == 4)
{
	include('includes/user-menu.html');
}
else if ($_SESSION['type'] == 0)
{
	include('includes/staff-menu.html');
}
else
{
	include('includes/admin-menu.html');
}
?>

<div id="content">
<div id="chatContainer">

    <div id="chatTopBar" class="rounded"></div>
    <div id="chatLineHolder" style="width:76%;"></div>

    <div id="chatUsers" class="rounded"></div>
    <div id="chatBottomBar" class="rounded">
        <div class="tip"></div>

<script>

function setText()
{
	var name = <?php echo json_encode($_SESSION['name']); ?> ;
	var email = <?php echo json_encode($_SESSION['email']); ?>;
	
	

document.getElementById("email").value = email;
document.getElementById("name").value = name;

}

$(document).ready(function(e) {
    setText();
});

</script>
        <form id="loginForm" method="post" action="">
            <input id="name" name="name" class="rounded" maxlength="16" />
            <input id="email" name="email" class="rounded" />
            <input type="submit" class="blueButton" value="Login" />
        </form>

        <form id="submitForm" method="post" action="">
            <input id="chatText" name="chatText" class="rounded" maxlength="255" />
            <input type="submit" class="blueButton" value="Submit" />
        </form>

    </div>

</div>
</div>

<script src="includes/jquery.min.js"></script>
<script src="includes/jquery.mousewheel.js"></script>
<script src="includes/jScrollPane.min.js"></script>
<script src="script.js"></script>

<?php 

if ($_SESSION['type'] == 4)
{
	include('user_sidebar.php');

}
else if ($_SESSION['type'] == 0)
{
	include('sidebar.php');
}
else
{
	include('sidebar.php');
}
 ?>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>