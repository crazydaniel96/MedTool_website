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

        <!-- customized libraries -->
		    <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <link href="styles/in-progress.css" rel="stylesheet" type="text/css">
  
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


                    <li data-toggle="collapse" data-target="#service" class="active">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse in" id="service">
                        <a href="FindPerson.php"><li>Cerca Persona</li></a>
                        <a href="FindDay.php"><li>Cerca Giorno</li></a>
                        <a href="#"><li class="active">Agenda</li></a>
                    </ul>

                    <li data-toggle="collapse" data-target="#days" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="days">
                        <a href="workingDays.php"><li>Aggiungi/Rimuovi giorni</li></a>
                        <a href="#"><li>Sposta giorno</li></a>
                    </ul>

                    <li data-toggle="collapse" data-target="#reports" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Referti <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="reports">
                        <a href="editReports.php"><li>Modifica referto</li></a>
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

      <?php
        include ('Server.php');
        $sql = "SELECT Surname, Name, Visit_Date, Notes, Phone, Visit_hour FROM bookings WHERE Visit_Date>=CURDATE() ORDER BY Visit_Date,Visit_hour";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $date=$result->fetch_assoc()["Visit_Date"]; //first date 
            //set week days in italian
            $ITAday=[
                "0"=>" - Domenica",
                "1"=>" - Lunedì",
                "2"=>" - Martedì",
                "3"=>" - Mercoledì",
                "4"=>" - Giovedì",
                "5"=>" - Venerdì",
                "6"=>" - Sabato",
            ];
            //prepare table
            echo "<table id='AgendaLabel'>";

            $FormattedDate=date_create($date);
            echo "<tr><td colspan='5' style='background-color:#272e29;color:#ffffff;'><a href='FindDay.php?DateToModify=" . $date . "' style='display:block;text-decoration: none;color: white;'>" . date_format($FormattedDate,"d/m/y") . $ITAday[date_format($FormattedDate,"w")] . "</a></td></tr>"; // first date header
          
            // output data of each row
            $result->data_seek(0);  // set the pointer back to the beginning
            while($row = $result->fetch_assoc()) {
                if ($row["Visit_Date"] != $date){
                    $FormattedDate=date_create($row["Visit_Date"]);
                    echo "<tr style='background-color: #FFFFFF;'><td colspan='5'</td></tr>";
                    echo "<tr><td colspan='5' style='background-color:#272e29;color:#ffffff;'><a href='FindDay.php?DateToModify=" . $row["Visit_Date"] . "' style='display:block;text-decoration: none;color: white;'>" . date_format($FormattedDate,"d/m/y") . $ITAday[date_format($FormattedDate,"w")] . "</a></td></tr>";
                    $date=$row["Visit_Date"];
                }
                echo "<tr><td>" . $row["Surname"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Visit_hour"]. "</td><td>" . $row["Phone"]. "</td><td style='max-width:120px'>" . $row["Notes"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<div style='text-align: center;'><br><hr><br><p>Agenda vuota</p><br><br><hr><br></div>";
        }

        $connect->close();
      ?>

    </div>

  </body>
</html>