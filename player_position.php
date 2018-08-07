<?php
	
	require('functions.php');
	require('index.php');
	require('config.php');

	
if(isset($_POST['submit_player']))
{	
	$position_descr = $_POST['position_descr'];

	$query1 = "SELECT position_id,position_descr FROM playerposition";
	$result1 = $mysqli->query($query1,MYSQLI_STORE_RESULT);
	$rows = $result1->num_rows;
	if($rows == 0)
	{
		$query2 = "INSERT INTO playerposition(position_id,position_descr) VALUES ($rows+1,'$position_descr') ";
		$result2 = $mysqli->query($query2,MYSQLI_STORE_RESULT);	

		echo "<br><table width=25% border=1 >";
		echo "<tr>";
		echo "<th>Players position</th><th>Actions</th>";
		echo "</tr>";

		$query3 = "SELECT * FROM `playerposition` ORDER BY `position_id` ASC";
		$result3 = $mysqli->query($query3,MYSQLI_STORE_RESULT);
		while(list($position_id,$position_descr) = $result3->fetch_row())
		{
			echo "<tr>";
				echo "<td>";
					echo $position_descr;
				echo "</td>";
				echo "<td>";
					echo "<a href='?edit=$position_id'>EDIT</a> | <a href='?delete=$position_id'>DELETE</a>";
				echo "</td>";
			echo "</tr>";

		}
		echo "<table>";
	
	}
	elseif($rows <= 13)
	{
		$query = "SELECT MAX(position_id) AS last_id FROM playerposition";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($last_id) = $result->fetch_row())
		{
			$query4 = "INSERT INTO playerposition(position_id,position_descr) VALUES ($last_id+1,'$position_descr') ";
			$result4 = $mysqli->query($query4,MYSQLI_STORE_RESULT);	

			echo "<br><table width=25% border=1 >";
			echo "<tr>";
			echo "<th>Players position</th><th>Actions</th>";
			echo "</tr>";

		$query = "SELECT * FROM `playerposition` ORDER BY `position_id` ASC";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($position_id,$position_descr) = $result->fetch_row())
		{
			echo "<tr>";
				echo "<td>";
					echo $position_descr;
				echo "</td>";
				echo "<td>";
					echo "<a href='?edit=$position_id'>EDIT</a> | <a href='?delete=$position_id'>DELETE</a>";
				echo "</td>";
			echo "</tr>";

		}
		echo "<table>";
		}
	
	}
	else
	{
		echo "<br><table width=25% border=1 >";
		echo "<tr>";
		echo "<th>Players position</th><th>Actions</th>";
		echo "</tr>";

		$query3 = "SELECT * FROM `playerposition` ORDER BY `position_id` ASC";
		$result3 = $mysqli->query($query3,MYSQLI_STORE_RESULT);
		while(list($position_id,$position_descr) = $result3->fetch_row())
		{
			echo "<tr>";
				echo "<td>";
					echo $position_descr;
				echo "</td>";
				echo "<td>";
					echo "<a href='?edit=$position_id'>EDIT</a> | <a href='?delete=$position_id'>DELETE</a>";
				echo "</td>";
			echo "</tr>";
		}
		echo "<table>";
	}
}
else
{
	echo "<br><table width=25% border=1 >";
	echo "<tr>";
	echo "<th>Players position</th><th>Actions</th>";
	echo "</tr>";

	$query4 = "SELECT position_id,position_descr FROM playerposition ";
	$result4 = $mysqli->query($query4,MYSQLI_STORE_RESULT);
	while(list($position_id,$position_descr) = $result4->fetch_row())
	{
		echo "<tr>";
			echo "<td>";
				echo $position_descr;
			echo "</td>";
		echo "<td>";
			echo "<a href='?edit=$position_id'>EDIT</a> | <a href='?delete=$position_id'>DELETE</a>";
		echo "</td>";
		echo "</tr>";

	}
		echo "<table>";	
}

	if(isset($_GET['edit']))
	{
		$position_id = $_GET['edit'];
		
		$query5 = "SELECT position_id,position_descr FROM playerposition WHERE position_id=$position_id";
		$result5 = $mysqli->query($query5,MYSQLI_STORE_RESULT);
		while (list($position_id,$position_descr) = $result5->fetch_row()) 
		{
		 echo "<form method='POST'><pre>";
		 echo "Edit player position:<input type='text' name='position_descr' value='$position_descr'/>";
		 echo "<input type='hidden' name='position_id' value=$position_id />";
		 echo "<br><input type='submit' name='edit_position' value='SUBMIT'/>";
		 echo "</pre></form>";
		}
	}

	if(isset($_POST['edit_position']))
	{
		$position_id = $_POST['position_id'];
		$position_descr = $_POST['position_descr'];
		$query = "UPDATE playerposition SET position_descr='$position_descr' WHERE position_id=$position_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		header('location:player_position.php');
	}

	if(isset($_GET['delete']))
	{
		 $position_id = $_GET['delete'];
		 echo "<h2>Are you sure you want to delete this position</h2><a href='?yes=$position_id'>YES</a> | <a href='?no'>NO</a>";
	}

	if (isset($_GET['yes'])) 
	{
		$position_id = $_GET['yes'];
		
		$query6 = "DELETE FROM playerposition  WHERE `position_id` = $position_id";
		$result6 = $mysqli->query($query6,MYSQLI_STORE_RESULT);
		header('location:player_position.php');
	}

	elseif(isset($_GET['no']))	
	{
		echo "<h2>Ok no problem,please continue..</h2>";
	}

?>
<pre>
	<form method='POST'>
		<b>Add player position:</b><input type='text' name='position_descr' required="" /><br>
		<input type='submit' name='submit_player' value='submit'>
	</form>
 </pre>
