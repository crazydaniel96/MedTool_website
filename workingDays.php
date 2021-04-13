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

        <!-- calendar libraries -->
        <link href='fullcalendar/main.css' rel='stylesheet' />
        <script src='fullcalendar/main.js'></script>
        <script src='fullcalendar/locales/it.js'></script> 
        <script>
        
        var eventi=[<?php
            include ('Server.php');
            $sql = "SELECT Day,name,VisitSpan,booked FROM calendar WHERE Day>=CURDATE()"; 
            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()){
                if ($row["booked"]){
                  echo "
                  {
                    title: '". $row["name"] ."',
                    start: '". $row["Day"] ."',
                    end: '". date('Y-m-d H:i:s',strtotime($row["VisitSpan"],strtotime($row["Day"]))) ."',
                    color: 'red',
                    url: '#',
                    classNames: 'booked'
                  },
                ";
                }
                else{
                  echo "
                    {
                      title: '". $row["name"] ."',
                      start: '". $row["Day"] ."',
                      end: '". date('Y-m-d H:i:s',strtotime($row["VisitSpan"],strtotime($row["Day"]))) ."',
                      url: '#',
                    },
                  ";
                }
              }
            }
            ?>
          ];
        
          document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
              events: eventi,
              initialView: 'timeGridWeek',
              selectable: true,
              allDaySlot: false,
              contentHeight: 'auto',
              weekNumberCalculation: "ISO",
              locale: 'it',
              headerToolbar: 
              {
                start: 'title', 
                center: '',
                end: 'timeGridWeek,dayGridMonth today prev,next',
              },
              slotDuration: '00:30:00',
              slotMinTime: "07:00:00",
              slotMaxTime: "21:00:00",
              slotLabelFormat: { hour: 'numeric', minute: '2-digit', omitZeroMinute: false },
              selectMirror: true,
              selectOverlap: false,
              //click listener
              select: function(info) {
                document.getElementById("time_from").value=info.startStr.split('T')[1].split('+')[0];
                document.getElementById("time_to").value=info.endStr.split('T')[1].split('+')[0]
                document.getElementById("date").value=info.startStr.split('T')[0];
                document.getElementById("AddDateModal").style.display = "block";
              },

              // event click 
              eventClick: function(info) {
                var eventObj = info.event;

                if (eventObj.classNames=="booked") 
                  var y=confirm( "E' presente un paziente prenotato; Gestisci prima la prenotazione.");
                else 
                  var x=confirm( "Eliminare?");
                if (x){
                  var form = document.createElement("form"); form.setAttribute("method", "post"); form.setAttribute("action", "RemoveBookingDate.php");
                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("name", "date");
                  hiddenField.setAttribute("value", eventObj.start.toISOString().split('T')[0]+' '+eventObj.start.toTimeString().split(' ')[0] );
                }
                else if (y){
                  var form = document.createElement("form"); form.setAttribute("method", "post"); form.setAttribute("action", "FindDay.php");
                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("name", "DateToModify");
                  hiddenField.setAttribute("value", eventObj.start.toISOString().split('T')[0]);
                }
                if (x | y){
                  form.setAttribute("target", "view");
                  hiddenField.setAttribute("type", "hidden"); 
                  
                  form.appendChild(hiddenField);
                  document.body.appendChild(form);
                  
                  window.open('', 'view');
                  
                  form.submit();
                }
              },
            });
            calendar.render();
          });
          
        </script>
        <!-- customized libraries -->
		    <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <link href="styles/workingDays.css" rel="stylesheet" type="text/css">
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

                    <li data-toggle="collapse" data-target="#days" class="active">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse in" id="days">
                        <a href="#"><li class="active">Aggiungi/Rimuovi giorni</li></a>
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
    </div>

    <div class="page-content">
      <div class='container'>
        <div id='calendar'></div>

        <!-- modal-->
        <div id="AddDateModal" class="modal">

          <!-- Modal content -->
          <div class="modal-content">
              <div class="modal-header">
                  <h2 style="display: inline">Aggiunta visite</h2><br><br>
                  <span class="close">&times;</span>
                  <br>
              </div>
              <div id="modal-body" class="modal-body">
                  <br>
                  <form action="AddBookingDate.php" method="post" id="addDate">
                    <label for="name">Identificativo evento:</label>
                    <input type="text" name="name" id="name" value="Prime visite" class="form-control">
                    <hr>
                    <div class="row">
                      <div class="col-4">
                        <label for="date" class="col-2 col-form-label" style='display: inline-block;'>Data:</label>
                      </div>
                      <div class="col-8">
                        <input class="form-control" type="date" id="date" name="date">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-2">
                        <label for="time_from" class="col-2 col-form-label" style='display: inline-block;'>Dalle:</label>
                      </div>
                      <div class="col-4">
                        <input class="form-control" type="time" id="time_from" name="time_from">
                      </div>
                      <div class="col-2">
                        <label for="time_to" class="col-2 col-form-label" style='display: inline-block;'>Alle:</label>
                      </div>
                      <div class="col-4">
                        <input class="form-control" type="time" id="time_to" name="time_to">
                      </div>
                    </div>
                    <hr>
                    <input type="radio" id="1h" name="hour" value='+1 hour' required>
                    <label for="1h" style='display: inline-block;'>1 ora</label><br>
                    <input type="radio" id="30m" name="hour" value='+30 minutes' required>
                    <label for="30m" style='display: inline-block;'>30 minuti</label><br>
                    <input type="radio" id="15m" name="hour" value='+15 minutes' required>
                    <label for="15m" style='display: inline-block;'>15 minuti</label>
                    <input type="submit" value="Aggiungi" class="btn">

                  </form>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src='scripts/workingDays.js'></script>
  </body>
</html>