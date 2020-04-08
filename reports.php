<?php
	require('index.php');
	require('config.php');

echo "<br>";

if(isset($_GET['players_goals']))
{
	$player_id = $_GET['player_id'];
	
	$query = "SELECT
					 fixture_id 
	 			FROM 
	 				playerfixtures
	 			 WHERE 
	 				 player_id=$player_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$row = $result->num_rows;
	if ($row == 0) 
	{
		echo "<h2>Player did not feature in any fixtures.</h2>";
	}
	elseif($row > 0)
	{
		while(list($fixture_id) =$result->fetch_row())
		$total = 0;

		$query = "SELECT 
						goals_scored 
					FROM 
						playerfixtures 
					WHERE 
						player_id=$player_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while ($goals_scored = $result->fetch_assoc()) 
		{
			foreach ($goals_scored as $key => $value) 
			{
				$total += $value;
			}
		}

//SELECT players.player_name,players.team_id,teams.team_name from players inner join teams where players.player_id=teams.team_id
		$query = "SELECT 
						player_name,team_id 
					from 
						players 
					where 
						player_id=$player_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$name = $result->fetch_assoc();

		$team_id = $name['team_id'];

		$query = "SELECT 
						team_name 
					FROM 
						teams 
					where 
						team_id=$team_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$team_name = $result->fetch_assoc();

		$team_name = $team_name['team_name'];
		
		if($total == 1)
		{
			echo "<h2>".$name['player_name']." scored " . $total. " goal in all fixtures for ".$team_name.".</h2>";
		}
		else
		{
			echo "<h2>".$name['player_name']." scored " . $total. " goals in all fixtures for ".$team_name.".</h2>";
		}

			$query = "SELECT 
							team_id 
						FROM 
							players 
						WHERE 
							player_id=$player_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while (list($team_id) = $result->fetch_row()) 
			{

				$query = "SELECT 
								fixture_id,goals_scored 
							FROM 
								playerfixtures 
							WHERE 
								player_id=$player_id";
				$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
				$rows = $result->num_rows;
				while($rows = $result->fetch_assoc()) 
				{
					
					echo "<b>".$rows['goals_scored']." goals "." in fixture ".$rows['fixture_id']."</b><br>";
				}
			}	
	}		
}
if(isset($_GET['team_goals']))
{
	$team_id = $_GET['team_id'];
	$total = 0;

	$query = "SELECT 
					team_name 
				FROM 
					teams 
				WHERE 
					team_id=$team_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($team_name) = $result->fetch_row())
	{
		$query = "SELECT 
						player_id,team_id 
					from 
						players 
					where 
						team_id=$team_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while(list($player_id,$team_id) = $result->fetch_row())
		{

			$query = "SELECT 
							goals_scored 
						from 
							playerfixtures 
						where 
							player_id=$player_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while ($goals_scored = $result->fetch_assoc()) 
			{
				foreach ($goals_scored as $key => $value) 
				{
					$total += $value;
				}	
			}
			if($total == 1)
			{
				echo "<h2>".$team_name ." scored ". $total ." goal in all their fixtures.</h2>";
			}
			else
			{
				echo "<h2>".$team_name ." scored ". $total ." goals in all their fixtures.</h2>";
			}

			$query = "SELECT 
							fixture_id,goals_scored 
						from 
							playerfixtures 
						where 
							player_id=$player_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while($row = $result->fetch_assoc())
			{
				if($row['goals_scored'] == 1)
				{
					echo "<b>".$row['goals_scored']. " goal scored in fixture ". $row['fixture_id']."<b><br>";
				}
				else
				{
					echo "<b>".$row['goals_scored']. " goals scored in fixture ". $row['fixture_id']."<b><br>";
				}
				
			}
		}
	}	
}
if(isset($_GET['comp_goals']))
{	

	$comp_id = $_GET['comp_id'];

	$total = 0;

	$query = "SELECT comp_id from fixtures where comp_id=$comp_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	$num_rows = $result->num_rows;
	if($num_rows == null)
	{
		echo "<h2>No fixture.</h2>";
	}
	else
	{
		$query = "SELECT 
						fixture_id 
					from 
						fixtures 
					where 
						comp_id=$comp_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while ($row = $result->fetch_assoc()) 
		{
			$fixture_id = $row['fixture_id'];

			$query = "SELECT 
							goals_scored 
						from 
							playerfixtures 
						where 
							fixture_id=$fixture_id";
			$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
			while($goals = $result->fetch_assoc())
			{
				foreach ($goals as $key => $value) 
				{
					$total += $value;
				}
			}
		}

		$query = "SELECT 
						comp_name 
					from 
						competitions 
					where 
						comp_id=$comp_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$row = $result->fetch_assoc();
		
		echo "<h2>".$total. " goals were scored in ". $row['comp_name']."</h2>";

		$query = "SELECT 
						home_teamID,away_teamID 
					from 
						fixtures 
					where 
		comp_id=$comp_id";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		$row = $result->fetch_assoc();

		$home_teamID = $row['home_teamID'];
		$away_teamID = $row['away_teamID'];

		$query = "SELECT 
					teams.team_name
				from 
					teams 
				where 
					teams.team_id=$home_teamID
				union SELECT 
					 teams.team_name 
				from 
					 teams 
				where 
					 teams.team_id=$away_teamID";
		$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
		while($row = $result->fetch_assoc())
		{
			print_r($row);
		}
	}	
}

