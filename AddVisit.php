<?php
    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
    	header('Location: index.php');
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
        <script type="text/javascript" src="scripts/AddVisit.js"></script> 
        <script src="scripts/sidebar.js"></script>
        
        <!-- calendar jquery script -->
        <script>
            days=[
                <?php 
                    include ('Server.php');
                    $sql = "SELECT Day FROM calendar WHERE booked=0 AND private=0 AND Day>=CURDATE()"; 
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
        if ($_SESSION['name']=="ritaderrico")
            include('common/reduced_sidebar.php');
        else
            include('common/sidebar.php');
    ?>

    <div class="page-content">
        <div class='container'>
            <!-- ADD -->
            <!-- form Prenotazione Visita -->
            <form action='AddBooking.php' method='post' onsubmit="return confirm('Inviare prenotazione?');">
                <div class="row">
                    <div class="col-50">
                        <label for="Name"><i class="fa fa-user"></i> <b>Nome</b></label>
                        <input type="text" id="Name" name="Name" placeholder="inserire il nome" class="fieldText" required>
                    </div>
                    <div class="col-50">
                        <label for="Surname"><i class="fa fa-user"></i> <b>Cognome</b></label>
                        <input type="text" id="Surname" name="Surname" placeholder="inserire il cognome" class="fieldText" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-50">
                        <label for="Phone"><i class="fa fa-phone"></i> <b>Telefono/Cellulare</b></label>
                        <input type="text" id="Phone" name="Phone" placeholder="inserire numero di telefono" class="fieldText" required>
                    </div>
                    <div class="col-50">
                        <label for="DayBorn"><i class="fa fa-calendar"></i> Giorno di nascita</label>
                        <input type="date" id="DayBorn" name="DayBorn" class="fieldText">
                    </div>
                </div>
                <div class="row">
                    <div class="col-50">
                        <label for="CityBorn"><i class="fa fa-map-marker"></i> Luogo di nascita</label>
                        <input type="text" id="CityBorn" name="CityBorn" placeholder="città" class="fieldText">
                    </div>
                    <div class="col-50">
                        <label for="CityNow"><i class="fa fa-map-marker"></i> Residenza</label>
                        <input type="text" id="CityNow" name="CityNow" placeholder="città" class="fieldText">
                    </div>
                </div>
                <div class="row">
                    <div class="col-50">
                        <label for="Address"><i class="fa fa-home"></i> Indirizzo</label>
                        <input type="text" id="Address" name="Address" placeholder="inserire via e numero" class="fieldText">
                    </div>
                </div>
                <div class="row">
                    <div class="col-50">
                        <label for="BookingDate"><i class="fa fa-calendar"></i> Giorni disponibili</label>
                        <input type="text" id="BookingDate" name="BookingDate" class="fieldText" onchange="DateChanger(this)" placeholder="clicca per visualizzare le date" required readonly>
                    </div>  
                    <div class="col-50">
                        <label for="visit_hour"><i class="fa fa-clock-o"></i> <b>Orario Visita</b></label>  
                        <select name="visit_hour" id="visit_hour" class="fieldText" required>
                        <option disabled selected value> -- seleziona prima il giorno -- </option>
                        </select>
                    </div>
                </div>
                <label for="MoreInfo"><i class="fa fa-sticky-note-o"></i> Note aggiuntive</label>
                <textarea rows="3" id="MoreInfo" name="MoreInfo" placeholder="Se necessario, specificare qui le informazioni aggiuntive" class="fieldText" style="resize: none;"></textarea>
                <input type="submit" value="Inserisci visita" class="btn">
            </form>
        </div>
    </div>

  </body>
</html>