<div class="nav-side-menu">
    <div class="brand">Studio d'Arenzo (beta)</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content collapse out">
                <li class="/TodayVisits.php">
                    <a href="TodayVisits.php" style="display: block;"> 
                        <i class="fa fa-stethoscope fa-lg"></i> Visite in corso
                    </a>
                </li>
                
                <li  data-toggle="collapse" data-target="#products" class="/AddVisit.php /AddVisit2.php /AddVisitFree.php">
                    <a href="#"><i class="fa fa-plus fa-lg"></i> Gestione Visite <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse /AddVisit.php /AddVisit2.php /AddVisitFree.php" id="products">
                    <a href="AddVisit.php"><li class="/AddVisit.php">Aggiungi Visita</li></a>
                    <a href="AddVisit2.php"><li class="/AddVisit2.php">Aggiungi Visita Controllo</li></a>
                    <a href="AddVisitFree.php"><li class="/AddVisitFree.php">Aggiungi Visita - Libero</li></a>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="/FindPerson.php /FindDay.php /agenda.php">
                    <a href="#"><i class="fa fa-calendar fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse /FindPerson.php /FindDay.php /agenda.php" id="service">
                    <a href="FindPerson.php"><li class="/FindPerson.php">Cerca Persona</li></a>
                    <a href="FindDay.php"><li class="/FindDay.php">Cerca Giorno</li></a>
                    <a href="agenda.php"><li class="/agenda.php">Agenda</li></a>
                </ul>

                <li data-toggle="collapse" data-target="#days" class="/workingDays.php">
                    <a href="#"><i class="fa fa-briefcase fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse /workingDays.php" id="days">
                    <a href="workingDays.php"><li class="/workingDays.php">Aggiungi/Rimuovi giorni</li></a>
                </ul>

                <li data-toggle="collapse" data-target="#reports" class="/editReports.php /addReport.php">
                    <a href="#"><i class="fa fa-paperclip fa-lg"></i> Referti <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse /editReports.php /addReport.php" id="reports">
                    <a href="editReports.php"><li class="/editReports.php">Modifica referto</li></a>
                    <a href="addReport.php"><li class="/addReport.php">Aggiungi referto</li></a>
                </ul>

                <li class="/stats.php">
                    <a href="stats.php" style="display: block;">  
                        <i class="fa fa-bar-chart fa-lg"></i> Statistiche
                    </a>
                </li>
                <li class="/PersonalArea.php">
                    <a href="PersonalArea.php" style="display: block;">  
                        <i class="fa fa-user fa-lg"></i> Profilo
                    </a>
                </li>
            </ul>
    </div>
</div>