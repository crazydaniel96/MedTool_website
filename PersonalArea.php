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
		<?php
        if ($_SESSION['restricted'])
            include('common/reduced_sidebar.php');
        else
            include('common/sidebar.php');
    ?>
		
		<div class="page-content">
			<div class='container'>
				<?php
					include ('Server.php');
					$stmt = $connect->prepare('SELECT password, username, restricted FROM accounts WHERE id = ?');
					// In this case we can use the account ID to get the account info.
					$stmt->bind_param('i', $_SESSION['id']);
					$stmt->execute();
					$stmt->bind_result($password, $username, $restricted);
					$stmt->fetch();
					$stmt->close();
				?>
				<br>
				<div class="row">
					<div class="col-lg-8">
						<form onsubmit=Edit_profile(this.Username.value,this.OldPW.value,this.NewPW.value,this.AccountType.checked) id="Edit_Profile">
							<div class="row">
								<div class="col-lg-6">
									<label for='Username'>Username</label>
									<input type="text" name="Username" class="fieldText" value="<?=$username?>">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<label for='OldPW'>Vecchia password</label>
									<input type="password" name="OldPW" id="OldPW" class="fieldText">
								</div>
								<div class="col-lg-6">
									<label for='NewPW'>Nuova password</label>
									<input type="password" name="NewPW" id="NewPW" class="fieldText">
								</div>
							</div>
							<small>Lasciare vuoto per non cambiare la password</small><br>
							<small>hash md5: <?=$password?></small><br><br>

							<label for="AccountType">
								<input type="checkbox" id="AccountType" name="AccountType" <? if ($restricted==1) echo "checked"?>>
							Profilo con restrizioni</label><br><br>
						
						</form>
					</div>
					<div class="col-lg-4">
						<p>Ultimo accesso:  ------ </p><br>
						<p>Registrato dal:  ------ </p><br>
					</div>
				</div>
				<input type="submit" value=" Salva " form="Edit_Profile" class="btn">
				<!--
				<div class="row justify-content-md-center">
					<div class="col col-lg-2">
						<button class="btn" onclick="ShowPWmodal()">Cambia password</button>
					</div>
					<div class="col col-lg-2">
						<a class="btn" href="logout.php">Logout</a>
					</div>
				</div>-->
			</div>
		</div>

		<script type="text/javascript">

			function Edit_profile(Username,oldP,newP,AccountType){
				$.ajax({
				    url: "Edit_profile.php",
				    type: "POST",
				    data: { Username:Username, OldPW: oldP, NewPW: newP, AccountType: AccountType},
				    success: function(){
				    	alert('Profilo aggiornato');
						},
						error: function(){
				    	alert('Password errata, riprovare');
						}
				});
			}

		</script>


	</body>
</html>