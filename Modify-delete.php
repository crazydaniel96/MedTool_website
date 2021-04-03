<?php

    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }
    include ('Server.php');
    if(isset($_POST["Modify"])) {
        $sql = "UPDATE bookings SET Surname=\"$_POST[Surname]\",Name=\"$_POST[Name]\",Visit_Date='$_POST[BookingDate]',Visit_hour='$_POST[visit_hour]',Phone='$_POST[Phone]',DayBorn='$_POST[DayBorn]',CityBorn=\"$_POST[CityBorn]\",CityNow=\"$_POST[CityNow]\",Address=\"$_POST[Address]\" WHERE id='$_POST[id]'";
        $sql .="; UPDATE calendar SET booked=0 WHERE Day='" . $_POST['OldBookingDate'] ."'";
        $sql .="; UPDATE calendar SET booked=1 WHERE Day='" . $_POST['BookingDate'] ." " . $_POST['visit_hour'] . " '";
    }
    else if(isset($_POST["Delete"])) {
        $sql = "DELETE FROM bookings WHERE id='$_POST[id]'";
        $sql .="; UPDATE calendar SET booked='0' WHERE Day='" . $_POST['OldBookingDate'] ."'";
    }

    if (!mysqli_multi_query($connect, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 
    else{   
        $connect->close();

        if ( !isset($_POST['FromDate']) ){
            echo "<script type=\"text/javascript\"> 
                        window.onload=function(){
                            document.forms['personBackform'].submit();
                        }
            </script>";
        }
        else {
            echo "<script type=\"text/javascript\"> 
                        window.onload=function(){
                            document.forms['dayBackform'].submit();
                        }
            </script>";
        }

    }
?>

<form action="FindPerson.php"  method="post" id="personBackform">
<input type="hidden" name="NameSearch" value="<?=$_POST['Name'];?>" />
<input type="hidden" name="SurnameSearch" value="<?=$_POST['Surname'];?>" />
</form>

<form action="FindDay.php"  method="post" id="dayBackform">
<input type="hidden" name="DateToModify" value="<?=$_POST['FromDate'];?>" />
</form>