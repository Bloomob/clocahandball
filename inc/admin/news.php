<div class="tab_container">
	<div class="tab_content2 news">
		<div>
			<h3 class="">Liste des news</h3>
		</div>
		<div>
			<?php
				// id	infos	date_news	heure_news	categorie	affiche_type	affiche_numero	titre	contenu	auteur	important	publie
				$listeNews = listeNews();
				debug($listeNews);
			?>
		</div>
	</div>
</div>