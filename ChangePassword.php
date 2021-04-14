<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
      header('Location: loginForm.php');
      exit;
    }
	  include ('Server.php');
    $sql="SELECT password FROM accounts WHERE id='".$_SESSION['id']."'";
    $result = $connect->query($sql);
    $pwd=$result->fetch_assoc();
    if (password_verify($_POST['OldPW'], $pwd["password"])){

      $sql="UPDATE accounts SET password='". password_hash($_POST['NewPW'], PASSWORD_DEFAULT) ."' WHERE id='".$_SESSION['id']."'";

      if (!mysqli_multi_query($connect, $sql)) {
          echo "Error: " . $sql . "<br>" . mysqli_error($connect);
      } 
      mysqli_close($connect);
      echo "success";
    }
    else {
      mysqli_close($connect);
      die(header("HTTP/1.0 404 Not Found"));
    }
?>