<?php

include('core/dbconnect.php');

$result= $dbc->query("SELECT u.user_id, u.name AS username, u.address, u.phone, u.sex, u.email, s.s_id, s.salary, s.hireddate,n.name AS nextname, n.address AS nextaddress, n.sex AS nextsex, n.phone AS nextphone
FROM users AS u
JOIN staffs AS s
JOIN nextofkin AS n
WHERE u.user_id = s.user_id and u.user_id = n.user_id and u.usertype=0");

if(!($result->num_rows))
{
   echo '<div align="center" style="padding-top: 30px;">There is no staff right now. <div><br><br>';
}
else
{

echo '<table class="table-fill"  style="
    margin: 0px;
    max-width: none;
    border-radius: 0px;
    background: black;
"><thead><tr><th  style="
    text-align: left;
    font-size: 13px;
">Name</th><th  style="
    text-align: left;
    font-size: 13px;
">Phone</th><th  style="
    text-align: left;
    font-size: 13px;
">Email</th><th  style="
    text-align: left;
    font-size: 13px;
">Action</th></tr></thead>
<tbody class="table-hover">';
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
		
		echo '<tr>';
		echo '<td class="text-left"><span>' . $row["username"] . '</span></td>';
		echo '<td class="text-left"><span>' . $row["phone"] . '</span></td>';
		echo '<td class="text-left"><span>' . $row["email"] . '</span></td>';
		echo '<td class="text-left">';
		
			if(strpos($_SERVER['HTTP_REFERER'],'edit_staff.php') == true)
			{
			echo '<a href="#" data-toggle="modal" 
			
			data-id="' . $row["user_id"] . '" 
			data-s_id="' . $row["s_id"] . '"
			data-name="' . $row["username"] . '" 
			data-address="' . $row["address"] . '" 
			data-phone="' . $row["phone"] . '" 
			data-sex="' . $row["sex"] . '" 
			data-email="' . $row["email"] . '"
			data-salary="' . $row["salary"] . '"
			data-hireddate="' . $row["hireddate"] . '"
			data-nextname="' . $row["nextname"] . '"
			data-nextaddress="' . $row["nextaddress"] . '"
			data-nextsex="' . $row["nextsex"] . '"
			data-nextphone="' . $row["nextphone"] . '"
			
			data-target="#orderModal">Edit </a><a href="/kayliner/edit_staff.php?delete='.$row["user_id"].'" style="margin-left:10px;"> Delete</a>';
			}
			else
			{
				echo '<a href="#" data-toggle="modal" 
			
			data-id="' . $row["user_id"] . '" 
			data-s_id="' . $row["s_id"] . '"
			data-name="' . $row["username"] . '" 
			data-address="' . $row["address"] . '" 
			data-phone="' . $row["phone"] . '" 
			data-sex="' . $row["sex"] . '" 
			data-email="' . $row["email"] . '"
			data-salary="' . $row["salary"] . '"
			data-hireddate="' . $row["hireddate"] . '"
			data-nextname="' . $row["nextname"] . '"
			data-nextaddress="' . $row["nextaddress"] . '"
			data-nextsex="' . $row["nextsex"] . '"
			data-nextphone="' . $row["nextphone"] . '"
			
			data-target="#orderModal">View </a>';
			}
		
		echo '</td>';
		echo '</tr>';
		}
echo '</tbody></table><br>';
}

mysqli_close($dbc);
?>