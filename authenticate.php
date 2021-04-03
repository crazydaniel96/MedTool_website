<?php
	session_start();

	include ('Server.php');
	if ( mysqli_connect_errno() ) {
		// If there is an error with the connection, stop the script and display the error.
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $connect->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password);
			$stmt->fetch();
			// Account exists, now we verify the password.
			// Note: remember to use password_hash in your registration file to store the hashed passwords.
			if (password_verify($_POST['password'], $password)) {
				// Verification success! User has loggedin!
				// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				header('Location: TodayVisits.php');
			} else {
				echo "<script>alert('Username o password errati');</script>";
				echo "<script>window.location = 'loginForm.php';</script>";
			}
		} else {
			echo "<script>alert('Username o password errati');</script>";
			echo "<script>window.location = 'loginForm.php';</script>";
		}

		$stmt->close();
	}
?>
