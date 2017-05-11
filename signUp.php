<?php
	// include 'headerLogin.php';
?>

<?php

	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if (strpos($url, 'error=empty') !== false) {
		echo "Fill out all fields !";
	}
	elseif (strpos($url, 'error=username') !== false) {
		echo "Username already exists !";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<body>
<?php
	// if (isset($_SESSION['id'])) {
	// 	echo "You're already logged in !";
	// } else {
		echo "<form action='signUp.inc.php' method='post'>
		<input type='text' name='first' placeholder='First name'><br>
		<input type='text' name='last' placeholder='Last name'><br>
		<input type='text' name='uid' placeholder='User name'><br>
		<input type='password' name='pwd' placeholder='Password'><br>
		<button type='submit'>SIGN UP</button>
	</form>";
	
?>

</body>
</html>