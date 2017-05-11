<?php
	include 'dbH.inc.php';
	session_start();

	$first = $_POST['first'];
	$last = $_POST['last'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	if (empty($first) || empty($last) || empty($uid) || empty($pwd)) {
		header("Location: signUp.php?error=empty");
		exit();
	}

	else {
		$sql = "SELECT uid FROM users WHERE uid = '$uid'";
		$result = mysqli_query($conn, $sql);
		$uidCheck = mysqli_num_rows($result);
		if ($uidCheck > 0) {
			header("Location: signUp.php?error=username");
			exit();
		}
		else {
			// $encryptedPwd = password_hash($pwd, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users (first, last, uid, pwd)
			VALUES ('$first', '$last', '$uid', '$pwd')";
			$result = mysqli_query($conn, $sql);

			header("Location: index.php");
		}
	}