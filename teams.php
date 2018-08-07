<?php
	session_start();
	require('index.php');
	require('config.php');
	require('functions.php');

	if(isset($_POST['submit']))
	{
		$team_name = clear($_POST['team_name']);
		$team_email = filter_var(($_POST['team_email']),FILTER_SANITIZE_EMAIL);
		if(!filter_var($team_email,FILTER_VALIDATE_EMAIL))
		{
			$_GET['email_invalid'] =  "<h2>Not valid email,enter again.</h2>";
		}
		else
		{
			$query = "INSERT INTO teams(team_name,team_email) VALUES('$team_name','$team_email')";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		
			$_GET['submitted'] = "<h2>Team info was submitted succesfully.Add another?</h2>";
		}			
	}
else
{

	if(isset($_GET['edit']))
	{
		 $team_id = $_GET['edit'];

		$query = "SELECT * FROM teams WHERE team_id='$team_id'";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($team_id,$team_name,$team_email) = $result->fetch_row())
		{
			 $_GET['edit_form'] =  "<form method='POST'><h2>Make changes here for:</h2><b>Team Name:</b><input type='text' name='team_name' value='$team_name'/> <b>and Email:</b><input type='text' name='team_email' value='$team_email'/><br><input type='submit' name='edit' value='EDIT' /><input type='hidden' name='team_id' value='$team_id'/></form>";
		}
	}

	if(isset($_GET['delete']))
	{
		$team_id = $_GET['delete'];

		$_GET['delete_form'] =  "<form method='POST'>
			 <h2>Are you sure you want to delete this teams info: </h2><a href='?yes=$team_id'>YES</a>"." | "."<a href='?no'>NO</a><input type='hidden' name='team_id' value='$team_id'/>";
		"</form>";
	}
	if(isset($_POST['edit']))
	{
		$team_id = $_POST['team_id'];
		$team_name = Clear($_POST['team_name']);
		$team_email = filter_var(($_POST['team_email']),FILTER_SANITIZE_EMAIL);
		if(!filter_var($team_email,FILTER_VALIDATE_EMAIL))
		{
			$_GET['edit_email_check'] = "<h2>Not valid email,enter again.</h2>";	
		}
		else
		{
			$query = "UPDATE teams SET team_name='$team_name',team_email='$team_email' WHERE team_id='$team_id'";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			header('location:teams.php');
		}
	}
	if(isset($_GET['yes']))
	{
		$team_id = $_GET['yes'];

		$query = "DELETE FROM teams WHERE team_id='$team_id'";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	}
	elseif(isset($_GET['no']))
	{
		$_GET['delete_no'] = "<h2>OK then,continue...</h2>";
	}
}
?>


<pre>
<table width="50%" border="1">
	<?php 
		echo "<tr>";
		echo "<th>Team</th><th>Teams Email</th><th>Actions</th>";
		echo "</tr>";

		$query = "SELECT * FROM teams";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($team_id,$team_name,$team_email) = $result->fetch_row())
		if($mysqli->errno)
		{
			echo errno;
		}
		else
		{
			
			echo '<form method="POST" action="">';
			echo "<tr>";
			echo "<td>";
					echo $team_name;		
			echo "</td>";

			echo "<td>";
					echo $team_email;		
			echo "</td>";
			echo "<td>";	
				echo "<a href='?edit=$team_id'>EDIT</a>"." | "."<a href='?delete=$team_id'>DELETE</a>";				
			echo "</td>";
			echo "</tr>";
		}
 	?>
</table>
</pre>
<?php
	if (isset($_GET['submitted'])) 
	{
		echo $_GET['submitted'];	
	}
	if(isset($_GET['edit_email_check']))
	{
		echo $_GET['edit_email_check'];
		unset($_GET['edit_email_check']);
	}
	if (isset($_GET['email_invalid']))
	{
		echo $_GET['email_invalid'];
		unset($_GET['email_invalid']);
	}
	if(isset($_GET['edit_form']))
	{
		echo $_GET['edit_form'];
		unset($_GET['edit_form']);
	}
	if(isset($_GET['delete_form']))
	{
		echo $_GET['delete_form'];
		unset($_GET['delete_form']);
	}
	if(isset($_GET['delete_no']))
	{
		echo $_GET['delete_no'];
	}
?>

<form action="" method="POST">
	<pre>
		Team Name:<input type="text" name="team_name" required="" /><br>
		Team Email:<input type="text" name="team_email" required="" /><br>
		<input type="submit" name="submit" value="submit"/>
	</pre>
</form>
	
