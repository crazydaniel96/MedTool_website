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

        <!-- customized libraries -->
		    <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="scripts/AddVisit.js"></script>  
	</head>
	<body>

    <!-- SIDEBAR -->

    <div class="nav-side-menu">
        <div class="brand">Studio d'Arenzo (beta)</div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

            <div class="menu-list">

                <ul id="menu-content" class="menu-content collapse out">
                    <a href="TodayVisits.php">
                      <li>
                        <i class="fa fa-dashboard fa-lg"></i> Visite in corso
                      </li>
                    </a>
                    
                    <li  data-toggle="collapse" data-target="#products" class="active">
                        <a href="#"><i class="fa fa-gift fa-lg"></i> Gestione Visite <span class="arrow"></span></a>
                    </li>
                    <ul class="sub-menu collapse in" id="products">
                        <a href="AddVisit.php"><li>Aggiungi Visita</li></a>
                        <a href="#"><li class="active">Aggiungi Visita - Libero</li></a>
                    </ul>


                    <li data-toggle="collapse" data-target="#service" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="service">
                        <a href="FindPerson.php"><li>Cerca Persona</li></a>
                        <a href="AddDay.php"><li>Cerca Giorno</li></a>
                        <a href="agenda.php"><li>Agenda</li></a>
                    </ul>

                    <li data-toggle="collapse" data-target="#days" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="days">
                        <a href="workingDays.php"><li class="active">Aggiungi/Rimuovi giorni</li></a>
                        <a href="#"><li>Sposta giorno</li></a>
                    </ul>

                    <a href="stats.php">
                      <li>  
                        <i class="fa fa-user fa-lg"></i> Statistiche
                      </li>
                    </a>

                </ul>
        </div>
    </div>

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
                        <label for="BookingDate"><i class="fa fa-calendar"></i> <b>Giorno visita</b></label>
                        <input type="date" id="BookingDate" name="BookingDate" class="fieldText" onchange="DateChanger()"required>
                    </div>  
                    <div class="col-50">
                        <label for="visit_hour"><i class="fa fa-clock-o"></i> <b>Orario Visita</b></label>  
                        <input type="time" id="visit_hour" class="fieldText" name="visit_hour" min="07:00" max="20:00" required>
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