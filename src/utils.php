<?php

function connect()
{
	$database_path = __DIR__."/../data/planning.sqlite";
	try{
	    $pdo = new PDO('sqlite:'.$database_path);
	    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
	    return $pdo;
	} catch(Exception $e) {
	    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
	    die();
	}
	return null;

}
?>