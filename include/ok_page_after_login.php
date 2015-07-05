<?php


	include 'session.class.php';	
	$ses = new initiate_session();	
?>

<html>
<body>
	<p>You have successfully logged in, and redirected to this page</p>
	<form action="process_logout.php">
	<input type="submit" value="LOGOUT">
	</form>
</body>
</html>
