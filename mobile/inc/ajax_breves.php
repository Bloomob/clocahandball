<?php
	include_once("../../inc/connexion_bdd.php");
	include_once("../../inc/fonctions.php");
	include_once("../../inc/constantes.php");
?>
<script>
$(document).ready(function() {
	$("#liste_breves li a").click( function() {
		var id = $(this).attr("href");
		appelNews(id);
		return false;
	});
});
</script>
<div id="une_breve"></div>
<div id="liste_breves">
	<ul>
	<?php
	$liste_news = liste_news_iphone(INFOS_ACHERES);
	foreach($liste_news as $uneNews) {?>
		<li><a href="<?=$uneNews['id_breve']?>"><span><span><div><?=$uneNews['date_heure']?></div><?=$uneNews['titre_news']?></span></span></a></li><?php
	}?>
	</ul>
</div>
