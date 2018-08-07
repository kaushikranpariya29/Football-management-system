<?php
	require('config.php');
	require('functions.php');
	require('index.php');


if(isset($_GET['player_fixtures_submit']))
{
	$player_id = clear($_GET['player_id']);
	$fixture_id = clear($_GET['fixture_id']);
	$goals_scored = clear($_GET['goals_scored']);

	$query = "SELECT * from playerfixtures";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$rows = $result->num_rows;
	if($rows == 0)
	{
		$query = "INSERT INTO
		 playerfixtures (fixture_id,player_id,goals_scored) 
		values
		 ($fixture_id,$player_id,$goals_scored)";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

		echo "<table border=1 width=50%>";
		echo "<tr>";
			echo "<th>Player</th><th>Fixture</th><th>Goals scored</th><th>Action</th>";
		echo "</tr>";

		$query = "SELECT 
						players.player_id,
						players.player_name,
						fixtures.fixture_id,
						 playerfixtures.goals_scored
					FROM 
						playerfixtures
					INNER JOIN 
						players 
					on 
						playerfixtures.player_id=players.player_id
					INNER join 
						fixtures 
					ON 
						fixtures.fixture_id=playerfixtures.fixture_id";

		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while($rows = $result->fetch_assoc())
		{	
			$player_id = $rows['player_id'];
			$fixture_id = $rows['fixture_id'];

			echo "<tr>";
			echo "<td>";
				echo $rows['player_name'];
			echo "</td>";
			echo "<td>";
				echo $rows['fixture_id'];
			echo "</td>";
			echo "<td>";
				echo $rows['goals_scored'];
			echo "</td>";
			echo "<td>";
				echo "<a href='?edit=$player_id&fixture_id=$fixture_id'>EDIT</a> | <a href='?delete=$fixture_id&player_id=$player_id'>DELETE</a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	elseif($rows != 0)
	{


		$query = "SELECT * from 
							playerfixtures 
						where 
							fixture_id=$fixture_id 
						and 
							player_id=$player_id";

		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$row = $result->num_rows;
		if($row != 0)
		{

			echo "<table border=1 width=50%>";
			echo "<tr>";
				echo "<th>Player</th><th>Fixture</th><th>Goals scored</th><th>Action</th>";
			echo "</tr>";

			$query = "SELECT 
							players.player_id,
							players.player_name,
							fixtures.fixture_id, 
							playerfixtures.goals_scored 
						FROM 
							playerfixtures 
						INNER JOIN 
							players
						on 
							playerfixtures.player_id=players.player_id 
						INNER join 
							fixtures 
						ON 
						fixtures.fixture_id=playerfixtures.fixture_id";

			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while($rows = $result->fetch_assoc())
			{	
				echo "<tr>";
				echo "<td>";
					echo $rows['player_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['fixture_id'];
				echo "</td>";
				echo "<td>";
					echo $rows['goals_scored'];
				echo "</td>";
				echo "<td>";
					echo "<a href='?edit=$player_id&fixture_id=$fixture_id'>EDIT</a> | <a href='?delete=$fixture_id&player_id=$player_id'>DELETE</a>";
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<h2>That player was allready entered for that fixture.</h2>";
		}
		elseif($row == 0)
		{
			$query = "INSERT INTO 
						playerfixtures (fixture_id,player_id,goals_scored) 
					values 
						($fixture_id,$player_id,$goals_scored)";

			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

			echo "<table border=1 width=50%>";
			echo "<tr>";
				echo "<th>Player</th><th>Fixture</th><th>Goals scored</th><th>Action</th>";
			echo "</tr>";

			$query = "SELECT players.player_id,
							players.player_name,
							fixtures.fixture_id, 
							playerfixtures.goals_scored 
						FROM 
							playerfixtures 
						INNER JOIN 
							players 
						on 
							playerfixtures.player_id=players.player_id 
						INNER join 
							fixtures 
						ON 
							fixtures.fixture_id=playerfixtures.fixture_id";

			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while($rows = $result->fetch_assoc())
			{	
				echo "<tr>";
				echo "<td>";
					echo $rows['player_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['fixture_id'];
				echo "</td>";
				echo "<td>";
					echo $rows['goals_scored'];
				echo "</td>";
				echo "<td>";
					echo "<a href='?edit=$player_id&fixture_id=$fixture_id'>EDIT</a> | <a href='?delete=$fixture_id&player_id=$player_id'>DELETE</a>";
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
	}
}
else
{
	echo "<table border=1 width=50%>";
	echo "<tr>";
		echo "<th>Player</th><th>Fixture</th><th>Goals scored</th><th>Action</th>";
	echo "</tr>";

	$query = "SELECT players.player_id,
					players.player_name,
					fixtures.fixture_id, 
					playerfixtures.goals_scored 
				FROM 
					playerfixtures 
				INNER JOIN 
					players 
				on 
					playerfixtures.player_id=players.player_id 
				INNER join 
					fixtures 
				ON 
					fixtures.fixture_id=playerfixtures.fixture_id";

	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while($rows = $result->fetch_assoc())
	{	
		$player_id = $rows['player_id'];
		$fixture_id = $rows['fixture_id'];

		echo "<tr>";
		echo "<td>";
			echo $rows['player_name'];
		echo "</td>";
		echo "<td>";
			echo $rows['fixture_id'];
		echo "</td>";
		echo "<td>";
			echo $rows['goals_scored'];
		echo "</td>";
		echo "<td>";
			echo "<a href='?edit=$player_id&fixture_id=$fixture_id'>EDIT</a> | <a href='?delete=$fixture_id&player_id=$player_id'>DELETE</a>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}




if (isset($_GET['edit'])) 
{
	$player_id = $_GET['edit'];
	$fixture_id = $_GET['fixture_id'];

	echo "<form>";
	echo "<pre>";
	echo "<br><b>Edit below:</b><br><br>";
	echo "Player:";

	$query = "SELECT 
				players.player_id,
				players.player_name,
				fixtures.fixture_id,
				playerfixtures.goals_scored 
			 FROM 
	 			playerfixtures 
	 		INNER JOIN 
	 			players 
			 on 
	 			playerfixtures.player_id=players.player_id 
	 		INNER join 
	 			fixtures 
	 		ON 
				 fixtures.fixture_id=playerfixtures.fixture_id 
	 		WHERE 
	 			playerfixtures.player_id=$player_id and playerfixtures.fixture_id=$fixture_id";

	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while($rows = $result->fetch_assoc())
	{	
		$player_name = $rows['player_name'];
		echo $player_name;
	}	
	
	echo "<br><br>Fixture:";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($player_id,$player_name,$fixture_id)= $result->fetch_row())
	{
		echo "<input type='text' name='fixture_id' value=$fixture_id />";
		echo "<input type='hidden' name='player_id' value=$player_id />";
	}
	echo "<br>";

	echo "<br>Goals:";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($player_id,$player_name,$fixture_id,$goals_scored)= $result->fetch_row())
	{
		echo "<input type='text' name='goals_scored' value=$goals_scored />";
	}
	echo "<br><br><input type='submit' name='edit_submit' value='SUBMIT'/>";
	echo "</pre>";
	echo "</form>"; 
}

elseif (isset($_GET['delete'])) 
{
	$fixture_id = $_GET['delete'];
	$player_id = $_GET['player_id'];

	echo "<h2>Delete this fixture? <a href='?yes=$fixture_id&player_id=$player_id'>YES</a> | <a href='?no'>NO</a></h2>";
}

if(isset($_GET['edit_submit']))
{
	$player_id = $_GET['player_id'];
	$fixture_id = $_GET['fixture_id'];
	$goals_scored = $_GET['goals_scored'];



	$query = "UPDATE 
				playerfixtures 
			SET 
				fixture_id=$fixture_id,goals_scored=$goals_scored 
			WHERE 
				player_id=$player_id and fixture_id=$fixture_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

	header('location:player_fixtures.php');
}

if (isset($_GET['yes'])) 
{
	$fixture_id = $_GET['yes'];
	$player_id = $_GET['player_id'];

	$query = "DELETE FROM 
				playerfixtures 
			WHERE 
				 fixture_id=$fixture_id and player_id=$player_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	
	header('location:player_fixtures.php');

}
elseif (isset($_GET['no'])) 
{
	echo "<h2>OK,continue...</h2>";
}

?>
<form>
	<pre>
<b>Add Player Fixtures:</b><br>

<?php
echo "Player:";

	$query = "SELECT player_name,player_id FROM players";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	echo "<select name='player_id'>";
	
	while(list($player_name,$player_id) = $result->fetch_row())
	{
		echo "<option value=$player_id>".$player_name."</option>";	
	}
	echo "</select>";
	echo "<br>";
?>		
<?php
	echo "Fixture:";
	echo "<select name='fixture_id'>";
	$query = "SELECT fixture_id FROM fixtures";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($fixture_id) = $result->fetch_row())
	{
		echo  "<option value=$fixture_id>".$fixture_id."</option>";
	}
	echo "</select>";
?>
<br>
Goals:<input type="text" name="goals_scored" value="" required=""><br>
<input type="submit" name="player_fixtures_submit" value="SUBMIT">
	</pre>
</form>