if(isset($_GET['team_email']))
{
	$team_id = $_GET['team_email'];
	$email_message = array();
	$query = "SELECT * FROM 
							fixtures 
						WHERE 
							home_teamID=$team_id 
						or 
							away_teamID=$team_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while ($row = $result->fetch_assoc()) 
	{
		$fixture_time = substr($row['fixture_time'],0,5);
		$fixture_id = $row['fixture_id'];
		$fixture_date = $row['fixture_date'];
		$home_teamID = $row['home_teamID'];
		$away_teamID = $row['away_teamID'];
		$comp_id = $row['comp_id'];

		array_push($email_message, "Team playing in Fixture ".$fixture_id ." on the following date: ".$fixture_date. " game starts at: ". $fixture_time." teams playing ".$home_teamID." vs ". $away_teamID. " in competition ". $comp_id );
		
	}

	$query = "SELECT 
					team_email 
				from 
					teams 
				where 
					team_id=$team_id";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while(list($team_email) = $result->fetch_row())
	{
		$team_email;
		$email_message;
		$subject = "Team fixture details";
		
		
		

//Load composer's autoloader
require ('PHPmailer/PHPMailerAutoload.php');

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'kareljordaan81@gmail.com';                 // SMTP username
    $mail->Password = 'poop@squirter';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('kareljordaan@yahoo.com', '');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
  	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  	 //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
	}
}


echo "<table width=25% border=1>";
echo "<tr>";
echo "<td>";
	//OPTION 1 PLAYER DROP DOWN FORM
	echo "<br><b>Display goals scored by chosen player:</b>";
	echo "<form>";
	echo "<pre>";

	echo "<select name='player_id'>";
	 $query_player_select = "SELECT 
									 player_id,player_name 
								FROM 
									 players";
	 $result_player_select = $mysqli->query($query_player_select,MYSQLI_STORE_RESULT);
	 while (list($player_id,$player_name) = $result_player_select->fetch_row()) 
	 {
	 	echo "<option value=$player_id>".$player_name."</option>";
	 }
	 echo "</select><br>";
	 echo "<br><input type='submit' name='players_goals' value='Get Goals' />";
	 echo "</pre>";
	 echo "</form>";
echo "</td>";
echo "</tr>";

	//OPTION 2 GOALS FOR TEAMS
echo "<tr>";
echo "<td>";
	echo "<br><b>Display goals scored by chosen team:</b>";
	echo "<form>";
	echo "<pre>";

	echo "<select name='team_id'>";
	 $query = "SELECT 
	 				team_id,team_name
	 			FROM 
	 				teams";
	 $result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	 while (list($team_id,$team_name) = $result->fetch_row()) 
	 {
	 	echo "<option value=$team_id>".$team_name."</option>";
	 }
	 echo "</select><br>";
	 echo "<br><input type='submit' name='team_goals' value='Get Goals' />";
	 echo "</pre>";
	 echo "</form>";
echo "</td>";
echo "</tr>";

	//OPTION 3 
	echo "<tr>";
	echo "<td>";
		echo "<br><b>Display goals scored in competitions:</b>";
	echo "<form>";
	echo "<pre>";

	echo "<select name='comp_id'>";
	 $query = "SELECT 
				 comp_id,comp_name 
				FROM 
	 				competitions";
	 $result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	 while (list($comp_id,$comp_name) = $result->fetch_row()) 
	 {
	 	echo "<option value=$comp_id>".$comp_name."</option>";
	 }
	 echo "</select><br>";
	 echo "<br><input type='submit' name='comp_goals' value='Get Goals' />";
	 echo "</pre>";
	 echo "</form>";
	echo "</td>";
	echo "</tr>";

	//option 4

	echo "<tr>";
	echo "<td>";
		echo "<br><b>Email team:</b>";
	echo "<form>";
	echo "<pre>";

	echo "<select name='team_email'>";

	$query = "SELECT 
				team_id,team_name
			FROM 
				teams";
	$result = $mysqli->query($query,MYSQLI_STORE_RESULT);
	while (list($team_id,$team_name) = $result->fetch_row()) 
	{
	 	echo "<option value=$team_id>".$team_name."</option>";
	}
 	echo "</select><br>";

	echo "<br><input type='submit' name='email_teams' value='Email Fixtures' />";
	echo "</pre>";
	echo "</form>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";


?>
