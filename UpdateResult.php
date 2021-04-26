<?php

	include ('Server.php');
	
	$sql = "UPDATE bookings SET Result='$_POST[result]' WHERE id='$_POST[id]';";
	if (!mysqli_multi_query($connect, $sql)) {
		echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}
	$firstname = mysqli_real_escape_string($connect, $_POST['NameF']);
	$lastname = mysqli_real_escape_string($connect, $_POST['SurnameF']);
	$body = mysqli_real_escape_string($connect, $_POST['body']);
	if (isset($_POST['body']))
		$sql = "INSERT INTO history(Name,Surname,Date,Category,Report) VALUES ('$firstname','$lastname',CURDATE(),'".$_POST['Category']."','".$body."')";
	else
		$sql = "INSERT INTO history(Name,Surname,Date,Category,Report) VALUES ('$firstname','$lastname',CURDATE(),'','')";
	if (!mysqli_multi_query($connect, $sql)) {
		echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$connect->close();
?>