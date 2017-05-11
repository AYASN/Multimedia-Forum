<?php

function setComments($conn) {
	if (isset($_POST['commentSubmit'])) {
		$uid = mysqli_real_escape_string($conn, $_POST['uid']);
		$date = mysqli_real_escape_string($conn, $_POST['date']);
		$message = mysqli_real_escape_string($conn, $_POST['message']);

		$sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')";
		$result = mysqli_query($conn, $sql);
	}
}

function getComments($conn) {
	$sql = "SELECT * FROM comments";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$cid = $row['cid'];
		$id = $row['uid'];
		$sql2 = "SELECT  * FROM users WHERE id='$id'";
		$result2 = mysqli_query($conn, $sql2);
		if ($row2 = mysqli_fetch_assoc($result2)) {
			echo "<div class = 'comment-box'><p>";
			echo $row2['uid']."<br>";
			echo $row['date']."<br>";
			echo nl2br($row['message']);
			echo "</p>";
			if (isset($_SESSION['id'])) {
				if ($_SESSION['id'] == $row2['id']) {
					echo "<form class='delete-form' method='POST' action='".deleteComments($conn)."'>
						<input type='hidden' name='cid' value='".$row['cid']."'>
						<button type='submit' name='commentDelete'>Delete</button>
					</form>
					<form class='edit-form' method='POST' action='editComment.php'>
						<input type='hidden' name='cid' value='".$row['cid']."'>
						<input type='hidden' name='uid' value='".$row['uid']."'>
						<input type='hidden' name='date' value='".$row['date']."'>
						<input type='hidden' name='message' value='".$row['message']."'>
						<button>Edit</button>
					</form>";
				} else {
					echo "<form class='edit-form' method='POST' action='replyComment.php'>
						<input type='hidden' name='cid' value='".$row['cid']."'>
						<input type='hidden' name='message' value='".$row['message']."'>
						<button type='submit' name='commentDelete'>Reply</button>
					</form>";
					// echo "<form method='POST' action='".showReplies($conn)."'>
					// 	<input type='hidden' name='cid' value='".$row['cid']."'>
					// 	<button type='submit' name='showReplies'>Show reply</button>
					// </form>";
					}
				$sqlReply = "SELECT * FROM replies WHERE cid='$cid'";
				$resultReply = mysqli_query($conn, $sqlReply);
				while ($rowReply = mysqli_fetch_assoc($resultReply)) {
					echo "<p class='replies-form'>".nl2br($rowReply['content'])."</p><br>";			
				}

			} else {
				echo "<p class='commentmessage'>You need to be logged in to reply!</p>";
			}
		//show replies of current cid
		echo "</div>";
		}
	}
}

function editComments($conn) {
	if (isset($_POST['commentSubmit'])) {
		$cid = $_POST['cid'];
		$uid = $_POST['uid'];
		$date = $_POST['date'];
		$message = $_POST['message'];

		$sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
		$result = mysqli_query($conn, $sql);
		header("Location: index.php");
	}
}

function deleteComments($conn) {
	//There is a problem with this if statement in isset() -
	// résolu, pb is forgot one ' in submit
	if (isset($_POST['commentDelete'])) {
		$cid = $_POST['cid'];

		$sql = "DELETE FROM comments WHERE cid='$cid'";
		$result = mysqli_query($conn, $sql);

		header("Location: index.php");	
	}
}

function replyComments($conn) {
	if (isset($_POST['replySubmit'])) {
		$cid = $_POST['cid'];
		$replyMessage = $_POST['replyMessage'];

		$sql = "INSERT INTO replies (cid, content) VALUES ('$cid', '$replyMessage')";
		$result = mysqli_query($conn, $sql);

		header("Location: index.php");
	}
}

function showReplies($conn) {
	if(isset($_POST['showReplies'])) {
		$cid = $_POST['cid'];

		$sql = "SELECT * FROM replies WHERE cid='$cid'";
		$result = mysqli_query($conn, $sql);

		// if ($result) {
		// 	echo "replies for this comment!";
		// }
		while ($row = mysqli_fetch_assoc($result)) {
			echo nl2br($row['content'])."<br>";			
		}

		header("Location: index.php");		
	}
}

function getLogin($conn) {
	if (isset($_POST['loginSubmit'])) {
		$uid = mysqli_real_escape_string($conn, $_POST['uid']);
		$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

		$stmt = $conn->prepare("SELECT * FROM users WHERE uid=? AND pwd=?");
		$stmt->bind_param("ss", $username, $password);

		// we can execute this part multiple times with same prepared stmt
		// and different (uid, pwd), for ex. logging mutilple users in same time
		$username = $uid;
		$password = $pwd;
		$stmt->execute();

		//$result = mysqli_query($conn, $sql);
		$result = $stmt-> get_result();

		$rowNum = $result->num_rows;

		if ($rowNum > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$_SESSION['id'] = $row['id'];
				$_SESSION['uid'] = $row['uid'];
				header("Location: index.php?loginSuccess");
				exit();
			}
		} else {
				header("Location: index.php?loginFailed");
				exit();
		}
	}
}

function userLogout() {
	if (isset($_POST['logoutSubmit'])) {
		session_start();
		session_destroy();
		header("Location: index.php");
		exit();
	}
}