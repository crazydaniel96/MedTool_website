<?php

	/*
	$DATABASE_HOST = 'sql104.epizy.com';
	$DATABASE_USER = 'epiz_26426507';
	$DATABASE_PASS = 'lqsQL1OWQ3W';
	$DATABASE_NAME = 'epiz_26426507_StudioROB';*/
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'studiorob';

	$connect = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

	if ( mysqli_connect_errno() ) {
	    // If there is an error with the connection, stop the script and display the error.
	    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>	