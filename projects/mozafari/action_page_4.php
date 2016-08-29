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
		
		
		<?php
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
			
			$select = "SELECT * FROM complete";
			$result = mysqli_query($conn, $select) or die('error');


			if ($result->num_rows > 0) 
			{
   				
   				
				//echo $_SESSION['numRows'];
				

   				$curr = 1;
   				
   				while($row = $result->fetch_assoc()) 
   				{	
    					if ($_SESSION["delete" . $row["id"]] == "delete")
    					{
    						//echo "Delete row " . $row["id"] . "<br>";
    						$sql = "DELETE FROM complete WHERE id=" . $row["id"] . ""; // row delete query
    						if ($conn->query($sql) === TRUE) 
	    					{
	    						//echo "Row deleted successfully<br>";
	    						
	    						for ($i = ($row["id"]+1); $i <= $_SESSION['numRows']; $i++) // decrement row ids from deleted row
							{
								$inc = "UPDATE complete
									SET id = " . ($i - 1) . "
									WHERE id = " . ($i) . "";
									if ($conn->query($inc) === TRUE) 
									{
									   // echo "Successfully shifted upward<br>";
									} 
									else 
									{
									    echo "Error: " . $inc . "<br>" . $conn->error;
									}
							}
							$_SESSION['numRows']--;
	    					}
						else 
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
    					}
    					else if ($_SESSION["variable" . $row["id"]] != "") // updating value
    					{
    						//echo "Modify row " . $row["id"] . "<br>";
    						$inc = "UPDATE complete SET " . $_SESSION['variable' . $row['id']] . " = '" . $_SESSION['value' . $row['id']] . "' WHERE id =" . $row['id'];
						if ($conn->query($inc) === TRUE)
						{
							//echo "Successfully updated row<br>";
						} 
						else 
						{
							echo "Error: " . $inc . "<br>" . $conn->error;
						}
    					}
    					else
    					{
    						// Nothing
    					}
  				}
  				if ($_SESSION["addNum"] > 0) // New Rows
    				{
    						
    					for($x = 1; $x <= $_SESSION["addNum"]; $x++)
					{
	    					$sql = "INSERT INTO complete VALUES(" . ($x + $_SESSION["numRows"]) . ", '" . $_SESSION["paper" . $x] . "', '" . $_SESSION["title" . $x] . "', '" . $_SESSION["subtitle" . $x] . "', '" . $_SESSION["person1" . $x] . "', '" . $_SESSION["person2" . $x] . "', '" . $_SESSION["person3" . $x] . "', '" . $_SESSION["person4" . $x] . "', '" . $_SESSION["person5" . $x] . "', '" . $_SESSION["person6" . $x] . "', '" . $_SESSION["person7" . $x] . "', '" . $_SESSION["person8" . $x] . "', '" . $_SESSION["person9" . $x] . "', '" . $_SESSION["person10" . $x] . "', '" . $_SESSION["pubdate" . $x] . "', '" . $_SESSION["link" . $x] . "', '" . $_SESSION["website" . $x] . "', '" . $_SESSION["status" . $x] . "')"; // query for row at new spot
	    					if ($conn->query($sql) === TRUE) 
	    					{
	    						//echo "New record created successfully adding " . ($x + $_SESSION["numRows"]) . "<br>";
	    					}
						else 
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
	
	    				}
	    			}
			} 
			else 
			{
  				echo "0 results";
			}
			

			$conn->close();
		?>
		
		<form action="action_page.php" method="post">
			
			
		
		<br><p>Changes made successfully!</p>
		
		<h3>Here is the Reformatted Database</h3>
		<p>Choose to make another change to the database or logout and return to the main page.</p>
		
		<input type="submit" value="Make Another Change">&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php"><button type="button">Logout</button></a><br><br>
		
		<table>
		
		<thead>
			<tr>
				<th scope-"col">ID</th>
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
		</thead>
		
		<!-- Displays the adjusted database -->
		
		<?php
			$servername = "localhost";
			$username = "ab78123_viewer";
			$password = "mozafari";
			$db = "ab78123_mydatabase";
			// Create connection
			$conn = new mysqli($servername, $username, $password, $db);
	
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
	
			
			$sql = "SELECT * FROM complete";
			$result = mysqli_query($conn, $sql) or die('error');

			if ($result->num_rows > 0) 
			{
   				// output data of each row
   				while($row = $result->fetch_assoc()) 
   				{	
    					echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			
			$conn->close();
			
			echo '<div id="hiddenform" style="visibility: hidden;" >			
				<input name="username" value=' . $_SESSION["username"] . ' />
				<input name="password" value=' . $_SESSION["password"] . ' />
				</div>';
			
			
			session_unset(); 
		?>
		
		</table>
		
		</form><br><br>
		
	</body>
</html>