<?php

	include ('Server.php');
	$sql = "UPDATE bookings SET Result='$_POST[result]' WHERE id='$_POST[id]'";

	if(!mysqli_query($connect,$sql)) {
        die('Error: ' . mysqli_error($connect));
    }

	$connect->close();
?>