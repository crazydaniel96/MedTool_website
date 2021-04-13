<?php

	
	$DATABASE_HOST = 'sql113.epizy.com';
	$DATABASE_USER = 'epiz_28246977';
	$DATABASE_PASS = 'cQnMtG0moAQj';
	$DATABASE_NAME = 'epiz_28246977_StudioROB';
	/*
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'studiorob';*/

	$connect = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

	if ( mysqli_connect_errno() ) {
	    // If there is an error with the connection, stop the script and display the error.
	    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>	