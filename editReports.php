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
                    
                    <li  data-toggle="collapse" data-target="#products" class="collapsed">
                        <a href="#"><i class="fa fa-gift fa-lg"></i> Gestione Visite <span class="arrow"></span></a>
                    </li>
                    <ul class="sub-menu collapse" id="products">
                        <a href="AddVisit.php"><li>Aggiungi Visita</li></a>
                        <a href="AddVisitFree.php"><li>Aggiungi Visita - Libero</li></a>
                    </ul>


                    <li data-toggle="collapse" data-target="#service" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="service">
                        <a href="FindPerson.php"><li>Cerca Persona</li></a>
                        <a href="FindDay.php"><li>Cerca Giorno</li></a>
                        <a href="agenda.php"><li>Agenda</li></a>
                    </ul>

                    <li data-toggle="collapse" data-target="#days" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="days">
                        <a href="workingDays.php"><li>Aggiungi/Rimuovi giorni</li></a>
                        <a href="#"><li>Sposta giorno</li></a>
                    </ul>

                    <li data-toggle="collapse" data-target="#reports" class="active">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Referti <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse in" id="reports">
                        <a href="#"><li class="active">Modifica referto</li></a>
                        <a href="addReport.php"><li>Aggiungi referto</li></a>
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
        

      </div>
    </div>

  </body>
</html>