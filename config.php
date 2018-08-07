<?php
	$db_host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "fms";

	$mysqli = mysqli_connect($db_host,$db_user,$db_password,$db_name);
	if($mysqli->connect_errno)
	{
		echo "connection error";
	}

?>