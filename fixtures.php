<?php 
	
	require ('index.php');
	require('config.php');
	require('functions.php');


if(isset($_POST['submit_info']))
{
	$fixture_date = clear($_POST['fixture_date']);
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fixture_date)) 
	{
    	$fixture_time = clear($_POST['fixture_time']);
		$comp_id = clear($_POST['comp_id']);		
		$home_teamID = clear($_POST['home_teamID']);
		$away_teamID = clear($_POST['away_teamID']);
		if($home_teamID == $away_teamID)
		{
			echo	"<pre>";
			echo "<table width=70% border=1>";
			echo	"<tr>
					<th>Fixture</th><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Comp</th><th>Actions</th>";
			echo	"</tr>";

			echo "<tr>";
	//SELECT a.team_name as home_team, b.team_name as away_team FROM teams as a, teams as b WHERE a.team_id = 1 AND b.team_id = 2 
		$query = "SELECT
							 teams.team_name,
							 fixtures.fixture_id,
							 fixtures.fixture_date,
							 fixtures.fixture_time,
							 fixtures.home_teamID,
							 fixtures.away_teamID,
							 fixtures.comp_id
				 		from teams 
						 INNER join fixtures 
						 WHERE fixtures.home_teamID = teams.team_id";

				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
				while ($teams = $result->fetch_assoc()) 
				{
					$fixture_id = $teams['fixture_id'];
					
					echo "<tr>";
						echo "<td>";
							echo $teams['team_name'];
							echo "</td>";
							echo "<td>";
								echo $teams['fixture_date'];
							echo "</td>";
							echo "<td>";
								echo substr($teams['fixture_time'],0,5); 
							echo "</td>";
							echo "<td>";	

								echo $teams['team_name'];	

							echo "</td>";
							echo "<td>";
							
								echo  $teams['away_teamID'];
								
							echo "</td>";
							echo "<td>";
								echo $teams['comp_id'];
							echo "</td>";
							echo "<td>";
							
							echo "<a href='?edit=$fixture_id'>EDIT</a>". " | " ."<a href='?delete=$fixture_id'>DELETE</a>";
						
						echo "</td>";
					echo "</tr>";
				}
		echo "</table>";
		echo "</pre>";
			$_GET['same_teams'] =  "<h2>Teams are the same,choose again.</h2>";
		}
		elseif($home_teamID != $away_teamID || $away_teamID != $home_teamID)
		{
			$query = "SELECT * FROM fixtures WHERE home_teamID=$home_teamID and away_teamID=$away_teamID";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			$teams = $result->num_rows;
			if ($teams == 0) 
			{
				$query = "INSERT INTO fixtures VALUES (null,'$fixture_date','$fixture_time','$home_teamID','$away_teamID','$comp_id')";
				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);

			echo	"<pre>";
	echo "<table width=70% border=1>";
	echo	"<tr>
		<th>Fixture</th><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Comp</th><th>Actions</th>";
	echo	"</tr>";

	echo "<tr>";
	//SELECT a.team_name as home_team, b.team_name as away_team FROM teams as a, teams as b WHERE a.team_id = 1 AND b.team_id = 2 
	$query = "SELECT
				 teams.team_name,
				 fixtures.fixture_id,
				 fixtures.fixture_date,
				 fixtures.fixture_time,
				 fixtures.home_teamID,
				 fixtures.away_teamID,
				 fixtures.comp_id
	 		from teams 
			 INNER join fixtures 
			 WHERE fixtures.home_teamID = teams.team_id";

	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while ($teams = $result->fetch_assoc()) 
	{
		$fixture_id = $teams['fixture_id'];
		
		echo "<tr>";
			echo "<td>";
				echo $teams['team_name'];
				echo "</td>";
				echo "<td>";
					echo $teams['fixture_date'];
				echo "</td>";
				echo "<td>";
					echo substr($teams['fixture_time'],0,5); 
				echo "</td>";
				echo "<td>";
					
					echo $teams['team_name'];

				
				echo "</td>";
				echo "<td>";
				
					echo  $teams['away_teamID'];
					
				echo "</td>";
				echo "<td>";
					echo $teams['comp_id'];
				echo "</td>";
				echo "<td>";
				
				echo "<a href='?edit=$fixture_id'>EDIT</a>". " | " ."<a href='?delete=$fixture_id'>DELETE</a>";
			
			echo "</td>";
			echo "</tr>";
	}
		echo "</table>";
		echo "</pre>";

				$_GET['successful_submission'] = "<h2>Fixture has been submitted. Enter next fixture.</h2>";
			}
			else
			{
				while(list($fixture_id,$fixture_date) = $result->fetch_row())
				{
							echo	"<pre>";
							echo "<table width=70% border=1>";
							echo	"<tr>
									<th>Fixture</th><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Comp</th><th>Actions</th>";
							echo	"</tr>";

							echo "<tr>";
					//SELECT a.team_name as home_team, b.team_name as away_team FROM teams as a, teams as b WHERE a.team_id = 1 AND b.team_id = 2 
					$query = "SELECT
								 teams.team_name,
								 fixtures.fixture_id,
								 fixtures.fixture_date,
								 fixtures.fixture_time,
								 fixtures.home_teamID,
								 fixtures.away_teamID,
								 fixtures.comp_id
					 		from teams 
							 INNER join fixtures 
							 WHERE fixtures.home_teamID = teams.team_id";

					$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
					while ($teams = $result->fetch_assoc()) 
					{
						$fixture_id = $teams['fixture_id'];
						
						echo "<tr>";
							echo "<td>";
								echo $teams['team_name'];
								echo "</td>";
								echo "<td>";
									echo $teams['fixture_date'];
								echo "</td>";
								echo "<td>";
									echo substr($teams['fixture_time'],0,5); 
								echo "</td>";
								echo "<td>";
									
									echo $teams['team_name'];

								
								echo "</td>";
								echo "<td>";
								
									echo  $teams['away_teamID'];
									
								echo "</td>";
								echo "<td>";
									echo $teams['comp_id'];
								echo "</td>";
								echo "<td>";
								
								echo "<a href='?edit=$fixture_id'>EDIT</a>". " | " ."<a href='?delete=$fixture_id'>DELETE</a>";
							
							echo "</td>";
						echo "</tr>";
					}
						echo "</table>";
						echo "</pre>";

					$_GET['fixture_duplicate'] = "<h2>Those teams are allready playing on " . $fixture_date."</h2>";
				}
			}

		}
	} 
	else 
	{
					echo	"<pre>";
	echo "<table width=70% border=1>";
	echo	"<tr>
			<th>Fixture</th><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Comp</th><th>Actions</th>";
	echo	"</tr>";

	echo "<tr>";
	//SELECT a.team_name as home_team, b.team_name as away_team FROM teams as a, teams as b WHERE a.team_id = 1 AND b.team_id = 2 
	$query = "SELECT
				 teams.team_name,
				 fixtures.fixture_id,
				 fixtures.fixture_date,
				 fixtures.fixture_time,
				 fixtures.home_teamID,
				 fixtures.away_teamID,
				 fixtures.comp_id
	 		from teams 
			 INNER join fixtures 
			 WHERE fixtures.home_teamID = teams.team_id";

	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while ($teams = $result->fetch_assoc()) 
	{
		$fixture_id = $teams['fixture_id'];
		
		echo "<tr>";
			echo "<td>";
				echo $teams['team_name'];
				echo "</td>";
				echo "<td>";
					echo $teams['fixture_date'];
				echo "</td>";
				echo "<td>";
					echo substr($teams['fixture_time'],0,5); 
				echo "</td>";
				echo "<td>";
					
					echo $teams['team_name'];

				
				echo "</td>";
				echo "<td>";
				
					echo  $teams['away_teamID'];
					
				echo "</td>";
				echo "<td>";
					echo $teams['comp_id'];
				echo "</td>";
				echo "<td>";
				
				echo "<a href='?edit=$fixture_id'>EDIT</a>". " | " ."<a href='?delete=$fixture_id'>DELETE</a>";
			
			echo "</td>";
		echo "</tr>";
	}
	

echo "</table>";
echo "</pre>";
   	 	$_GET['wrong_date-format'] =  "<b>Wrong date format entered,enter as 0000-00-00/year-month-day</b>";
	}

	
}
else
{
	echo	"<pre>";
	echo "<table width=70% border=1>";
	echo	"<tr>
			<th>Fixture</th><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Comp</th><th>Actions</th>";
	echo	"</tr>";

	echo "<tr>";
	//SELECT a.team_name as home_team, b.team_name as away_team FROM teams as a, teams as b WHERE a.team_id = 1 AND b.team_id = 2 
	$query = "SELECT
				 teams.team_name,
				 fixtures.fixture_id,
				 fixtures.fixture_date,
				 fixtures.fixture_time,
				 fixtures.home_teamID,
				 fixtures.away_teamID,
				 fixtures.comp_id
	 		from teams 
			 INNER join fixtures 
			 WHERE fixtures.home_teamID = teams.team_id";

	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while ($teams = $result->fetch_assoc()) 
	{
		$fixture_id = $teams['fixture_id'];
		
		echo "<tr>";
			echo "<td>";
				echo $teams['team_name'];
				echo "</td>";
				echo "<td>";
					echo $teams['fixture_date'];
				echo "</td>";
				echo "<td>";
					echo substr($teams['fixture_time'],0,5); 
				echo "</td>";
				echo "<td>";
					
					echo $teams['team_name'];

				
				echo "</td>";
				echo "<td>";
				
					echo  $teams['away_teamID'];
					
				echo "</td>";
				echo "<td>";
					echo $teams['comp_id'];
				echo "</td>";
				echo "<td>";
				
				echo "<a href='?edit=$fixture_id'>EDIT</a>". " | " ."<a href='?delete=$fixture_id'>DELETE</a>";
			
			echo "</td>";
		echo "</tr>";
	}
	

echo "</table>";
echo "</pre>";
}
	

