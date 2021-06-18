<?php
    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
    	header('Location: loginForm.php');
    	exit;
    }
?>


<!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- bootstrap libraries -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- for jquery calendar -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- customized libraries -->
        <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <script src="scripts/sidebar.js"></script>
  

        <!-- calendar jquery script -->
        <script>
            days=[
                <?php 
                    include ('Server.php');
                    $sql = "SELECT Day FROM calendar WHERE booked=0 AND Day>=CURDATE()"; 
                    $result = $connect->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "'".$row["Day"]."',";
                        }
                    }
                ?>
            ];
            jQuery(function(){

                var enableDays = [];
                days.forEach(function (item, index) {
                    if (!enableDays.includes(item.split(" ")[0])){
                        enableDays.push(item.split(" ")[0]);
                    }
                });

                function enableAllTheseDays(date) {
                    var sdate = $.datepicker.formatDate( 'yy-mm-dd', date)
                    if($.inArray(sdate, enableDays) != -1) {
                        return [true];
                    }
                    return [false];
                }

                $('#BookingDate').datepicker({dateFormat: 'yy-mm-dd', beforeShowDay: enableAllTheseDays});
            })

            function DateChanger(object){
                var select = document.getElementById("visit_hour");
                select.options.length = 0;
                var day=object.value;
                var hours={};
                days.forEach(function (item, index) {
                    if (day==item.split(" ")[0])
                        hours[item.split(" ")[1]]=item.split(" ")[1];
                });
                
                for(index in hours) {
                    select.options[select.options.length] = new Option(hours[index], index);
                }
            } 
        </script>
	</head>
	<body>

    <!-- SIDEBAR -->
    
    <?php
        if ($_SESSION['restricted'])
            include('common/reduced_sidebar.php');
        else
            include('common/sidebar.php');
    ?>

    <div class="page-content">
        <div class='container'>
            <!-- FIND A PERSON -->
            <form action='FindPerson.php' method='post'>
                <div class="row">
                    <div class="col-40">
                        <input type="text" id="NameSearch" name="NameSearch" placeholder="Nome" class="fieldText" required>
                    </div>
                    <div class="col-40">
                        <input type="text" id="SurnameSearch" name="SurnameSearch" placeholder="Cognome" class="fieldText" required>
                    </div>
                    <div class="col-20">
                        <input type="submit" value="Cerca" class="btn" style="margin: 0px auto 10px">
                    </div>
                </div>
            </form>
        </div>

        <!-- HIDE PART, NOT SHOWN IF NO DATA PASSED -->
        <?php

			if ( isset($_POST['NameSearch']) ){
                
                $firstname = mysqli_real_escape_string($connect, $_POST['NameSearch']);
                $lastname = mysqli_real_escape_string($connect, $_POST['SurnameSearch']);

				$sql = "SELECT * FROM bookings WHERE Name='$firstname' AND Surname='$lastname' AND Visit_Date>=CURDATE() AND Result IS NULL";
			
                $result = $connect->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <div class='container'>
                            <br>
                            <form action='Modify-delete.php' method='post'>
                                <div class='row'>
                                    <div class='col-25'>
                                        <label for='Name'>Nome</label>
                                        <input type='text' id='Name' name='Name' class='fieldText' value=\"" . $row["Name"]. "\">
                                        <label for='Address'> Indirizzo</label>
                                        <input type='text' id='Address' name='Address' placeholder='inserire via e numero' class='fieldText' value=\"" . $row["Address"]. "\">
                                        <label for='visit_hour'>Orario Visita</label>  
                                        <select name='visit_hour' id='visit_hour' class='fieldText' value='" . $row["Visit_hour"]. "'>
                                        <option selected value> ". $row["Visit_hour"]." </option>
                                        </select>
                                    </div>
                                    <div class='col-25'>
                                        <label for='Surname'> Cognome</label>
                                        <input type='text' id='Surname' name='Surname' class='fieldText' value=\"" . $row["Surname"]. "\">
                                        <label for='CityNow'>Residenza</label>
                                        <input type='text' id='CityNow' name='CityNow' placeholder='città' class='fieldText' value=\"" . $row["CityNow"]. "\">
                                        <label for='id'>ID</label>
                                        <input type='text' id='id' name='id' class='fieldText' value='" . $row["id"]. "' readonly>
                                    </div>
                                    <div class='col-25'>
                                        <label for='CityBorn'>Luogo di nascita</label>
                                        <input type='text' id='CityBorn' name='CityBorn' placeholder='città' class='fieldText' value=\"" . $row["CityBorn"]. "\">
                                        <label for='Phone'> Telefono</label>
                                        <input type='text' id='Phone' name='Phone' placeholder='numero di telefono' class='fieldText' value='" . $row["Phone"]. "'>
                                    </div>
                                    <div class='col-25'>
                                        <label for='DayBorn'>Giorno di nascita</label>
                                        <input type='date' id='DayBorn' name='DayBorn' class='fieldText' value='" . $row["DayBorn"]. "'>
                                        <label for='BookingDate'> Giorni disponibili</label>
                                        <input type='text' id='BookingDate' name='BookingDate' class='fieldText' value='" . $row["Visit_Date"]. "' onchange='DateChanger(this)'>
                                        <input type='hidden' name='OldBookingDate' class='fieldText' value='" . $row["Visit_Date"]." ". $row["Visit_hour"]."' onchange='DateChanger(this)'>
                                    </div>

                                </div>
                                <div style='text-align:center'>
                                    <input type='submit' name='Modify' class='btn' value='Modifica' style='display: inline; margin: 0px 20px 0px 20px;'>
                                    <input type='submit' name='Delete' class='btn' value='Elimina' style='display: inline; margin: 0px 20px 0px 20px;'>
                                </div>
                            </form>
                        </div>
                        <br><br>
                        ";
                    }
                } else {
                    echo "<br><div style='text-align: center;'><p>Nessun risultato </p></div>";
                }
			    $connect->close(); 
            }
		?>

    </div>

    

  </body>
</html>