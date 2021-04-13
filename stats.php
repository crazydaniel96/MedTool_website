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
        <script src="scripts/sidebar.js"></script>
  
	</head>
	<body>

    <!-- SIDEBAR -->
    <?php include('common/sidebar.php');?>

    <div class="page-content">
      <div class='container'>
        <br>
        <h2 style="text-align: center"><i class="fa fa-code-fork fa-3x">
          </i>In costruzione <i class="fa fa-code-fork fa-3x"></i>
        </h2>
        <br>
        <p>assenti mese corrente:</p><hr>
        <p>assenti mese scorso:</p><hr>
        <p>visite completate con <br>successo mese attuale:</p><hr>
        <p>visite completate con <br>successo mese scorso:</p><hr>
        <p>prenotazioni disponibili mese attuale:</p><br>
        <br><br>
      </div>
    </div>

  </body>
</html>