if(isset($_GET['edit']))
{
	$fixture_id = $_GET['edit'];

	$query = "SELECT * FROM fixtures WHERE fixture_id=$fixture_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($fixture_id,$fixture_date,$fixture_time,$home_teamID,$away_teamID,$comp_id) = $result->fetch_row())
	{
		$fixture_time = substr($fixture_time,0,5);

		$_GET['edit_form'] =
		"<form method=''>
		<input type='hidden' name='fixture_id' value=$fixture_id /><h2>
		Edit your fixture:</h2><pre>
		DATE: <input type='text' name='fixture_date' value='$fixture_date'><br><br>
		TIME:<input type='text' name='fixture_time' value='$fixture_time'/><br><br>
		HOME TEAM:<input type='text' name='home_teamID' value='$home_teamID'/><br><br>
		AWAY TEAM:<input type='text' name='away_teamID' value='$away_teamID'/><br><br
		COMP:<input type='text' name='comp_id' value='$comp_id'/><br><br>
		<input type='submit' name='edit_submit' value='SUBMIT'/>
		</pre>
		</form>";
	}

}
else
{
	if (isset($_GET['delete'])) 
	{
		$fixture_id = $_GET['delete'];

		$_GET['delete_confirm'] = "<h2>Are you sure you want to delete this fixture ?</h2><form method='POST'><a href='?yes=$fixture_id'>YES</a> | <a href='?no=no'>NO</a></form>";
	}
	elseif(isset($_GET['yes']))
	{
		$fixture_id = $_GET['yes'];

		$query = "DELETE FROM fixtures
				  WHERE fixture_id=$fixture_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		header('location:fixtures.php');
	}
}

