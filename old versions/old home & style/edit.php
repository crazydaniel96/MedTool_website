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
		<title>Modifica appuntamenti</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	</head>
	<body style="max-width: 90%;">
		<?php
			include ('Server.php');

			if ( !isset($_POST['DateToModify']) && !isset($_GET['DateToModify']) ){
				echo "<div style='display: flex;'><h1 style='text-align:center;flex:1 0 auto;'>Modifica persona</h1><a href='home.php' style='text-decoration: none; color: #3274d6;'><i class='fa fa-home fa-4x' aria-hidden='true' style='text-align: right'></i></a></div>";
				$sql = "SELECT * FROM bookings WHERE Name='$_POST[NameSearch]' AND Surname='$_POST[SurnameSearch]' AND Visit_Date>=CURDATE() AND Result IS NULL";
			}
			else{
				echo "<div style='display: flex;'><h1 style='text-align:center;flex:1 0 auto;'>Modifica giorno</h1><a href='home.php' style='text-decoration: none; color: #3274d6;'><i class='fa fa-home fa-4x' aria-hidden='true' style='text-align: right'></i></a></div>";
				if (isset($_GET['DateToModify']))
					$sql = "SELECT * FROM bookings WHERE Visit_Date='$_GET[DateToModify]' AND Visit_Date>=CURDATE() AND Result IS NULL";
				else
					$sql = "SELECT * FROM bookings WHERE Visit_Date='$_POST[DateToModify]' AND Visit_Date>=CURDATE() AND Result IS NULL";
			}

			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        echo "
			        <div class='container'>
			        	<br>
			        	<form action='Modify-delete.php' method='post' onsubmit='return SubForm()'>
				        	<div class='row'>
	                            <div class='col-25'>
	                                <label for='Name'>Nome</label>
	                                <input type='text' id='Name' name='Name' placeholder='inserire il nome' class='fieldText' value='" . $row["Name"]. "'>
	                                <label for='Address'> Indirizzo</label>
	                                <input type='text' id='Address' name='Address' placeholder='inserire via e numero' class='fieldText' value='" . $row["Address"]. "'>
	                                <label for='visit_hour'>Orario Visita</label>  
                                    <select name='visit_hour' id='visit_hour' class='fieldText' value='" . $row["Visit_hour"]. "'>
                                    <option selected value> option 1 </option>
                                    </select>
	                            </div>
	                            <div class='col-25'>
	                                <label for='Surname'> Cognome</label>
	                                <input type='text' id='Surname' name='Surname' placeholder='inserire il cognome' class='fieldText' value='" . $row["Surname"]. "'>
	                                <label for='CityNow'>Residenza</label>
	                                <input type='text' id='CityNow' name='CityNow' placeholder='città' class='fieldText' value='" . $row["CityNow"]. "'>
	                                <label for='id'>ID</label>
	                                <input type='text' id='id' name='id' class='fieldText' value='" . $row["id"]. "' readonly>
	                            </div>
	                            <div class='col-25'>
	                                <label for='CityBorn'>Luogo di nascita</label>
	                                <input type='text' id='CityBorn' name='CityBorn' placeholder='città' class='fieldText' value='" . $row["CityBorn"]. "'>
	                                <label for='Phone'> Telefono</label>
	                                <input type='text' id='Phone' name='Phone' placeholder='numero di telefono' class='fieldText' value='" . $row["Phone"]. "'>
	                            </div>
	                            <div class='col-25'>
	                                <label for='DayBorn'>Giorno di nascita</label>
	                                <input type='date' id='DayBorn' name='DayBorn' class='fieldText' value='" . $row["DayBorn"]. "'>
	                                <label for='Visit_Date'> Giorni disponibili</label>
	                                <input type='date' id='Visit_Date' name='Visit_Date' class='fieldText' value='" . $row["Visit_Date"]. "'>
	                            </div>

	                        </div>
	                        <div style='text-align:center'>
	                        	<input type='submit' name='Modify' class='btn' value='Modifica' style='display: inline; margin: 0px 20px 0px 20px;'>
	                        	<input type='submit' name='Delete' class='btn' value='Elimina' style='display: inline; margin: 0px 20px 0px 20px;'>
	                    	</div>
                    	</form>
                    </div>
                    <br><br>
			        ";
			    }
			} else {
			    echo "<p>Nessun risultato </p>";
			}
			$connect->close(); 
		?>
		
		<script>		
			function SubForm(){
				var conf = confirm('Confermare?');
				if (conf){
					setTimeout(function(){window.location.reload();},10);
					return true;
				}
				else
					return false;
			}
		</script>

	</body>
</html>	

