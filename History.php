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
        <script src="scripts/docsGen.js"></script>

        <script>
            function generate(body) {  
  
                var today = $(body).find('#Date').val();

                var splitted=$(body).find('textarea').val().split("\n"); //  /\r?\n/g
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
        <div class='container'>

            <!-- FIND BY NAME-SURNAME -->
            <form action='History.php' method='post'>
                <div class="row">
                    <div class="col-40">
                        <input type="text" id="NameSearch" name="NameSearch" placeholder="Nome" class="fieldText" required>
                    </div>
                    <div class="col-40">
                        <input type="text" id="SurnameSearch" name="SurnameSearch" placeholder="Cognome" class="fieldText" required>
                    </div>
                    <div class="col-20">
                        <input type="submit" value="Cerca" class="btn" style="margin: 0px auto 10px">
                    </div>
                </div>
            </form>
        </div>

        <!-- HIDE PART, NOT SHOWN IF NO DATA PASSED -->
        <?php
            
            if ( isset($_POST['NameSearch']) ){
              include ('Server.php');
              $firstname = mysqli_real_escape_string($connect, $_POST['NameSearch']);
              $lastname = mysqli_real_escape_string($connect, $_POST['SurnameSearch']);

              $sql = "SELECT Date,Category,Report FROM history WHERE Name='$firstname' AND Surname='$lastname'";
            
              $result = $connect->query($sql);
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "
                      <div class='container'>
                          <br>
                          <form action='#' onsubmit='generate(this);return false'>
                            <div class='row'>
                                <div class='col-50'>
                                    <label for='Category'>Categoria</label>
                                    <input type='text' id='Category' name='Category' class='fieldText' value=\"" . $row["Category"]. "\">
                                </div>
                                <div class='col-50'>
                                    <label for='Date'>data</label>
                                    <input type='date' id='Date' name='Date' class='fieldText' value=\"" . $row["Date"]. "\">
                                </div>
                            </div>
                            <label for='Report'>Referto</label>";
                        if ($row['Report']!="")
                            echo"
                                <textarea rows='20' name='Report' id='Report' class='fieldText' style='resize: none;'>".$row['Report']."</textarea>
                                <div style='text-align:center'>
                                    <button name='Download' class='btn'>Scarica</button>
                                </div>";
                        else
                            echo"<p> Nessun referto </p>";
                        echo"
                        </form>
                      </div>
                      <br><br>";
                  }
              } 
              else {
                  echo "<br><div style='text-align: center;'><p>Nessun risultato </p></div>";
              }
              $connect->close(); 
            } 
        ?>
    </div>

  </body>
</html>