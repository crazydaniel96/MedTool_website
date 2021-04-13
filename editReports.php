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

        <!-- customized libraries -->
        <link href="styles/page-content.css" rel="stylesheet" type="text/css">
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css">
        <script src="scripts/reports.js"></script>
        <script src="scripts/sidebar.js"></script>
  
	</head>
	<body>

        <!-- SIDEBAR -->
        <?php include('common/sidebar.php');?>

        <div class="page-content">
            <div class='container'>
                <form action='editReports.php' method='post'>
                    <div class="row">
                        <div class="col-40">

                            <?php
                                include ('Server.php');
                                $sql = "SELECT Category,Title FROM reports";
                                $result = $connect->query($sql);
                                while($row = $result->fetch_assoc()) {
                                    $optionReport[]=$row;
                                }
                                $sql = "SELECT DISTINCT Category FROM reports";
                                $result = $connect->query($sql);
                                while($row = $result->fetch_assoc()) {
                                    $Categories[]=$row;
                                }
                            ?>
                            <label for="Category">Categoria</label>
                            <select name="Category" id="Category2" class="fieldText cat" onchange="ReportChanger()" required>
                                <option disabled selected value> seleziona base </option>
                            </select>
                        </div>

                        <div class="col-40">
                            <label for="Title">Referto</label>
                            <select name="Title" id="Title" class="fieldText" required>
                                <option disabled selected value> ---- </option>
                            </select>
                        </div> 
                        <div class="col-20">
                            <input type="submit" value="Cerca" class="btn">
                        </div>
                    </div>
                </form>
            </div>

            <!-- HIDE PART, NOT SHOWN IF NO DATA PASSED -->
            <?php

                if ( isset($_POST['Title']) ){

                    $sql = "SELECT * FROM reports WHERE Category='".$_POST['Category']."' AND Title='".$_POST['Title']."'";

                    $result = $connect->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <br><br>
                            <div class='container'>
                                <br>
                                <form action='add_edit_report.php' method='post'>
                                    <div class='row'>
                                        <div class='col-50'>
                                            
                                            <label for='Category'>Categoria</label>
                                            <select name='Category' id='Category' class='fieldText cat' onchange='Manage_New()' required>
                                                <option value='Nuova categoria'>Nuova categoria</option>
                                                <option selected value='".$row['Category']."'>".$row['Category']."</option>
                                            </select>
                                            <input type='text' name='NewCat' id='NewCat' class='fieldText' placeholder='aggiungi nuova categoria' disabled required>

                                        </div>
                                        <div class='col-50'>
                                            <label for='Title'>Nome Referto</label>
                                            <input type='text' value='".$row['Title']."' name='Title' class='fieldText' required>
                                        </div> 
                                    </div>
                                    <label for='Header'>Intestazione</label>
                                    <textarea rows='1' name='Header' class='fieldText' style='resize: none;'>".$row['header']."</textarea>
                                    <label for='Body'>Corpo</label>
                                    <textarea rows='25' name='Body' class='fieldText' style='resize: none;'>".$row['Body']."</textarea>
                                    <div class='row justify-content-center'>
                                        <div class='col-2'>
                                            <input type='submit' value='Modifica Referto' name='Modify' class='btn'>
                                        </div>
                                        <div class='col-2'>
                                            <input type='submit' value='Elimina' name='Delete' class='btn'>
                                        </div>  
                                    </div>
                                    <input type='hidden' name='Report_ID' value='".$row['id']."'>
                                </form>
                            </div>
                            ";
                        }
                    } else {
                        echo "<br><div style='text-align: center;'><p>Nessun risultato </p></div>";
                    }
                    $connect->close(); 
                }
            ?>

        </div>


        <script>
            function ReportChanger(){
                var select = document.getElementById("Title");
                select.options.length = 0;
                var Title_array = <?php print(json_encode($optionReport)); ?>; 
                var Category=document.getElementById("Category2").value;

                for(index in Title_array) {
                    if (Title_array[index].Category==Category){
                        select.options[select.options.length] = new Option(Title_array[index].Title, Title_array[index].Title);
                    }
                }
            }

            var Categories = <?php print(json_encode($Categories)); ?>; 
            select = document.getElementsByClassName('cat');
            for (element in select){
                for(index in Categories) {
                    select[element].options[select[element].options.length] = new Option(Categories[index].Category, Categories[index].Category);
                }
            }

        </script>
    </body>
</html>