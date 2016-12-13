<?php
	include_once("connexion_bdd.php");
	include_once('fonctions.php');
	include_once('constantes.php');
?>
<ul>
<?php
$liste_news = liste_news(INFOS_ACHERES);
foreach($liste_news as $uneNews) {?>
	<li><span><span><?=$uneNews['titre_news']?></span></span></li><?php
}?>
</ul>