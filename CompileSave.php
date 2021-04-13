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

				<!-- docs libraries -->
				<script src="https://unpkg.com/docx@6.0.0/build/index.js"></script>
    		<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- customized libraries -->
		    <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
  
				<script>
					function generate() {  

						var today = new Date();
						var dd = String(today.getDate()).padStart(2, '0');
						var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0
						var yyyy = today.getFullYear();

						today = dd + '/' + mm + '/' + yyyy;

						var splitted=document.getElementById("Body").value.split("\n"); //  /\r?\n/g
						var Body= new Array();

						var Body=[
							new docx.Paragraph({
								spacing: {line:300},
								alignment: docx.AlignmentType.CENTER,
								children:[
									new docx.TextRun({
										text: "DOTT. ORESTE ROBERTO d’ARENZO",
										bold: true,
										size: 30,
										underline: {
												type: docx.UnderlineType.SINGLE,
												color: null,
										},
									})
								]
							}),

							new docx.Paragraph({
								spacing: {line:300},
								alignment: docx.AlignmentType.CENTER,
								children:[
									new docx.TextRun({
										text: "MEDICO CHIRURGO",
										bold: true,
										size: 14,
									})
								]
							}),

							new docx.Paragraph({
								spacing: {line:300},
								alignment: docx.AlignmentType.CENTER,
								children:[
									new docx.TextRun({
										text: "SPECIALISTA IN ORTOPEDIA E TRAUMATOLOGIA",
										bold: true,
										size: 14,
									})
								],
							}),

							new docx.Paragraph({
								spacing: {line:400},
								children :[
									new docx.TextRun({text: "",font: {name:"Arial"},size: 24})  //just to have a new line 
								],
							}),

							new docx.Paragraph({
								spacing: {line:400},
								alignment: docx.AlignmentType.RIGHT,
								children:[
									new docx.TextRun({
										text: "SAN SEVERO, "+today,
										size: 24,
									})
								],
							}),

							new docx.Paragraph({
								spacing: {line:400},
								children :[
									new docx.TextRun({text: "",font: {name:"Arial"},size: 24})  //just to have a new line 
								],
							}),
						];

						for (index in splitted){
							Body.push(new docx.Paragraph({
									spacing: {line:400},
									children :[
										new docx.TextRun({text: splitted[index],font: {name:"Arial"},size: 24})
									],
								}));
						}

						const doc = new docx.Document({
							sections: [{
								footers: {
										default: new docx.Footer ({
												children: [
													new docx.Paragraph({
														text: "Dr. d’Arenzo Oreste Roberto",
														alignment: docx.AlignmentType.CENTER,
													}),
													new docx.Paragraph({
														text: "via De Cesare 107 San Severo",
														alignment: docx.AlignmentType.CENTER,
													}),
													new docx.Paragraph({
														text: "si riceve solo su appuntamento",
														alignment: docx.AlignmentType.CENTER,
													}),
													new docx.Paragraph({
														text: "tel. 3791169602",
														alignment: docx.AlignmentType.CENTER,
													}),
												],
										}),
								},
								children: Body,
								properties: {
									page: {
											margin: {
												left: 1000,
												right: 1000
											},
									},
								},
							}],
						});
						
						docx.Packer.toBlob(doc).then(blob => {
								//console.log(blob);
								saveAs(blob, "referto.docx");
								//console.log("Document created successfully");
						});
					}
				</script>
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

                    <li data-toggle="collapse" data-target="#days" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Giorni Lavorativi <span class="arrow"></span></a>
                    </li>  
                    <ul class="sub-menu collapse" id="days">
                        <a href="workingDays.php"><li>Aggiungi/Rimuovi giorni</li></a>
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

										<li>
                      <a href="#"> 
                        <i class="fa fa-user fa-lg"></i> Refertazione
                      </a>
                    </li>
                </ul>
        </div>
    </div>

    <div class="page-content">

			<!-- compiling page -->

			<?php
				include ('Server.php');
				$sql = "SELECT * FROM reports WHERE Category='$_POST[Category]' AND Title='$_POST[Title]'";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					echo "<div class='container'>
							<br>
									<label for='Body'>Contenuto</label>
													<textarea id='Body' name='Body' rows='25' class='fieldText' style='resize:none'>".$row['header']."
													
SIG. " . $_POST['SurnameF'] . " " . $_POST['NameF'] . "
NATO IL " . $_POST['DayBornF'] . " A " . $_POST['CityBornF'] ."
RES. " . $_POST['CityNowF'] . " IN " . $_POST['AddressF'] . "

". $row['Body'] . "</textarea>"; 
				}
				else
					echo"error, no file found";
			?>



			<button class="btn" onclick="generate()">Scarica referto</button>

    </div>

  </body>
</html>
