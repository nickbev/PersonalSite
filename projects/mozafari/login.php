<?php
@ob_start();
session_start();
?>
<!DOCTYPE html>
<?php
	if($_SESSION['username'] != "")
	{
 		 echo "<meta http-equiv='refresh' content='0;action_page.php' />";
	} 
?>
<html>
	<head>
		<title>Professor Barzan Mozafari</title>
		<style type="text/css">
		</style>
		<link href="CSS style.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<h1>Professor Barzan Mozafari</h1>
		<p>Enter username and password to edit this database.</p><br><br>
		
		<form action="action_page.php" method="post">
			<p>Username: <input type="text" name="username" /></p>
			<p>Password: <input type="password" name="password" /></p>
			<input type="submit" value="Submit">
		</form>
		
	</body>
</html>