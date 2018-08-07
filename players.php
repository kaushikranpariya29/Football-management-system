<?php
	require('index.php');
	require('config.php');
	require('functions.php');

echo "<br>";

if (isset($_GET['player_submit'])) 
{	
	$player_name = clear($_GET['player_name']);
	$team_id = clear($_GET['team_id']);
	$player_sqd_num = clear($_GET['player_sqd_num']);
	$position_id = clear($_GET['position_id']);

	$query = "SELECT * FROM players";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$rows = $result->num_rows;
	if($rows == 0)
	{
		$query = "INSERT INTO 
						players(team_id,player_name,player_sqd_num,position_id) 
					VALUES
						($team_id,'$player_name',$player_sqd_num,$position_id)";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

			echo "<table width=70% border=1>";
			echo "<tr>";
			echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
			echo "<tr>";

			$query = "SELECT 
							players.player_name,
							players.player_sqd_num,
							players.player_id, 
							teams.team_name,
							playerposition.position_descr 
						FROM 
							players 
						INNER JOIN 
								teams 
						ON 
							teams.team_id=players.team_id
						 INNER join 
								 playerposition 
								 on 
									 playerposition.position_id=players.position_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
			{
				echo "<tr>";
					echo "<td>";
						echo $player_name;
					echo "</td>";
					echo "<td>";
						echo $team_id;
					echo "</td>";
					echo "<td>";
						echo $player_sqd_num;
					echo "</td>";
					echo "<td>";
						echo $position_id;
					echo "</td>";
					echo "<td>";
						echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
	}
	elseif($rows > 0)
	{
		$query = "SELECT 
						player_name 
					FROM 
						players 
					WHERE 
						player_name='$player_name'";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$rows = $result->num_rows;
		if($rows == 0)
		{	
			$query = "SELECT
							 player_sqd_num 
			 			FROM
			 				 players 
						 WHERE 
							 player_sqd_num=$player_sqd_num";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			$row = $result->num_rows;
			if ($row == 0) 
			{
				$query = "INSERT INTO 
								players(team_id,player_name,player_sqd_num,position_id) 
							VALUES
								($team_id,'$player_name',$player_sqd_num,$position_id)";
				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

				echo "<table width=70% border=1>";
				echo "<tr>";
				echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
				echo "<tr>";

				$query = "SELECT
								 players.player_name,
								 players.player_sqd_num,
								 players.player_id, 
								 teams.team_name,
								 playerposition.position_descr 
				 			FROM 
				 				players 
				 			INNER JOIN 
				 					teams 
				 				ON 
				 					teams.team_id=players.team_id 
				 				INNER join 
				 					playerposition 
				 				on 
								 playerposition.position_id=players.position_id";
				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
				while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
				{
			
					echo "<tr>";
					echo "<td>";
						echo $player_name;
					echo "</td>";
					echo "<td>";
						echo $team_id;
					echo "</td>";
					echo "<td>";
						echo $player_sqd_num;
					echo "</td>";
					echo "<td>";
						echo $position_id;
					echo "</td>";
					echo "<td>";
						echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
					echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			elseif($row > 0)
			{
				echo "<table width=70% border=1>";
				echo "<tr>";
				echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
				echo "<tr>";

				$query = "SELECT 
								players.player_name,
								players.player_sqd_num,
								players.player_id, 
								teams.team_name,
								playerposition.position_descr
							 FROM 
								 players 
							 INNER JOIN 
				 				teams 
							 ON 
				 				teams.team_id=players.team_id 
				 			INNER join 
									 playerposition 
				 			on 
				 				playerposition.position_id=players.position_id";
				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
				while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
				{
					echo "<tr>";
						echo "<td>";
							echo $player_name;
						echo "</td>";
						echo "<td>";
							echo $team_id;
						echo "</td>";
						echo "<td>";
							echo $player_sqd_num;
						echo "</td>";
						echo "<td>";
							echo $position_id;
						echo "</td>";
						echo "<td>";
							echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
						echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<h2>That squad number is taken,choose another.</h2>";
			}
		}
		elseif($rows > 0)
		{
			echo "<table width=70% border=1>";
			echo "<tr>";
			echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
			echo "<tr>";

			$query = "SELECT 
							players.player_name,
							players.player_sqd_num,
							players.player_id, 
							teams.team_name,
							playerposition.position_descr 
						FROM 
							players 
						INNER JOIN 
							teams 
						ON 
							teams.team_id=players.team_id 
						INNER join
								 playerposition 
						 on 
							 playerposition.position_id=players.position_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
			{
				echo "<tr>";
					echo "<td>";
						echo $player_name;
					echo "</td>";
					echo "<td>";
						echo $team_id;
					echo "</td>";
					echo "<td>";
						echo $player_sqd_num;
					echo "</td>";
					echo "<td>";
						echo $position_id;
					echo "</td>";
					echo "<td>";
						echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<h2>Player allready entered.</h2>";
		}	
	}
}
else
{
	if (!isset($_GET['teams_sort'])) 
	{
		echo "<table width=70% border=1>";
		echo "<tr>";
		echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
		echo "<tr>";

		$query = "SELECT 
						players.player_name,
						players.player_sqd_num,
						players.player_id, 
						teams.team_name,
						playerposition.position_descr 
					FROM 
						players 
					INNER JOIN 
						teams 
					ON 
						teams.team_id=players.team_id 
					INNER join 
						playerposition 
					on 
						playerposition.position_id=players.position_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
		{
			echo "<tr>";
			echo "<td>";
				echo $player_name;
			echo "</td>";
			echo "<td>";
				echo $team_id;
			echo "</td>";
			echo "<td>";
				echo $player_sqd_num;
			echo "</td>";
			echo "<td>";
				echo $position_id;
			echo "</td>";
			echo "<td>";
				echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	elseif (isset($_GET['teams_sort'])) 
	{	
		echo "<table width=70% border=1>";
			echo "<tr>";
			echo "<th><a href='?player_sort'>Player</a></th><th><a href='?teams_sort='>Team</a></th><th>Shirt number</th><th>Positions</th><th>Actions</th>";
			echo "<tr>";

		$query = "SELECT 
						players.player_name,
						players.player_sqd_num,
						players.player_id, 
						teams.team_name,
						playerposition.position_descr 
					FROM 
						players 
					INNER JOIN 
							teams 
					ON 
						teams.team_id=players.team_id 
					INNER join 
							playerposition 
					on 
						playerposition.position_id=players.position_id 
					ORDER BY 
							team_name 
									ASC";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($player_name,$player_sqd_num,$player_id,$team_id,$position_id) = $result->fetch_row()) 
		{
			echo "<tr>";
			echo "<td>";
				echo $player_name;
			echo "</td>";
			echo "<td>";
				echo $team_id;
			echo "</td>";
			echo "<td>";
				echo $player_sqd_num;
			echo "</td>";
			echo "<td>";
				echo $position_id;
			echo "</td>";
			echo "<td>";
			echo "<a href='?edit=$player_name&player_sqd_num=$player_sqd_num&player_id=$player_id&team_name=$team_id'>EDIT</a> | <a href='?delete=$player_id'>DELETE</a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}	
}



if(isset($_GET['delete'])) 
{
	$player_id = $_GET['delete'];
	
	echo "<h2>Delete this entry ? <a href='?yes=$player_id'>Yes</a> | <a href='?no'>No</a></h2>";

}
elseif(isset($_GET['yes']))
{
	$player_id = $_GET['yes'];

	$query5 = "DELETE FROM 
						players 
					WHERE 
						player_id=$player_id";
	$result5 = $mysqli->query($query5,MYSQLI_STORE_RESULT);
	unset($_GET['delete']);
	header('location:players.php');
}
elseif(isset($_GET['no']))
{
	echo "<h2>Ok then continue...</h2>";
	unset($_GET['delete']);
	header('location:players.php');
}
if(isset($_GET['edit']))
{
	$player_name = clear($_GET['edit']);
	$player_sqd_num = clear($_GET['player_sqd_num']);
	$player_id = clear($_GET['player_id']);
	$team_name = $_GET['team_name'];

	echo "<form>";
	echo "<pre>";
	echo "Edit player details<br><br>";
	echo "surname,name:<input type='text' name='player_name' value='$player_name' required=''><br><br>";

		echo "Team name: ".$team_name;	

	echo "<input type='hidden' name='player_id' value=$player_id />";
	echo "<br><br>Number:<input type='text' name='player_sqd_num' value=$player_sqd_num required=''>";

?>
<br>
Position:<br>
<table  width=10%  border='1' style=border-collapse:collapse>

<?php

	$query2 = "SELECT * FROM playerposition ORDER BY position_id ASC";
	$result2 = $mysqli->query($query2,MYSQLI_STORE_RESULT);
	while(list($position_id,$position_descr) = $result2->fetch_row())
	{	

		if ($position_id == 1) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id required />".$position_descr;
				echo "</td>";			
			}

			elseif($position_id == 2)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";					
			}			
		
			elseif ($position_id == 3) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 4)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 5) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 6)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 7) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 8)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 9) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 10)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 11) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 12)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 13) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 14)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			} 
		}	
	
