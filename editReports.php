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
        <script src="scripts/reports.js"></script>
  
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
            <form action='editReports.php' method='post'>
                <div class="row">
                    <div class="col-40">

                        <?php
                            include ('Server.php');
                            $sql = "SELECT Category,Title FROM reports";
                            $result = $connect->query($sql);
                            while($row = $result->fetch_assoc()) {
                                $optionReport[]=$row;
                            }
                            $sql = "SELECT DISTINCT Category FROM reports";
                            $result = $connect->query($sql);
                            while($row = $result->fetch_assoc()) {
                                $Categories[]=$row;
                            }
                        ?>
                        <label for="Category">Categoria</label>
                        <select name="Category" id="Category2" class="fieldText cat" onchange="ReportChanger()" required>
                            <option disabled selected value> seleziona base </option>
                        </select>
                    </div>

                    <div class="col-40">
                        <label for="Title">Referto</label>
                        <select name="Title" id="Title" class="fieldText" required>
                            <option disabled selected value> ---- </option>
                        </select>
                    </div> 
                    <div class="col-20">
                        <input type="submit" value="Cerca" class="btn">
                    </div>
                </div>
            </form>
        </div>

        <!-- HIDE PART, NOT SHOWN IF NO DATA PASSED -->
        <?php

            if ( isset($_POST['Title']) ){

                $sql = "SELECT * FROM reports WHERE Category='".$_POST['Category']."' AND Title='".$_POST['Title']."'";

                $result = $connect->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <br><br>
                        <div class='container'>
                            <br>
                            <form action='add_edit_report.php' method='post'>
                                <div class='row'>
                                    <div class='col-50'>
                                        
                                        <label for='Category'>Categoria</label>
                                        <select name='Category' id='Category' class='fieldText cat' onchange='Manage_New()' required>
                                            <option value='Nuova categoria'>Nuova categoria</option>
                                            <option selected value='".$row['Category']."'>".$row['Category']."</option>
                                        </select>
                                        <input type='text' name='NewCat' id='NewCat' class='fieldText' placeholder='aggiungi nuova categoria' disabled required>

                                    </div>
                                    <div class='col-50'>
                                        <label for='Title'>Nome Referto</label>
                                        <input type='text' value='".$row['Title']."' name='Title' class='fieldText' required>
                                    </div> 
                                </div>
                                <label for='Header'>Intestazione</label>
                                <textarea rows='1' name='Header' class='fieldText' style='resize: none;'>".$row['header']."</textarea>
                                <label for='Body'>Corpo</label>
                                <textarea rows='25' name='Body' class='fieldText' style='resize: none;'>".$row['Body']."</textarea>
                                <div class='row justify-content-center'>
                                    <div class='col-2'>
                                        <input type='submit' value='Modifica Referto' name='Modify' class='btn'>
                                    </div>
                                    <div class='col-2'>
                                        <input type='submit' value='Elimina' name='Delete' class='btn'>
                                    </div>  
                                </div>
                                <input type='hidden' name='Report_ID' value='".$row['id']."'>
                            </form>
                        </div>
                        ";
                    }
                } else {
                    echo "<br><div style='text-align: center;'><p>Nessun risultato </p></div>";
                }
                $connect->close(); 
            }
        ?>

    </div>


    <script>
        function ReportChanger(){
            var select = document.getElementById("Title");
            select.options.length = 0;
            var Title_array = <?php print(json_encode($optionReport)); ?>; 
            var Category=document.getElementById("Category2").value;

            for(index in Title_array) {
                if (Title_array[index].Category==Category){
                    select.options[select.options.length] = new Option(Title_array[index].Title, Title_array[index].Title);
                }
            }
        }

        var Categories = <?php print(json_encode($Categories)); ?>; 
        select = document.getElementsByClassName('cat');
        for (element in select){
            for(index in Categories) {
                select[element].options[select[element].options.length] = new Option(Categories[index].Category, Categories[index].Category);
            }
        }

    </script>
  </body>
</html>