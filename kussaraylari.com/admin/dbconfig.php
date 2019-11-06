<?php

	$DB_HOST = "localhost";
	$DB_USER = "root";
	$DB_PASS = "";
	
	
	try{
		$DB_con = new PDO("mysql:host=$DB_HOST;dbname=kussaraylari;charset=utf8", $DB_USER, $DB_PASS);
		$DB_con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		
	}
	catch(PDOException $e){
		echo "Connection failed: " .$e->getMessage();
	}
	?>
	 