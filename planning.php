<?php

$type = (int)$_GET['typeAffichage'];

$file_name = match($type) {
	0 => 'jourSemaine',
	1 => 'jourMois',
    2 => 'semaineAnnee',
    3 => 'moisAnnee'
};

include __DIR__."/$file_name.php";

?>