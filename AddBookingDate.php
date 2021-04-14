<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: loginForm.php');
        exit;
    }
	include ('Server.php');
    
    $sql="";
    $start=$_POST['time_from'];
    $end=$_POST['time_to'];
    $date=$_POST['date'];

    while ($start<=$end){
        $sql .= "INSERT INTO calendar (Day,name,VisitSpan,private) VALUES ('".$date ." ". $start."','".$_POST['name']."','".$_POST['hour']."','".$_POST['show']."');";
        $start=date('H:i:s',strtotime($_POST['hour'],strtotime($start)));
    }
    
    if (!mysqli_multi_query($connect, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 

    mysqli_close($connect);
    header('Location: workingDays.php');
?>