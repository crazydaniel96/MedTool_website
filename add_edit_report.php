<?php

	  include ('Server.php');
    if ($_POST['Category']=="Nuova categoria")
      $category=$_POST['NewCat'];
    else
      $category=$_POST['Category'];
    
    $sql="INSERT INTO reports (Category,Title,Body,header) VALUES ('".$category."','".$_POST['Title']."','".$_POST['Body']."','".$_POST['Header']."')";

    if (!mysqli_multi_query($connect, $sql)) {
      echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 

    mysqli_close($connect);
    header('Location: addReport.php');
?>