<?php
@ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Professor Barzan Mozafari</title>
		<style type="text/css">
		table
		{
			border: 2px solid black;
			background-color: #FFC;
			border-collapse: collapse;
			width: 200%; 
		}
		
		th
		{
			border-bottom: 5px solid #000;
		}
		
		td
		{
			border: 2px solid #666;
		}
		</style>
		<link href="CSS style.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<h1>Professor Barzan Mozafari</h1>
		
		<a href="index.php"><button type="button">Cancel</button></a><br><br>
		
		<form action="action_page_3.php" method="post">
		
		<?php
			$deleteRows = array();
			$modifyRows = array();
			
			if(!empty($_POST["delete"]))
			{
				//echo "Delete ";
				foreach($_POST["delete"] as $check) 
   				{
           				//echo $check . " ";
           				array_push($deleteRows, $check);
  				}
  				//echo "<br>";
			}
			if(!empty($_POST["modify"]))
			{
				//echo "Modify ";
				foreach($_POST["modify"] as $check) 
   				{
           				//echo $check . " ";
           				array_push($modifyRows, $check);
  				}
  				//echo "<br>";
			}
			
			$servername = "localhost";
			$username = "ab78123_" . $_SESSION["username"];
			$password = $_SESSION["password"];
			$db = "ab78123_mydatabase";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $db);
	
			// Check connection
			if ($conn->connect_error) {
			    echo '<form action="action_page.php" method="post">
				<p>Username: <input type="text" name="username" /></p>
				<p>Password: <input type="password" name="password" /></p>
				<input type="submit" value="Submit">
			    </form>';
			    die("Invalid username/password. Please try again.");
			}

			$sql = "SELECT * FROM complete";
			$result = mysqli_query($conn, $sql) or die('error');

			if ($result->num_rows > 0) 
			{	
   				
   				if (($_POST["add"] == "yes") && ($_POST["addNum"] > 0)) // Add rows
    				{
    					$_SESSION["addNum"] = $_POST["addNum"];
    						
    					echo "<p>Enter the values for the new row(s) which will appear on the bottom of the table</p>";
    						
    					echo '<table>
							
						<thead>
							<tr>
								<th scope="col">Paper</th>
								<th scope="col">Title</th>
								<th scope="col">Subtitle</th>
								<th scope="col">Person 1</th>
								<th scope="col">Person 2</th>
								<th scope="col">Person 3</th>
								<th scope="col">Person 4</th>
								<th scope="col">Person 5</th>
								<th scope="col">Person 6</th>
								<th scope="col">Person 7</th>
								<th scope="col">Person 8</th>
								<th scope="col">Person 9</th>
								<th scope="col">Person 10</th>
								<th scope="col">Publication Date</th>
								<th scope="col">Link</th>
								<th scope="col">Website</th>
								<th scope="col">Status</th>
							</tr>
						</thead>';
    						
    					for($x = 1; $x <= $_SESSION["addNum"]; $x++)
    					{
							
						// For each new row value, name for $ _ POST is columnx
							
						echo "<tr><td><input type='text' name='paper" . $x . "' /></td><td><input type='text' name='title" . $x . "' /></td><td><input type='text' name='subtitle" . $x . "' /></td><td><input type='text' name='person1" . $x . "' /></td><td><input type='text' name='person2" . $x . "' /></td><td><input type='text' name='person3" . $x . "' /></td><td><input type='text' name='person4" . $x . "' /></td><td><input type='text' name='person5" . $x . "' /></td><td><input type='text' name='person6" . $x . "' /></td><td><input type='text' name='person7" . $x . "' /></td><td><input type='text' name='person8" . $x . "' /></td><td><input type='text' name='person9" . $x . "' /></td><td><input type='text' name='person10" . $x . "' /></td><td><input type='text' name='pubdate" . $x . "' /></td><td><input type='text' name='link" . $x . "' /></td><td><input type='text' name='website" . $x . "' /></td><td><input type='text' name='status" . $x . "' /></td></tr>";
							
					}
						
					echo '</table>';
    				}
   				
   				$first = true;
   				
   				// Delete rows
   				while($row = $result->fetch_assoc()) 
   				{	
    					
						
    					if (in_array($row["id"], $deleteRows)) // Delete row
    					{
						if($first)
						{
							echo '<table>
						
							<thead>
								<tr>
									<th scope="col">Paper</th>
									<th scope="col">Title</th>
									<th scope="col">Subtitle</th>
									<th scope="col">Person 1</th>
									<th scope="col">Person 2</th>
									<th scope="col">Person 3</th>
									<th scope="col">Person 4</th>
									<th scope="col">Person 5</th>
									<th scope="col">Person 6</th>
									<th scope="col">Person 7</th>
									<th scope="col">Person 8</th>
									<th scope="col">Person 9</th>
									<th scope="col">Person 10</th>
									<th scope="col">Publication Date</th>
									<th scope="col">Link</th>
									<th scope="col">Website</th>
									<th scope="col">Status</th>
								</tr>
							</thead>';
							
							echo "<p>The row(s) displayed below will be deleted</p>";
							$first = false;
						}
						
						echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";

    					}	
  				}
  				
  				if(!$first)
  				{
  					echo '</table>';
    					
    					foreach($_POST["delete"] as $check) 
   					{
           					echo '<div id="hiddenform" style="visibility: hidden;" >			
						<p><input name="delete' . $check . '" value="yes" /></p>
						</div>';
  					}
  				}
  				
  				mysqli_data_seek($result, 0);
  				while($row = $result->fetch_assoc()) 
   				{	
    					if ((in_array($row["id"], $modifyRows)) && !(in_array($row["id"], $deleteRows))) // Modify row USE $ _ POST ["variable . $row["id"]] and  $ _ POST ["value . $row["id"]] and $ _ POST ["apply . $row["id"]]
    					{	
    						
    						echo '<table>
						
						<thead>
							<tr>
								<th scope="col">Paper</th>
								<th scope="col">Title</th>
								<th scope="col">Subtitle</th>
								<th scope="col">Person 1</th>
								<th scope="col">Person 2</th>
								<th scope="col">Person 3</th>
								<th scope="col">Person 4</th>
								<th scope="col">Person 5</th>
								<th scope="col">Person 6</th>
								<th scope="col">Person 7</th>
								<th scope="col">Person 8</th>
								<th scope="col">Person 9</th>
								<th scope="col">Person 10</th>
								<th scope="col">Publication Date</th>
								<th scope="col">Link</th>
								<th scope="col">Website</th>
								<th scope="col">Status</th>
							</tr>
						</thead>';
						
						echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
						echo '</table>';
    						
    						echo '<p>Which variable do you want to modify for row ' . $row["id"] . '?</p>';
							echo '<select name="variable' . $row["id"] . '">
							<option value="paper">Paper Name</option>
							<option value="title">Title</option>
							<option value="subtitle">Subtitle</option>
							<option value="person1">Person 1</option>
							<option value="person2">Person 2</option>
							<option value="person3">Person 3</option>
							<option value="person4">Person 4</option>
							<option value="person5">Person 5</option>
							<option value="person6">Person 6</option>
							<option value="person7">Person 7</option>
							<option value="person8">Person 8</option>
							<option value="person9">Person 9</option>
							<option value="person10">Person 10</option>
							<option value="pubdate">Paper Publication Date</option>
							<option value="link">Paper Link</option>
							<option value="website">Project Site</option>
							<option value="status">Status</option>
							</select>';
    						
    						echo '<p>Enter the new value for the column in row ' . $row["id"] . '</p>';
    							echo '<input type="text" name="value' . $row["id"] . '" />';
    							
    						echo '<p>Would you like the change for row ' . $row["id"] . ' applied to all rows with the same value in this column?';
    							echo '<input type="radio" name="apply'  . $row["id"] . '" value="no" checked="checked" />No<input type="radio" name="apply'  . $row["id"] . '" value="yes" />Yes</p>';
    						
    					}
  				}

			} 
			else 
			{
  				echo "0 results";
			}

			$conn->close();
		?>
		
		
		<br><br><input type="submit" value="Submit">
		
		</form>
	</body>
</html>