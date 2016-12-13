<script>
$(document).ready(function() {

	// $( "#menu_principal li" ).click(function( event ) {
		// if($( event.target ).is( 'a' )) {
			// $("#corps").fadeOut('500');
			// appelCorps('sous-menu-1');
			// return false;
		// }
	// });
	$("#menu-1 a").click( function() {
		$("#corps").fadeOut('500');
		appelCorps('sous-menu-1');
		return false;
	});

	$("#menu-2 a").click( function() {
		$("#corps").fadeOut('500');
		appelCorps('sous-menu-2');
		return false;
	});
	
	$("#menu-3 a").click( function() {
		appelSousMenu('sous-menu-3');
		return false;
	});
	
	$("#menu-4 a").click( function() {
		appelSousMenu('sous-menu-4');
		return false;
	});
	
	$("#menu-5 a").click( function() {
		appelSousMenu('sous-menu-5');
		return false;
	});
	
	$("#menu-6 a").click( function() {
		appelSousMenu('sous-menu-6');
		return false;
	});
	
	$("#menu-7 a").click( function() {
		appelSousMenu('sous-menu-7');
		return false;
	});
});
</script>

<nav id="menu_principal">
	<ul>
		<li id="menu-1"><a href="#"><span><span>A la une</span></span></a></li>
		<li id="menu-2"><a href="#"><span><span>Le projet Club</span></span></a></li>
		<li id="menu-3"><a href="#"><span><span>Staff du club</span></span></a></li>
		<li id="menu-4"><a href="#"><span><span>R&eacute;sultats & Classements</span></span></a></li>
		<li id="menu-5"><a href="#"><span><span>&Eacute;quipes</span></span></a></li>
		<li id="menu-6"><a href="#"><span><span>Entrainements</span></span></a></li>
		<li id="menu-7"><a href="#"><span><span>Adh&eacute;sions</span></span></a></li>
		<li id="menu-8"><a href="#"><span><span>Partenaires</span></span></a></li>
		<li id="menu-9"><a href="#"><span><span>Autres</span></span></a></li>
	</ul>
</nav>
<nav id="sous-menu-3" class="sous-menu">
	<ul>
		<li id="sous-menu-3-1"><a href="#"><span><span>Bureau</span></span></a></li>
		<li id="sous-menu-3-2"><a href="#"><span><span>Entraineurs</span></span></a></li>
		<li id="sous-menu-3-3"><a href="#"><span><span>Arbitres</span></span></a></li>
	</ul>
</nav>
<nav id="sous-menu-4" class="sous-menu">
	<ul>
		<li id="sous-menu-4-1"><a href="#"><span><span>Match &agrave; venir</span></span></a></li>
		<li id="sous-menu-4-2"><a href="#"><span><span>R&eacute;sultats de la semaine</span></span></a></li>
		<li id="sous-menu-4-3"><a href="#"><span><span>Classements</span></span></a></li>
	</ul>
</nav>
<nav id="sous-menu-5" class="sous-menu">
	<ul>
		<li id="sous-menu-5-1"><a href="#"><span><span>Seniors</span></span></a></li>
		<li id="sous-menu-5-2"><a href="#"><span><span>-20 ans</span></span></a></li>
		<li id="sous-menu-5-3"><a href="#"><span><span>-17 ans</span></span></a></li>
		<li id="sous-menu-5-4"><a href="#"><span><span>-15 ans</span></span></a></li>
		<li id="sous-menu-5-5"><a href="#"><span><span>-13 ans</span></span></a></li>
		<li id="sous-menu-5-6"><a href="#"><span><span>-11 ans</span></span></a></li>
		<li id="sous-menu-5-7"><a href="#"><span><span>-9 ans</span></span></a></li>
		<li id="sous-menu-5-8"><a href="#"><span><span>Loisirs</span></span></a></li>
	</ul>
</nav>
<nav id="sous-menu-6" class="sous-menu">
	<ul>
		<li id="sous-menu-6-1"><a href="#"><span><span>Horaires d'entra&icirc;nement</span></span></a></li>
		<li id="sous-menu-6-2"><a href="#"><span><span>Gymnase</span></span></a></li>
	</ul>
</nav>
<nav id="sous-menu-7" class="sous-menu">
	<ul>
		<li id="sous-menu-7-1"><a href="#"><span><span>Comment s'inscrire ?</span></span></a></li>
		<li id="sous-menu-7-2"><a href="#"><span><span>Tarifs & Cotisation</span></span></a></li>
		<li id="sous-menu-7-3"><a href="#"><span><span>R&egrave;glement interieur</span></span></a></li>
	</ul>
</nav>