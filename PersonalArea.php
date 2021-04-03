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
		<title>Profilo</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 

	</head>
	<body style="max-width: 70%;">

		<div style='display: flex;'>
			<h1 style='text-align:center;flex:1 0 auto;'>Gestione profilo</h1>
			<a href='home.php' style='text-decoration: none; color: #3274d6;'><i class='fa fa-home fa-4x' aria-hidden='true' style='text-align: right'></i></a>
		</div>
		<?php
			include ('Server.php');
			$stmt = $connect->prepare('SELECT password, username FROM accounts WHERE id = ?');
			// In this case we can use the account ID to get the account info.
			$stmt->bind_param('i', $_SESSION['id']);
			$stmt->execute();
			$stmt->bind_result($password, $username);
			$stmt->fetch();
			$stmt->close();
		?>
		<p>Username:</p>
		<p><?=$username?></p><br>
		<p>Password:</p>
		<p><?=$password?></p>
		<button class="btn" onclick="ShowPWmodal()">Cambia password</button>

		<div id="PasswordModal" class="modal">

              <!-- Modal content -->
            <div class="modal-content" style="width: auto;">
              	<span class="close">&times;</span>
                <div class="modal-body">
                	<div class="login" style="width: auto">
              			<form onsubmit="ChangePassword()" method="post">
                			<label for='OldPW' style="width: auto;">Vecchia password</label>
                			<input type="text" name="OldPW" id="OldPW"  required>
                			<label for='NewPW' style="width: auto;">Nuova password</label>
                			<input type="text" name="NewPW" id="NewPW" required>
                			<input type="submit" value="Cambia">
                		</form>
                	</div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        	var modal = document.getElementById("PasswordModal");
        	var span = document.getElementsByClassName("close")[0];

        	span.onclick = function() {
			  modal.style.display = "none";
			}

			window.onclick = function(event) {
			  	if (event.target == modal) {
			    	modal.style.display = "none";
	  			}
	  		}
	  		function ShowPWmodal(){
  				document.getElementById("PasswordModal").style.display = "block";
			}

			function ChangePassword(){
				$.ajax({
				    url: "RemoveBookingDate.php",
				    type: "POST",
				    data: { date: 'prova' },
				    success: function(){
				    	alert('Giornata rimossa correttamente');
					}
				});
			}

        </script>


	</body>
</html>