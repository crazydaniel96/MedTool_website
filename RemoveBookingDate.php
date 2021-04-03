<?php

	include ('Server.php');

    $sql="DELETE FROM calendar WHERE Day='". $_POST['date'] ."'";

    if (!mysqli_multi_query($connect, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 

    mysqli_close($connect);
    header('Location: workingDays.php');
?>