?>
<br>


<?php
if (isset($_GET['wrong_date-format'])) 
{
	echo $_GET['wrong_date-format'];
	unset($_GET['wrong_date-format']);
}
if(isset($_GET['same_teams']))
{
	echo $_GET['same_teams'];
	unset($_GET['same_teams']);
}
if (isset($_GET['successful_submission']))
{
	echo $_GET['successful_submission'];
	unset($_GET['successful_submission']);	
}
if(isset($_GET['edit_form']))
{ 	
	echo $_GET['edit_form'];
	unset($_GET['edit_form']);	
}
if(isset($_GET['fixture_duplicate']))
{
	echo $_GET['fixture_duplicate'];
}


if (isset($_GET['edit_submit']))
{
	$fixture_id = $_GET['fixture_id'];
	$fixture_date = $_GET['fixture_date'];
	$fixture_time = $_GET['fixture_time'];
	$home_teamID = $_GET['home_teamID'];
	$away_teamID = $_GET['away_teamID'];
	

	$query = "UPDATE fixtures SET fixture_id=$fixture_id,fixture_date='$fixture_date',fixture_time='$fixture_time',home_teamID=$home_teamID,away_teamID=$away_teamID WHERE fixture_id=$fixture_id ";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	header('location:fixtures.php');

}
if(isset($_GET['delete_confirm']))
{
	echo $_GET['delete_confirm'];
	unset($_GET['delete_confirm']);
}
	
?>

<form method='POST' action=''>
	<pre>
	<h4><u>ADD FIXTURE:</u></h4>
	<b>DATE:</b><input type="text" name="fixture_date"  required="" />

	<b>TIME:</b><input type="text" name="fixture_time" required="" />

<?php	
	
	echo "<h4><u>Select home team:</u></h4>";
	echo "<select name='home_teamID'>";
		$query = "SELECT * FROM teams";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($team_id,$team_name,$team_email) = $result->fetch_row())
		if($mysqli->connect_error)
		{
			echo $mysqli->connect_error;
		}	
		else
		{
			echo "<option value=$team_id>". $team_name  ."</option>";
			
		}
	echo "</select>";	

	echo "<h4><u>Select away team:</u></h4>";
	echo "<select name='away_teamID'>";

	$query = "SELECT * FROM teams";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while (list($team_id,$team_name,$team_email) = $result->fetch_row())
	if($mysqli->connect_error)
	{
		echo $mysqli->connect_error;
	}	
	else
	{
		echo "<option value=$team_id>". $team_name  ."</option>";
			
	}
	echo "</select>";


echo "<h4><u>Select competition:</u></h4>";
echo "<select name='comp_id'>";

	$query = "SELECT * FROM competitions";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($comp_id,$comp_name) = $result->fetch_row())
	if($mysqli->connect_error)
	{
		echo $mysqli->connect_error;
	}
	else
	{
		echo "<option value=$comp_id>".$comp_name."</option>";
	}
	echo "</select>";
?>
		<br><br><input type="submit" name="submit_info" value="Submit"/>
	</pre>
</form>

