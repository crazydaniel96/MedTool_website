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
		<title>Profilo</title>
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
		<script src="scripts/sidebar.js"></script> 

	</head>

	<body>
		<!-- SIDEBAR -->
		<?php include('common/sidebar.php');?>
		<div class="page-content">
			<div class='container'>
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
				<br>
				<p><b>Username:</b></p>
				<p><?=$username?></p><br>
				<p><b>Password:</b></p>
				<p><?=$password?></p><br><br>
				<button class="btn" onclick="ShowPWmodal()">Cambia password</button>
			</div>
		</div>

		<div id="PasswordModal" class="modal">

			<!-- Modal content -->
			<div class="modal-content" style="width: 350px;">
				<div class="modal-header">
					<span class="close">&times;</span>
				</div>
				<div class="modal-body">
						<form onsubmit="ChangePassword()" method="post">
							<label for='OldPW'>Vecchia password</label>
							<input type="password" name="OldPW" id="OldPW" class="fieldText" required>
							<label for='NewPW'>Nuova password</label>
							<input type="password" name="NewPW" id="NewPW" class="fieldText" required>
							<input type="submit" value="Cambia" class="btn">
						</form>

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