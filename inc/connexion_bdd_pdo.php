<?php
if($_SERVER['SERVER_NAME'] == '127.0.0.1') {
	$PARAM_hote='localhost'; // le chemin vers le serveur
	$PARAM_nom_bd='clocahan'; // le nom de votre base de données
	$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
	$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
}
else{
	$PARAM_hote='mysql51-90.perso'; // le chemin vers le serveur
	$PARAM_nom_bd='clocahan'; // le nom de votre base de données
	$PARAM_utilisateur='clocahan'; // nom d'utilisateur pour se connecter
	$PARAM_mot_passe='NiTpMYRb'; // mot de passe de l'utilisateur pour se connecter
}

try {
	$connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
}
catch(Exception $e) {
	echo 'Une erreur est survenue : '. $e->getMessage();
	die();
} ?>