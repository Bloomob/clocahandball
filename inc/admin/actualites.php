<?php
	$ActuManager = new ActualiteManager($connexion);
	$UtilManager = new UtilisateurManager($connexion);

	$options = array('orderby' => 'date_creation desc, heure_creation desc, date_publication desc, heure_publication desc', 'limit' => '0, 20');
	$listeActualites = $ActuManager->retourneListe($options);
?>
<div class="wrapper actualites">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des actualités</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterActuModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#actuModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une actualité</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-actualites">
				<tr class="thead-inverse">
					<th>Titre</th>
					<th>Auteur</th>
					<th>Status</th>
					<th></th>
				</tr>
				<?php include('liste_actualites.php'); ?>
			</table>
		</div>
	</div>
</div>