<?php

	  include ('Server.php');
    if ($_POST['Category']=="Nuova categoria")
      $category=$_POST['NewCat'];
    else
      $category=$_POST['Category'];
    
    if(isset($_POST["Modify"])) 
      $sql="UPDATE reports SET Category='".$category."',Title='".$_POST['Title']."',Body='".$_POST['Body']."',header='".$_POST['Header']."' WHERE id='".$_POST["Report_ID"]."'";
    else if(isset($_POST["Delete"])) 
      $sql="DELETE FROM reports WHERE id='$_POST[Report_ID]'";
    else
      $sql="INSERT INTO reports (Category,Title,Body,header) VALUES ('".$category."','".$_POST['Title']."','".$_POST['Body']."','".$_POST['Header']."')";

    if (!mysqli_multi_query($connect, $sql)) {
      echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 

    mysqli_close($connect);
    if(isset($_POST["Report_ID"]))
      header('Location: editReports.php');
    else
      header('Location: addReport.php');
?>