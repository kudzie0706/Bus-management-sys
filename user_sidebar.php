
<?php include('core/dbconnect.php');?>
<?php
	if ($_SESSION['type'] == 4){

?>


<div id="side-bar" class="show-me" style="min-height: 200px;">
<div class="basic-grey">
<h1>About us
    </h1>
    <span style="
    font-weight: bold;
">Kayliner is a company..</span>
</h1>


</div>
</div>

<div id="side-bar" class="show-me" style="min-height: 172px;">

<div class="login-anigif1 clearfix" style="height:180px"></div>

</div>

<?php

	
	}else{ 
	echo '<h1>Isufficient privileges to view page</h1>';
}

?>