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

        <form action='add_edit_report.php' method='post'>

            <div class="row">
                <div class="col-50">

                    <?php
                        include ('Server.php');
                        $sql = "SELECT DISTINCT Category FROM reports";
                        $result = $connect->query($sql);
                        while($row = $result->fetch_assoc()) {
                            $Categories[]=$row;
                        }
                    ?>
                    <label for="Category">Categoria</label>
                    <select name="Category" id="Category" class="fieldText" onchange="Manage_New()" required>
                        <option selected value="Nuova categoria">Nuova categoria</option>
                    </select>
                    <input type="text" id="NewCat" name="NewCat" class="fieldText" placeholder="aggiungi nuova categoria" required>
                    <script>
                        var Categories = <?php print(json_encode($Categories)); ?>; 
                        select = document.getElementById("Category");
                        for(index in Categories) {
                            select.options[select.options.length] = new Option(Categories[index].Category, Categories[index].Category);
                        }
                    </script>
                </div>

                <div class="col-50">
                    <label for="Title">Nome Referto</label>
                    <input type="text" id="Title" name="Title" class="fieldText" required>
                </div> 
            </div>

            <label for="Header">Intestazione</label>
            <textarea rows="1" id="Header" name="Header" placeholder="Alla cortese attenzione del dott." class="fieldText" style="resize: none;"></textarea>
            <label for="Body">Corpo</label>
            <textarea rows="25" id="Body" name="Body" class="fieldText" style="resize: none;"></textarea>

            <input type="submit" value="Inserisci Referto" class="btn">

        </form>
      </div>
    </div>

  </body>
</html>