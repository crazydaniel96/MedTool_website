<?php
    session_start();
	include ('Server.php');
    /*$Surname = mysqli_real_escape_string($connect,$_POST[Surname]);
    $Name = mysqli_real_escape_string($connect,$_POST[Name]);
    $BookingDate = mysqli_real_escape_string($connect,$_POST[BookingDate]);
    $visit_hour = mysqli_real_escape_string($connect,$_POST[visit_hour]);
    $Phone = mysqli_real_escape_string($connect,$_POST[Phone]);
    $DayBorn = mysqli_real_escape_string($connect,$_POST[DayBorn]);
    $CityBorn = mysqli_real_escape_string($connect,$_POST[CityBorn]);
    $CityNow = mysqli_real_escape_string($connect,$_POST[CityNow]);
    $Address = mysqli_real_escape_string($connect,$_POST[Address]);
    $MoreInfo = mysqli_real_escape_string($connect,$_POST[MoreInfo]);*/   //better prepared statements
    

    if ($stmt = $connect->prepare('INSERT INTO bookings (Surname, Name, Visit_Date, Visit_hour, Phone, DayBorn, CityBorn, CityNow, Address, Notes) values (?,?,?,?,?,?,?,?,?,?)')) {

        // Bind parameters (s = string, i = int, b = blob, etc)
        $stmt->bind_param('ssssssssss', $_POST['Surname'],$_POST['Name'],$_POST['BookingDate'],$_POST['visit_hour'],$_POST['Phone'],$_POST['DayBorn'],$_POST['CityBorn'],$_POST['CityNow'],$_POST['Address'],$_POST['MoreInfo']);
        
        if($stmt->execute()){

            //update calendar date with booked value
            $sql =("UPDATE calendar SET booked=1 WHERE Day='" . $_POST['BookingDate'] ." " . $_POST['visit_hour'] . " ' AND booked=0");
            if ($result = $connect->query($sql)){
                if (isset($_SESSION['loggedin'])) {
                    
                    echo "<script>alert('Prenotazione effettuata correttamente');
                    window.location.href='/AddVisit.php';  
                    </script>"; //in teoria va solo online, localhost non prende come hostname studioROB che quindi viene sostituito
                }
                else {
                    echo "<script>alert('Prenotazione effettuata correttamente');
                    window.location.href='/index.php';  
                    </script>";
                }
            }
            else{
                if (isset($_SESSION['loggedin'])) {
                    
                    echo "<script>alert('Errore');
                    window.location.href='/AddVisit.php';  
                    </script>"; //in teoria va solo online, localhost non prende come hostname studioROB che quindi viene sostituito
                }
                else {
                    echo "<script>alert('Errore');
                    window.location.href='/index.php';  
                    </script>";
                }
            }
        }else{
            if (isset($_SESSION['loggedin'])) {
                
                echo "<script>alert('Errore');
                window.location.href='/AddVisit.php';  
                </script>";
            }
            else{
                echo "<script>alert('Errore');
                window.location.href='/index.php';  
                </script>";
            }
        }

        
        $stmt->close();

    }
?>