<?php 
	
	require('index.php');
	require('config.php');
	require('functions.php');

if(isset($_POST['submit_competition']))
{
	$competition = clear($_POST['competition']);	
	$query = "INSERT INTO competitions(comp_name) VALUES('$competition')";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$_GET['submit_success'] = "<h2>Competition was submitted.</h2>";
	
	header('location:competitions.php');
}

	
	if(isset($_GET['delete']))
	{
		$comp_id = $_GET['delete'];
			
		$_GET['delete'] = "<form  method='POST'>
		<h2>Are you sure you want to delete competition ?</h2><a href='?yes=$comp_id'>YES</a> | <a href='?no'>NO</a></form>";
	}
	if(isset($_GET['yes']))
	{
		$comp_id = $_GET['yes'];

		$query = "DELETE FROM competitions WHERE comp_id='$comp_id'";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$_GET['yes_answer'] = "<h2>Competition deleted,continue..</h2>";
		header('location:competitions.php');
	}
	if(isset($_GET['no']))
	{
			$_GET['no_delete'] = "<h2>OK no problem,please continue...</h2>";
	}

	if(isset($_GET['edit']))
	{	
		$comp_id = $_GET['edit'];

		$query = "SELECT comp_name FROM competitions WHERE comp_id=$comp_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($comp_name) = $result->fetch_row())
		{	
			$_GET['edit_form'] = "<form method='post' action=''>
			<h2>Edit competition name here please:<input type='text' name='edited_comp_name' value='$comp_name'/></h2>
		 	<input type='submit' name='edit_button' value='EDIT'/>
			</form>";
		}	
	}	

	if(isset($_POST['edit_button']))
	{
		$edited_comp_name = $_POST['edited_comp_name'];
		$query = "UPDATE competitions SET comp_name='$edited_comp_name' WHERE comp_id='$comp_id'";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		header('location:competitions.php');
	}	
 ?>
<br>
	
<pre>	
<table width="50%" border="1px">
<?php
	echo "<tr>";
	echo  "<th>Competition</th>";
	echo "<th>Actions</th>";
	echo "</tr>";
	
	$query = "SELECT * FROM competitions";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($comp_id,$comp_name) = $result->fetch_row())
	{
		
		echo "<tr>";
			echo "<td>".$comp_name."</td>";
			echo "<form method='POST' action=''>";
		echo "<td>"; 
		echo '<form method="POST" action="">';
			echo "<a href='?edit=$comp_id'>EDIT</a>"." | "."<a href='?delete=$comp_id'>DELETE</a>" ;
		echo "</form>";
		echo '</td>';
		echo "</tr>";
	}

?>
</table>
</pre>
<?php
	
	if(isset($_GET['edit_form']))
	{
		echo $_GET['edit_form'];
		unset($_GET['edit_form']);
	}
	if(isset($_GET['yes_answer']))
	{
		echo $_GET['yes_answer'];
		unset($_GET['yes_answer']);
	}	
	if(isset($_GET['no_delete']))
	{
		echo $_GET['no_delete'];
		unset($_GET['no_delete']);
	}
	if(isset($_GET['delete']))
	{
		echo $_GET['delete'];
		unset($_GET['delete']);
	}
	


?>

<form method="POST" action="">
	<pre>
		Add Competition: <input type="text" name="competition" required=""><br>
		<input type="submit" name="submit_competition"  value="Submit">
	</pre>	
</form>	