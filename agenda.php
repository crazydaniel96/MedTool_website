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
        <script src="scripts/sidebar.js"></script>
  
	</head>
	<body>

    <!-- SIDEBAR -->
    <?php include('common/sidebar.php');?>

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