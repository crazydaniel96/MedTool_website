<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
      header('Location: loginForm.php');
      exit;
    }
	  include ('Server.php');

    $sql="UPDATE accounts SET username='".$_POST['Username']."',restricted=".$_POST['AccountType']." WHERE id='".$_SESSION['id']."';";
    
    if ($_POST['OldPW']!="" && $_POST['NewPW']!=""){
      $sql2="SELECT password FROM accounts WHERE id='".$_SESSION['id']."'";
      $result = $connect->query($sql2);
      $pwd=$result->fetch_assoc();
      if (password_verify($_POST['OldPW'], $pwd["password"])){

        $sql.="UPDATE accounts SET password='". password_hash($_POST['NewPW'], PASSWORD_DEFAULT) ."' WHERE id='".$_SESSION['id']."';";
      }
      else
      {
        mysqli_close($connect);
        die(header("HTTP/1.0 404 Not Found"));
      }
    }

    if (!mysqli_multi_query($connect, $sql)) {
        #echo "<script> window.alert(" . mysqli_error($connect) . ")</script>";
        mysqli_close($connect);
        die(header("HTTP/1.0 404 Not Found"));
    }
    if($_POST['AccountType']=="false")
      $_SESSION['restricted']=0;
    else 
      $_SESSION['restricted']=1;

    mysqli_close($connect);
    echo "success";
    
?>