<?php
	date_default_timezone_set('Africa/Casablanca');
	include 'dbH.inc.php';
	include 'comments.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	
	$cid = $_POST['cid'];
	$message = $_POST['message'];

	echo "<form method='POST' action='".replyComments($conn)."'>
		<input type='hidden' name='cid' value='".$cid."'>
		<textarea readonly>".$message."</textarea>
		<textarea name='replyMessage'></textarea><br>
		<button type='submit' name='replySubmit'>Reply</button>
	</form>";

?>


</body>
</html>
