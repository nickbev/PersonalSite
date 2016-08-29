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
			width: 100%; 
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
		<p>This page contains multiple tables of information concerning the projects and partners of Professor Barzan Mozafari.</p><br><br>
		
		<a href="login.php"><button type="button">Login to Database to Make Changes</button></a><br><br>
		
		<h2>Projects</h2>
		
		<table>
		
		<thead>
			<tr>
				<th scope="col">Title</th>
				<th scope="col">Subtitle</th>
				<th scope="col">People</th>
				<th scope="col">Website</th>
				<th scope="col">State</th>
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

			if ($result->num_rows > 0) 
			{
   				$prevRow = "";
				
   				while($row = $result->fetch_assoc()) 
   				{	
					if ($prevRow != $row["title"]) // Row with new project
					{
						if ($row["website"] != "")
						{
							echo "<tr><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td><a href='" . $row["website"] . "'>Link</a></td><td>" . $row["status"] . "</td></tr>";
						}
						else
						{
							echo "<tr><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>N/A</td><td>" . $row["status"] . "</td></tr>";
						}
						$names = array($row["person1"]); // Adds 
						$count = 2; // Index of person to start with
						$prevRow = $row["title"];
					}
					else // Row with same project
					{
						$count = 1;
					}
					while($row["person" . $count] != "") // While there is a name in row
					{
						if ( ! in_array($row["person" . $count], $names)) // Name is not in array
						{
							echo "<tr><td></td><td></td><td>" . $row["person" . $count] . "</td><td></td><td></td></tr>"; // Adds new row below with person
							array_push($names, $row["person" . $count]);
						}
						$count = $count + 1;
					}
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			
			$conn->close();
		?>
		
		</table><br><br>
		
		
		
		
		
		<h2>People</h2>
		
		<table>
		
		<thead>
			<tr>
				<th scope="col">Person</th>
				<th scope="col">Projects of Involvement</th>
				<th scope="col">Papers of Involvement</th>
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

			if ($result->num_rows > 0) 
			{
   				$names = array(); // Array of every unique name
   				// output data of each row
   				$rowNum = 1; // Current row of outer loop
   				while($row = $result->fetch_assoc()) 
   				{	
    					$count = 1; // Number of person in row
    					while($row["person" . $count] != "") // While someone on the row
    					{
    						if ( ! in_array($row["person" . $count], $names)) // Name is not in array
						{
							// Outputs name and data of involvement
							echo "<tr><td>" . $row["person" . $count] . "</td><td>" . $row["title"] . "</td><td>" . $row["paper"] . "</td></tr>";
							$current = $row["person" . $count];
							$projects = array($row["title"]);
							$sql2 = "SELECT * FROM complete";
							$result2 = mysqli_query($conn, $sql2) or die('error'); // New connection for inner loop
							
							for ($i = 0; $i < $rowNum; $i++) // Setting row below current to traverse
							{
								$row2 = $result2->fetch_assoc();
							}
							while($row2 = $result2->fetch_assoc()) // While there are rows after current
							{
								$count2 = 1;
								while($row2["person" . $count2] != "") // While second row has people
								{
									if ($row2["person" . $count2] == $current) // Name is in row
									{
										if (in_array($row2["title"], $projects))
										{
											echo "<tr><td></td><td></td><td>" . $row2["paper"] . "</td></tr>";
										}
										else
										{
											echo "<tr><td></td><td>" . $row2["title"] . "</td><td>" . $row2["paper"] . "</td></tr>";
											array_push($projects, $row2["title"]); // Adds project to array
										}
									}
									$count2++;
								}
							}
							
							array_push($names, $current); // Adds name to array
						}
						$count = $count + 1;
    					}
    					
    					
  				$rowNum = $rowNum + 1;
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			
			$conn->close();
		?>
		
		</table><br><br>
		
		
		
		
		
		<h2>Papers</h2>
		
		<table>
		
		<thead>
			<tr>
				<th scope="col">Paper Title</th>
				<th scope="col">Project of Origin</th>
				<th scope="col">People</th>
				<th scope="col">Publication Date</th>
				<th scope="col">Website</th>
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

			if ($result->num_rows > 0) 
			{
   				while($row = $result->fetch_assoc()) 
   				{	
					if ($row["paper"] != "No Paper")
					{
						echo "<tr><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["pubdate"] . "</td><td><a href='" . $row["link"] . "'>Link</a></td></tr>";
					
						$count = 2;
					
						while($row["person" . $count] != "") // While there is a name in row
						{
							echo "<tr><td></td><td></td><td>" . $row["person" . $count] . "</td><td></td><td></td></tr>";
							$count = $count + 1;
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
		
		</table>
		
		
		
	</body>
</html>