echo "</table>";
echo "<br><input type='submit' name='edit_submit' value='SUBMIT'>";
echo "</pre>";
echo "</form>";

}
if(isset($_GET['edit_submit'])) 
{
	$player_name = clear($_GET['player_name']);
	$player_sqd_num = clear($_GET['player_sqd_num']);
	$position_id = clear($_GET['position_id']);
	$player_id = clear($_GET['player_id']);

	$query = "SELECT 
					player_sqd_num,player_id 
				from 
					players 
				where
					 player_sqd_num=$player_sqd_num 
				 and 
	 				player_id=$player_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$number = $result->fetch_assoc();

	if($player_sqd_num == $number['player_sqd_num'] && $player_id == $number['player_id'])
	{
		$query = "UPDATE 
						players 
					SET 
						player_name='$player_name',player_sqd_num=$player_sqd_num,position_id=$position_id 
					WHERE 
						player_id=$player_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		header('location:players.php');	
	}
	elseif ($number == null) 
	{
		
		$query = "SELECT 
						player_sqd_num 
					from 
						players";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while($row = $result->fetch_assoc())
		{
			foreach ($row as $key => $value) 
			{
				if($player_sqd_num == $value)
				{
					echo "<h2>That number is allready taken,choose another.</h2>";
					break;
				}
				else
				{
					$query = "UPDATE 
									players 
								SET 
									player_name='$player_name',player_sqd_num=$player_sqd_num,position_id=$position_id 
								WHERE 
									player_id=$player_id";
					$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
					header('location:players.php');
					break;
				}
				break;
			}
			break;
		}
	}	

}

