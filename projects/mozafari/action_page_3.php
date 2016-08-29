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
			
			$sql = "SELECT * FROM complete";
			$result = mysqli_query($conn, $sql) or die('error');
			
			$_SESSION["numChanges"] = 0;
			$_SESSION["changeCol"] = array(); // column
			$_SESSION["changeFrom"] = array(); // row value
			$_SESSION["changeTo"] = array();

			if ($result->num_rows > 0) 
			{
   				// output data of each row
   				
   				if ($_SESSION["addNum"] > 0) // New Rows
    				{
    					for($x = 1; $x <= $_SESSION["addNum"]; $x++)
    					{
    						$_SESSION["paper" . $x] = $_POST["paper" . $x];
						$_SESSION["title" . $x] = $_POST["title" . $x];
						$_SESSION["subtitle" . $x] = $_POST["subtitle" . $x];
						$_SESSION["person1" . $x] = $_POST["person1" . $x];
						$_SESSION["person2" . $x] = $_POST["person2" . $x];
						$_SESSION["person3" . $x] = $_POST["person3" . $x];
						$_SESSION["person4" . $x] = $_POST["person4" . $x];
						$_SESSION["person5" . $x] = $_POST["person5" . $x];
						$_SESSION["person6" . $x] = $_POST["person6" . $x];
						$_SESSION["person7" . $x] = $_POST["person7" . $x];
						$_SESSION["person8" . $x] = $_POST["person8" . $x];
						$_SESSION["person9" . $x] = $_POST["person9" . $x];
						$_SESSION["person10" . $x] = $_POST["person10" . $x];
						$_SESSION["pubdate" . $x] = $_POST["pubdate" . $x];
						$_SESSION["link" . $x] = $_POST["link" . $x];
						$_SESSION["website" . $x] = $_POST["website" . $x];
						$_SESSION["status" . $x] = $_POST["status" . $x];
    					}
    				}
   				
   				while($row = $result->fetch_assoc()) 
   				{	
    					if ($_POST["delete" . $row["id"]] == "yes")
    					{
    						//echo "Delete row " . $row["id"] . "<br>";
    						$_SESSION["delete" . $row["id"]] = "delete";
    						
    					}
    					else if ($_POST["variable" . $row["id"]] != "")
    					{
    						//echo "Modify row " . $row["id"] . "<br>";
    						$_SESSION["variable" . $row["id"]] = $_POST["variable" . $row["id"]];
    						$_SESSION["value" . $row["id"]] = $_POST["value" . $row["id"]];
    						if ($_POST["apply" . $row["id"]] == "yes")
    						{
    							$_SESSION["numChanges"]++;
    							array_push($_SESSION["changeCol"], $_SESSION["variable" . $row["id"]]);
    							array_push($_SESSION["changeFrom"], $row[$_SESSION["variable" . $row["id"]]]);
    							array_push($_SESSION["changeTo"], $_SESSION["value" . $row["id"]]);
    						}
    					}
    					else
    					{
    						// Nothing
    					}
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			

			$conn->close();
		?>
		
		<form action="action_page_4.php" method="post">
		
		<h3>Preview of the Reformatted Database</h3>
		<p>Click the submit button to complete the changes or the cancel button to return to the main page.</p>
		
		<input type="submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php"><button type="button">Cancel</button></a><br><br>
		
		<table>
		
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
		</thead>
		
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
			$adjust = 0; // Number of shifts for ID

			if ($result->num_rows > 0) 
			{
   				// output data of each row
   				while($row = $result->fetch_assoc()) 
   				{	
    					for ($x = 0; $x < $_SESSION["numChanges"]; $x++)
   					{
           					//echo $row[$_SESSION["changeCol"][$x]];
           					//echo " and "  . $_SESSION["changeFrom"][$x] . "<br>";
           					if($row[$_SESSION["changeCol"][$x]] == $_SESSION["changeFrom"][$x]) // Seeing if change is needed
           					{
           						//echo "yes";
           						//echo $row[$_SESSION["changeCol"][$x]];
           						//echo " and "  . $_SESSION["changeFrom"][$x] . "<br>";
           						$_SESSION["variable" . $row["id"]] = $_SESSION["changeCol"][$x];
           						$_SESSION["value" . $row["id"]] = $_SESSION["changeTo"][$x];
           					}
           					else // Checking if another person has name
           					{
           						//echo $_SESSION["changeCol"][$x];
           						$pos = stripos($_SESSION["changeCol"][$x], "person");
           						if ($pos !== false)
           						{
           							//echo "yes";
           							for($y = 0; $y <= 10; $y++)
           							{
           								if($row["person" . $y] == $_SESSION["changeFrom"][$x]) // Seeing if change is needed
			           					{
			           						//echo $row["id"];
			           						$_SESSION["variable" . $row["id"]] = "person" . $y;
			           						$_SESSION["value" . $row["id"]] = $_SESSION["changeTo"][$x];
			           					}
           							}
           						}
           					}
  					}
    					
    					
    					if ($_SESSION["delete" . $row["id"]] == "delete") // Row removed
    					{
    						$adjust--;
    					}
    					else if ($_SESSION["variable" . $row["id"]] != "") // Modified row
    					{
    						
    						
    						// Checking which variable is modified
    						
    						if ($_SESSION["variable" . $row["id"]] == "paper")
    						{
    							echo "<tr><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "title")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "subtitle")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person1")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person2")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person3")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person4")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person5")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person6")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person7")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person8")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person9")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "person10")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "pubdate")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $_SESSION["value" . $row["id"]] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "link")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else if ($_SESSION["variable" . $row["id"]] == "website")
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td><td>" . $row["status"] . "</td></tr>";
    						}
    						else // Status
    						{
    							echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $_SESSION["value" . $row["id"]] . "</td></tr>";
    						}
    					}
    					else // Regular row
    					{
    						echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
    					}
  				}
  				
  				
  				
  				if ($_SESSION["addNum"] > 0) // New Rows
    				{
    					for($x = 1; $x <= $_SESSION["addNum"]; $x++)
					{
    						echo "<tr><td>" . $_SESSION["paper" . $x] . "</td><td>" . $_SESSION["title" . $x] . "</td><td>" . $_SESSION["subtitle" . $x] . "</td><td>" . $_SESSION["person1" . $x] . "</td><td>" . $_SESSION["person2" . $x] . "</td><td>" . $_SESSION["person3" . $x] . "</td><td>" . $_SESSION["person4" . $x] . "</td><td>" . $_SESSION["person5" . $x] . "</td><td>" . $_SESSION["person6" . $x] . "</td><td>" . $_SESSION["person7" . $x] . "</td><td>" . $_SESSION["person8" . $x] . "</td><td>" . $_SESSION["person9" . $x] . "</td><td>" . $_SESSION["person10" . $x] . "</td><td>" .  $_SESSION["pubdate" . $x] . "</td><td>" . $_SESSION["link" . $x] . "</td><td>" . $_SESSION["website" . $x] . "</td><td>" . $_SESSION["status" . $x] . "</td></tr>";
    					}
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			
			$conn->close();
		?>
		
		</table></form><br><br>
		
	</body>
</html>