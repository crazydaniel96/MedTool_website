<div class="nav-side-menu">
    <div class="brand">Studio d'Arenzo</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content collapse out">

                <li class="/AddVisit.php">
                    <a href="AddVisit.php" style="display: block;">  
                        <i class="fa fa-user fa-lg"></i> Aggiungi Visita
                    </a>
                </li>

                <li data-toggle="collapse" data-target="#service" class="/FindPerson.php /FindDay.php">
                    <a href="#"><i class="fa fa-calendar fa-lg"></i> Gestione Appuntamenti <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse /FindPerson.php /FindDay.php" id="service">
                    <a href="FindPerson.php"><li class="/FindPerson.php">Cerca Persona</li></a>
                    <a href="FindDay.php"><li class="/FindDay.php">Cerca Giorno</li></a>
                </ul>

                <li class="/PersonalArea.php">
                    <a href="PersonalArea.php" style="display: block;">  
                        <i class="fa fa-user fa-lg"></i> Profilo
                    </a>
                </li>
                <li id="logout_menu">
                    <a href="logout.php" style="display: block;">
                        <i class="fa fa-sign-out fa-lg"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>