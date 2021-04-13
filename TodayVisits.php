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
        <link href="styles/in-progress.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        
	</head>
	<body>
    
        <!-- SIDEBAR -->

        <div class="nav-side-menu">
            <div class="brand">Studio d'Arenzo (beta)</div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                <div class="menu-list">

                    <ul id="menu-content" class="menu-content collapse out">
                        <li class="active">
                            <a href="#">
                            <i class="fa fa-dashboard fa-lg"></i> Visite in corso
                            </a>
                        </li>

                        <li  data-toggle="collapse" data-target="#products" class="collapsed">
                            <a href="#"><i class="fa fa-gift fa-lg"></i> Gestione Visite <span class="arrow"></span></a>
                        </li>
                        <ul class="sub-menu collapse" id="products">
                            <a href="AddVisit.php"><li>Aggiungi Visita</li></a>
                            <a href="AddVisitFree.php"><li>Aggiungi Visita - Libero</li></a>
                        </ul>

                        <li data-toggle="collapse" data-target="#service" class="collapsed">
                            <a href="#">
                                <i class="fa fa-globe fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span>
                            </a>
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
            <div class='container'>
                <!-- TABLE -->
                <?php
                    include ('Server.php');

                    $sql = "SELECT id, Surname, Name, Phone, DayBorn, CityBorn, CityNow, Address, Visit_hour, Notes FROM bookings WHERE Visit_Date=CURDATE() AND Result IS NULL ORDER BY Visit_hour"; 
                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table id='InProgressTable'><thead><tr><th>Cognome</th><th>Nome</th><th>Ora Visita</th></tr></thead><tbody>";
                        // output data of each row
                        $JSarray=array();
                        while($row = $result->fetch_assoc()) {
                            echo "<tr id='" . $row["id"]. "'><td>" . $row["Surname"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Visit_hour"]. "</td></tr>";
                            $JSarray[]=$row;
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<p style='text-align: center; display:block;'>Nessun Paziente</p><br><br>";
                    }
                ?>

            </div>
        </div>

    <!-- modal-->
    <div id="SummaryPatientModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
            <h2 id="NameLabel" style="display: inline"></h2><h2>&nbsp;[ID=</h2><h2 id="idPar" style="display: inline"></h2><h2>]</h2><br><br>
                <span class="close">&times;</span>
                <br>
            </div>
            <div id="modal-body" class="modal-body">
                <br>
                <form action="CompileSave.php" method="post" id="FinalAnagraph">
                    <div class="row">
                        <div class="col-25">
                            <label for="Name">Nome</label>
                            <input type="text" id="NameF" name="NameF" placeholder="inserire il nome" class="fieldText" required>
                            <label for="AddressF"> Indirizzo</label>
                            <input type="text" id="AddressF" name="AddressF" placeholder="inserire via e numero" class="fieldText" required>
                        </div>
                        <div class="col-25">
                            <label for="SurnameF"> Cognome</label>
                            <input type="text" id="SurnameF" name="SurnameF" placeholder="inserire il cognome" class="fieldText" required>
                            <label for="CityNowF">Residenza</label>
                            <input type="text" id="CityNowF" name="CityNowF" placeholder="città" class="fieldText" required>
                        </div>
                        <div class="col-25">
                            <label for="CityBornF">Luogo di nascita</label>
                            <input type="text" id="CityBornF" name="CityBornF" placeholder="città" class="fieldText" required>
                        </div>
                        <div class="col-25">
                            <label for="DayBornF">Giorno di nascita</label>
                            <input type="date" id="DayBornF" name="DayBornF" class="fieldText" required>
                        </div>
                    </div>

                    <label for="MoreInfoF"><i class="fa fa-sticky-note-o"></i> Note del paziente</label>
                    <textarea rows="3" id="MoreInfoF" name="MoreInfoF" placeholder="Nessuna nota aggiunta dal paziente" class="fieldText" style="resize: none;"></textarea>
                    <!--<input type="text" id="MoreInfoF" name="MoreInfoF" placeholder="Nessuna nota aggiunta dal paziente" class="otherInfo">-->

                    <div class="row">
                        <div class="col-50">

                            <?php
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
                            <select name="Category" id="Category" class="fieldText" onchange="ReportChanger()" required>
                                <option disabled selected value> seleziona base </option>
                            </select>
                            <script>
                                var Categories = <?php print(json_encode($Categories)); ?>; 
                                select = document.getElementById("Category");
                                for(index in Categories) {
                                    select.options[select.options.length] = new Option(Categories[index].Category, Categories[index].Category);
                                }
                            </script>
                        </div>

                        <div class="col-50">
                            <label for="Title">Referto</label>
                            <select name="Title" id="Title" class="fieldText" required>
                                <option disabled selected value> ---- </option>
                            </select>
                        </div> 
                    </div>
                </form>
                <!-- modal's buttons --> 
                <div style="text-align:center">
                    <input type="submit" value="Referto" form="FinalAnagraph" class="btn" style="display: inline">
                    <button id="EndVisit" class="btn" style="display: inline-block; margin: 0px 20px 0px 20px">Fine visita</button>
                    <button id="Absent" class="btn" style="display: inline">Assente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- manual scripts -->
    <script>
        $(document).ready(function() {

            $('#InProgressTable tr').click(function() {
                var ID_Patient = $(this).attr("id");
                if(ID_Patient) {
                    var CurrPatientInfos = <?php if(isset($JSarray)) print(json_encode($JSarray)); else print(0); ?>; 

                    //reset red color for empty fields of modal body
                    var elements=document.getElementById("modal-body").getElementsByClassName("fieldText");
                    for (i = 0, len = elements.length; i < len; i++) {
                        elements[i].style.border= "1px solid #ccc";
                    }

                    //insert all patient values into html form by ID matching
                    var i=0;
                    while (CurrPatientInfos[i].id!=ID_Patient) {
                        i++;
                    }
                    document.getElementById("NameLabel").innerHTML ="Riepilogo " + CurrPatientInfos[i].Surname +" " + CurrPatientInfos[i].Name;
                    document.getElementById("idPar").innerHTML = ID_Patient;

                    document.getElementById("NameF").value = CurrPatientInfos[i].Name;
                    if (CurrPatientInfos[i].Name=="")
                        document.getElementById("NameF").style.border="2px solid red";
                    document.getElementById("AddressF").value = CurrPatientInfos[i].Address;
                    if (CurrPatientInfos[i].Address=="")
                        document.getElementById("AddressF").style.border="2px solid red";
                    document.getElementById("SurnameF").value = CurrPatientInfos[i].Surname;
                    if (CurrPatientInfos[i].Surname=="")
                        document.getElementById("SurnameF").style.border="2px solid red";
                    document.getElementById("CityNowF").value = CurrPatientInfos[i].CityNow;
                    if (CurrPatientInfos[i].CityNow=="")
                        document.getElementById("CityNowF").style.border="2px solid red";
                    document.getElementById("CityBornF").value = CurrPatientInfos[i].CityBorn;
                    if (CurrPatientInfos[i].CityBorn=="")
                        document.getElementById("CityBornF").style.border="2px solid red";
                    document.getElementById("DayBornF").value = CurrPatientInfos[i].DayBorn;
                    if (CurrPatientInfos[i].DayBorn=="0000-00-00")
                        document.getElementById("DayBornF").style.border="2px solid red";
                    document.getElementById("MoreInfoF").value = CurrPatientInfos[i].Notes;

                    //show modal content
                    document.getElementById("SummaryPatientModal").style.display = "block";
                }
            });

            $('#EndVisit').click(function(){
                var conf=confirm("confermare fine visita");
                if (conf==true){
                    $.ajax({
                        type: "POST",
                        url: "UpdateResult.php",
                        data: "result=Success&id="+document.getElementById("idPar").innerHTML, //no interaction with following line 
                        success: function(){
                            var row=document.getElementById(document.getElementById("idPar").innerHTML);
                            row.parentNode.removeChild(row);
                            document.getElementById("SummaryPatientModal").style.display = "none";
                        }
                
                    })
                }
            });

            $('#Absent').click(function(){
                var conf=confirm("confermare assenza");
                if (conf==true){
                    $.ajax({
                        type: "POST",
                        url: "UpdateResult.php",
                        data: "result=Absent&id="+document.getElementById("idPar").innerHTML,
                        success: function(){
                            var row=document.getElementById(document.getElementById("idPar").innerHTML);
                            row.parentNode.removeChild(row);
                            document.getElementById("SummaryPatientModal").style.display = "none";
                        }
                    })
                }
            });

        });

        function ReportChanger(){
            var select = document.getElementById("Title");
            select.options.length = 0;
            var Title_array = <?php print(json_encode($optionReport)); ?>; 
            var Category=document.getElementById("Category").value;
            var select = document.getElementById("Title");

            for(index in Title_array) {
                if (Title_array[index].Category==Category){
                    select.options[select.options.length] = new Option(Title_array[index].Title, Title_array[index].Title);
                }
            }
        }
    </script>
    <script type="text/javascript" src="scripts/TodayVisits.js"></script> 
    </body>
</html>