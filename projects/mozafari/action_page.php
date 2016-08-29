<?php
@ob_start();
session_start();
?>

<?php
	foreach($_SESSION as $key=>$value) 
	{
    		if(($key != 'username') && ($key != 'password')) 
    		{
       			unset($_SESSION[$key]);
    		}
	}
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
			$set = false;
			$servername = "localhost";
			if($_SESSION['username'] != "")
			{
				$username = "ab78123_" . $_SESSION["username"];
				$password = $_SESSION["password"];
				$set = true;
			}
			else
			{
				
				$username = "ab78123_" . $_POST["username"];
				$password = $_POST["password"];
			}
			$db = "ab78123_mydatabase";
			// Create connection
			@$conn = new mysqli($servername, $username, $password, $db);
	
			// Check connection
			if ($conn->connect_error) {
			    echo '<form action="action_page.php" method="post">
				<p>Username: <input type="text" name="username" /></p>
				<p>Password: <input type="password" name="password" /></p>
				<input type="submit" value="Submit">
			    </form>';
			    die("Invalid username/password. Please try again.");
			}
			else
			{
				if($set == false)
				{
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['password'] = $_POST['password'];
				}
			}

			$conn->close();
		?>
		
		<a href="index.php"><button type="button">Logout</button></a>
		
		<form action="action_page_2.php" method="post">
		
		<h3>Check the rows you would like to modify or remove. To add one or more rows, check the box and enter the number of rows you wish to add.</h3>
		<p>If multiple checkboxes are selected for the same row, only the first selection will be applied.</p>
		
		<input type="submit" value="Continue">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="add" value="yes">Add Row(s)&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name="addNum" value=1><br><br>
		
		<table>
		
		<thead>
			<tr>
				<th scope-"col">Delete</th>
				<th scope-"col">Modify</th>
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
			$count = 0;

			if ($result->num_rows > 0) 
			{
   				// output data of each row
   				while($row = $result->fetch_assoc()) 
   				{	
    					echo '<tr><td>' . '<input type="checkbox" name="delete[]" value="' . $row["id"] . '">' . "</td><td>" . '<input type="checkbox" name="modify[]" value="' . $row["id"] . '">' . "</td><td>" . $row["paper"] . "</td><td>" . $row["title"] . "</td><td>" . $row["subtitle"] . "</td><td>" . $row["person1"] . "</td><td>" . $row["person2"] . "</td><td>" . $row["person3"] . "</td><td>" . $row["person4"] . "</td><td>" . $row["person5"] . "</td><td>" . $row["person6"] . "</td><td>" . $row["person7"] . "</td><td>" . $row["person8"] . "</td><td>" . $row["person9"] . "</td><td>" . $row["person10"] . "</td><td>" .  $row["pubdate"] . "</td><td>" . $row["link"] . "</td><td>" . $row["website"] . "</td><td>" . $row["status"] . "</td></tr>";
					$count++;
  				}
			} 
			else 
			{
  				echo "0 results";
			}
			
			$_SESSION['numRows'] = $count; 
			$conn->close();
		?>
		
		</table></form><br><br>
		
	</body>
</html>