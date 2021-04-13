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
				<script src="scripts/sidebar.js"></script>
  
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
    <?php include('common/sidebar.php');?>

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
