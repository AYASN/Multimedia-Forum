<?php
	date_default_timezone_set('Europe/Paris');
	include 'dbH.inc.php';
	include 'comments.inc.php';
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
		if (!isset($_SESSION['id'])) {
			echo "<form method='POST' action='".getLogin($conn)."'>
			<input type='text' name='uid'>
			<input type='password' name='pwd'>
			<button type='submit' name='loginSubmit'>Login</button>
			</form>"; }
		else {
			echo "<form method='POST' action='".userLogout()."'>
			<button type='submit' name='logoutSubmit'>Log out</button>
			</form>";
		}

		if (isset($_SESSION['id'])) {
			echo "You're already logged in !";
		} else {
			echo "<form action='signUp.php'>
			<button type='submit' name='signUp'>SIGN UP</button>
			</form>";
		}
?>

<br><br>

<object data="http://www.youtube.com/embed/qVU3V0A05k8"
   width="560" height="315"></object>

<br><br>

<?php
	if (isset($_SESSION['id'])) {
		echo "<form method='POST' action='".setComments($conn)."'>
			<input type='hidden' name='uid' value='".$_SESSION['id']."'>
			<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
			<textarea name='message'></textarea><br>
			<button type='submit' name='commentSubmit'>Comment</button>
        </form>";
	} else {
		echo "You need to be logged in to comment!
		<br><br>";
	}

getComments($conn);

?>
</body>
</html>