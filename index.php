<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<title>Studio d'Arenzo</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        
        <!-- for jquery calendar -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<link href="styles/public-page.css" rel="stylesheet" type="text/css">
        <link href="styles/in-progress.css" rel="stylesheet" type="text/css">
        


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
        <div class="shadow">
            <div class="topnav">
                <button class="tablinks active" onclick="openTab(event,'home')">Prenotazioni</button>
                <button class="tablinks" onclick="openTab(event,'about')">Info</button>
                <button class="tablinks" onclick="openTab(event,'maps')">Posizione</button>
                <a href="loginForm.php" style="text-decoration: none;color: black;"><button style="float:right;background-color:#ccc;" class="PrivateAreaBtn1"> Area Privata <i class="fa fa-lock"></i></button></a>
                <a href="loginForm.php" style="text-decoration: none;color: black;"><button style="float:right;background-color:#ccc;" class="PrivateAreaBtn2"><i class="fa fa-lock"></i></button></a>
                
            </div>

            <!-- HOME -->
            <div class="tabcontent" id="home" style=display:block>
                <div class="container">
                    <br>
                    <!-- form Prenotazione Visita -->
                    <form action='AddBooking.php' method='post' onsubmit="return confirm('Inviare prenotazione?');">
                        <div class="row">
                            <div class="col-50">
                                <label for="Name"><i class="fa fa-user"></i>Nome*</label>
                                <input type="text" id="Name" name="Name" placeholder="inserire il nome" class="fieldText" required>
                            </div>
                            <div class="col-50">
                                <label for="Surname"><i class="fa fa-user"></i> Cognome*</label>
                                <input type="text" id="Surname" name="Surname" placeholder="inserire il cognome" class="fieldText" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-50">
                                <label for="Phone"><i class="fa fa-phone"></i> Telefono/Cellulare*</label>
                                <input type="text" id="Phone" name="Phone" placeholder="inserire numero di telefono" class="fieldText" required>
                            </div>
                            <div class="col-50">
                                <label for="DayBorn"><i class="fa fa-calendar"></i> Giorno di nascita**</label>
                                <input type="date" id="DayBorn" name="DayBorn" class="fieldText">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-50">
                                <label for="CityBorn"><i class="fa fa-map-marker"></i> Luogo di nascita**</label>
                                <input type="text" id="CityBorn" name="CityBorn" placeholder="città" class="fieldText">
                            </div>
                            <div class="col-50">
                                <label for="CityNow"><i class="fa fa-map-marker"></i> Residenza**</label>
                                <input type="text" id="CityNow" name="CityNow" placeholder="città" class="fieldText">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-50">
                                <label for="Address"><i class="fa fa-home"></i> Indirizzo**</label>
                                <input type="text" id="Address" name="Address" placeholder="inserire via e numero" class="fieldText">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-50">
                                <label for="BookingDate"><i class="fa fa-calendar"></i> Giorni disponibili*</label>
                                <input type="text" id="BookingDate" name="BookingDate" class="fieldText" onchange="DateChanger(this)" placeholder="clicca per visualizzare le date" required readonly>
                            </div>  
                            <div class="col-50">
                                <label for="visit_hour"><i class="fa fa-clock-o"></i> Orario Visita*</label>  
                                <select name="visit_hour" id="visit_hour" class="fieldText" required>
                                <option disabled selected value> -- seleziona prima il giorno -- </option>
                                </select>
                            </div>
                        </div>
                        <label for="MoreInfo"><i class="fa fa-sticky-note-o"></i> Note aggiuntive</label>
                        <textarea rows="3" id="MoreInfo" name="MoreInfo" placeholder="Se necessario, specificare qui le informazioni aggiuntive" class="fieldText" style="resize: none;"></textarea>
                        <!--<input type="text" id="MoreInfo" name="MoreInfo" placeholder="Se necessario, specificare qui le informazioni aggiuntive" class="otherInfo"> -->
                        <input type="submit" value="Prenota la visita" class="btn">
                        <small>* Campo obbligatorio.<br>** Compilare tali campi per velocizzare la refertazione finale.</small>
                    </form>
                </div>        
            </div>


            <!-- ABOUT -->
            <div id="about" class="tabcontent">
                <div class="container">
                    <br>
                    <div class="fieldText"> Numero di telefono: <b>3791169602</b> </div>
                    <div class="fieldText">Metodi di pagamento accettati  <i class="fa fa-credit-card fa-2x"></i> <i class="fa fa-money fa-2x"></i> </div>
                    <small>In caso di inattività del numero è possibile prentare una visita attraverso la sezione "prenotazioni" in alto a sinistra.<br>In caso di problemi, telefonare tempestivamente per disdire.</small>
                </div>
            </div>
            <!-- MAPS -->
            <div id="maps" class="tabcontent">
                <div class="iframe-container">   
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d744.8517323811963!2d15.375951942356911!3d41.69015027026108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x133742e99fabf9b9%3A0x177484de9fc58b2e!2sVia%20Giuseppe%20de%20Cesare%2C%20107%2C%2071016%20San%20Severo%20FG!5e0!3m2!1sit!2sit!4v1596563118327!5m2!1sit!2sit" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>

            <!-- modal-->
            <div id="AdviseModal" class="modal" style="display: block;">

                <!-- Modal content -->
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <br><br>
                        <span class="close">&times;</span>
                        <br>
                    </div>
                    <div id="modal-body" class="modal-body">
                        <br>
                        <h2> Per infilitrazioni, controllo esami, o altre informazioni, contattare il numero </h2><br>
                        <h1 style="text-align: center">3791169602</h1>
                        <br>
                    </div>
                </div>
            </div>

        </div>
        <script type="text/javascript" src="scripts/index.js"></script>
    </body>
</html>