?>

<form>
<pre>
Add player<br>
surname,name:<input type="text" name="player_name" required=""><br>
<?php
	echo "Select team:<select name='team_id'>";

	$query1 = "SELECT * FROM teams";
	$result1 = $mysqli->query($query1,MYSQLI_STORE_RESULT);
	while (list($team_id,$team_name) = $result1->fetch_row()) 
	{	
		echo "<option value='$team_id'>".$team_name."</option>";	
	}
	echo	"</select>"; 
?>
<br>
Number:<input type="text" name="player_sqd_num" value="" required=""><br>
Position:<br>
<table  width=10%  border='1' style=border-collapse:collapse>
<?php
	
	$query2 = "SELECT position_id,position_descr FROM PlayerPosition ORDER BY position_id ASC";
	$result2 = $mysqli->query($query2,MYSQLI_STORE_RESULT);
	
	if($result2->num_rows == 0)
		{
			echo "<h2>No positions available</h2>";
		}
	else
	{	
	while(list($position_id,$position_descr) = $result2->fetch_row())
	{	

		if ($position_id == 1) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id required />".$position_descr;
				echo "</td>";			
			}

			elseif($position_id == 2)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";					
			}			
		
			elseif ($position_id == 3) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 4)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 5) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 6)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 7) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 8)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 9) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
			}
			elseif($position_id == 10)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 11) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 12)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
				echo "</tr>";
			}
			elseif ($position_id == 13) 
			{
				echo "<tr>";
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;
				echo "</td>";
			}
			elseif($position_id == 14)
			{
				echo "<td >";
				echo "<input type='radio' name='position_id' value=$position_id />".$position_descr;	
				echo "</td>";
				echo "</tr>";
			} 
		}	
	}
?>
</table>

</table>
<input type="submit" name="player_submit" value="SUBMIT">
	</pre>
</form>