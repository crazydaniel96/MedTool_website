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
		<title>Gestione Pazienti</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="shadow"> <!-- controlla -->
		<div class="topnav">
            <button class="tablinks active" onclick="openTab(event,'InProgress')">Visite in Corso</button>
            <button class="tablinks" onclick="openTab(event,'Add')">Crea</button>
            <button class="tablinks" onclick="openTab(event,'Manage')">Gestisci</button>
            <button class="tablinks" onclick="openTab(event,'Stats')">Statistiche</button>
            <a href="logout.php"><button style="float:right;color:white;background-color:#ab251b;"><i class="fa fa-sign-out" aria-hidden="true"></i></button></a>
            <a href="PersonalArea.php"><button style="float:right;color:black;">Utente <i class="fa fa-user" aria-hidden="true"></i></button></a>
        </div>


        <!-- IN PROGRESS -->
        <div id="InProgress" class="tabcontent"  style=display:block>
            <br>

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

            <!-- modal-->
            <div id="SummaryPatientModal" class="modal">

                  <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                      <span class="close">&times;</span>
                      <br>
                      <h2 style="display: inline">Riepilogo [ ID= </h2><h2 id="idPar" style="display: inline"></h2><h2 style="display: inline"> ]</h2><br><br>
                    </div>
                    <div id="modal-body" class="modal-body">
                        <br>
                        <form action="CompileSave.php" method="post" id="FinalAnagraph">
                            <div class="row">
                                <div class="col-25">
                                    <label for="Name">Nome</label>
                                    <input type="text" id="NameF" name="NameF" placeholder="inserire il nome" class="fieldText">
                                    <label for="AddressF"> Indirizzo</label>
                                    <input type="text" id="AddressF" name="AddressF" placeholder="inserire via e numero" class="fieldText">
                                </div>
                                <div class="col-25">
                                    <label for="SurnameF"> Cognome</label>
                                    <input type="text" id="SurnameF" name="SurnameF" placeholder="inserire il cognome" class="fieldText">
                                    <label for="CityNowF">Residenza</label>
                                    <input type="text" id="CityNowF" name="CityNowF" placeholder="città" class="fieldText">
                                </div>
                                <div class="col-25">
                                    <label for="CityBornF">Luogo di nascita</label>
                                    <input type="text" id="CityBornF" name="CityBornF" placeholder="città" class="fieldText">
                                </div>
                                <div class="col-25">
                                    <label for="DayBornF">Giorno di nascita</label>
                                    <input type="date" id="DayBornF" name="DayBornF" class="fieldText">
                                </div>
                            </div>

                            <label for="MoreInfoF"><i class="fa fa-sticky-note-o"></i> Note del paziente</label>
                            <input type="text" id="MoreInfoF" name="MoreInfoF" placeholder="Nessuna nota aggiunta dal paziente" class="otherInfo">

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
        </div>

        <!-- ADD -->
        <div class="tabcontent" id="Add">
            <div class="container">
                <br>
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
                            <select name="visit_hour" id="visit_hour" class="fieldText" required>
                            <option disabled selected value> -- seleziona prima il giorno -- </option>
                            </select>
                        </div>
                    </div>
                    <label for="MoreInfo"><i class="fa fa-sticky-note-o"></i> Note aggiuntive</label>
                    <input type="text" id="MoreInfo" name="MoreInfo" placeholder="Se necessario, specificare qui le informazioni aggiuntive" class="otherInfo">
                    <input type="submit" value="Inserisci visita" class="btn">
                </form>
            </div>        
        </div>



        <!-- MANAGE -->
        <div id="Manage" class="tabcontent">
            <div class="container">
                <h3> Modifica appuntamenti </h3>
                <div class="row">
                    <div class="col-75">
                        <form action='edit.php' method='post'>
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
                        <form action="edit.php" method='post' id='DateToModifyForm'>
                            <div class="row">
                                <div class="col-30">
                                    <input type="date" name="DateToModify" class="fieldText">
                                </div>
                                <div class="col-20">
                                    <input type="submit" class="btn" value="Modifica" style="margin: 0px auto 10px">
                                </div>
                                <div class="col-25">
                                </div>
                            </div>
                        </form>
                    </div>
                     
                    <div class="col-25" style="text-align: center;">
                        <a onclick="OpenAgenda()" id="agenda" style="text-decoration: none; color: #3274d6; cursor: pointer;display: inline-block;text-align: center; border: 1px solid; padding: 10px"><i class="fa fa-book fa-5x" aria-hidden="true"></i></a>  
                    </div>
                </div>                    
                <hr>
                <h3> Modifica turnazione </h3>
                <div class="row">
                    <div class="col-30">
                        <input type="date" id="NewBookingDate" name="NewBookingDate" style="display: inline" class="fieldText">
                    </div>
                    <div class="col-25" style="display:flex; flex-direction: row; justify-content: center; align-items: center">
                        <label for="fromHour">da:&nbsp; </label>
                        <input type="time" id="fromHour" name="fromHour" class="fieldText" step="1800">
                    </div>
                    <div class="col-25" style="display:flex; flex-direction: row; justify-content: center; align-items: center">
                        <label for="toHour">a:&nbsp; </label>
                        <input type="time" id="toHour" name="toHour" class="fieldText" step="1800">
                    </div>
                    <div class="col-20">
                        <button class="btn" onclick="AddBookingDate()" style="margin: 0px auto 10px">Aggiungi</button>
                    </div>
                        <!--<a onclick="" style="text-decoration: none; color: #4CAF50; cursor: pointer;"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>-->
                </div>

                <div class="row">
                    <div class="col-30">
                        
                        <input type="date" id="OldBookingDate" name="oldBookingDate" style="display: inline" class="fieldText">
                    </div>
                    <div class="col-20">
                        <button class="btn" onclick="RemoveBookingDate()" style="margin: 0px auto 5px">Rimuovi</button>
                        <!--<a onclick="" style="text-decoration: none; color: #4CAF50; cursor: pointer;position: absolute;top: 35%"><i class="fa fa-minus fa-2x" aria-hidden="true"></i></a>    -->              
                    </div>
                    <div class="col-50">
                    </div>
                </div>

                <hr>

                
            </div>

            <!-- modal-->
            <div id="AgendaModal" class="modal">

                  <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="modal-body">
                        <br>
                        <?php

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
                                echo "<tr><td colspan='5' style='background-color:#272e29;color:#ffffff;'><a href='edit.php?DateToModify=" . $date . "' style='display:block;text-decoration: none;color: white;'>" . date_format($FormattedDate,"d/m/y") . $ITAday[date_format($FormattedDate,"w")] . "</a></td></tr>"; // first date header
                               
                                // output data of each row
                                $result->data_seek(0);  // set the pointer back to the beginning
                                while($row = $result->fetch_assoc()) {
                                    if ($row["Visit_Date"] != $date){
                                        $FormattedDate=date_create($row["Visit_Date"]);
                                        echo "<tr style='background-color: #FFFFFF;'><td colspan='5'</td></tr>";
                                        echo "<tr><td colspan='5' style='background-color:#272e29;color:#ffffff;'><a href='edit.php?DateToModify=" . $row["Visit_Date"] . "' style='display:block;text-decoration: none;color: white;'>" . date_format($FormattedDate,"d/m/y") . $ITAday[date_format($FormattedDate,"w")] . "</a></td></tr>";
                                        $date=$row["Visit_Date"];
                                    }
                                    echo "<tr><td>" . $row["Surname"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Visit_hour"]. "</td><td>" . $row["Phone"]. "</td><td>" . $row["Notes"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "<div style='text-align: center;'><br><hr><br><p>Agenda vuota</p><br><br><hr><br></div>";
                            }

                            $connect->close();
                            ?>

                    </div>
                </div>
            </div>
        </div>


        <!-- STATS -->
        <div id="Stats" class="tabcontent">
            <div class="container">
                <br><br><br>
                <h2 style="text-align: center"><i class="fa fa-code-fork fa-3x"></i>In costruzione <i class="fa fa-code-fork fa-3x"></i></h2>
                <br><br><br>
            </div>
        </div>

        </div>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

                        document.getElementById("idPar").innerHTML = ID_Patient;

                        //insert all patient values into html form by ID matching
                        var i=0;
                        while (CurrPatientInfos[i].id!=ID_Patient) {
                            i++;
                        }

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
        <script type="text/javascript" src="home.js"></script>  
        <script type="text/javascript" src="index.js"></script>  
	</body>
</html>