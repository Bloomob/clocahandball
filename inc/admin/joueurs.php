<?php
	$JoueurManager = new JoueurManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);

	$nbr_par_page = 25;
	$num_page = 1;

	if(isset($_GET['num_page']))
		$num_page = $_GET['num_page'];

	$limite_start =  ($num_page-1) * $nbr_par_page;
	$limite_end = $nbr_par_page;

	$options = array('orderby' => 'id', 'limit' => $limite_start.', '.$limite_end);
	$listeJoueurs = $JoueurManager->retourneListe($options);

	$nbrJoueurs = $JoueurManager->compte();
?>
<div class="wrapper joueurs">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des joueurs</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterJoueurModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#joueurModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un joueur</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-joueurs">
				<tr class="thead-inverse">
					<th>Nom/Prénom</th>
					<th>Age</th>
					<th>Poste</th>
					<th>Numéro</th>
					<th>Actif</th>
					<th></th>
				</tr><?php
				if(!empty($listeJoueurs)):
					foreach($listeJoueurs as $unJoueur):
						$unUtilisateur = $UtilisateurManager->retourneById($unJoueur->getId_utilisateur());?>
						<tr>
							<td><?=$unUtilisateur->getNom();?> <?=$unUtilisateur->getPrenom();?></td>
							<td><?=$unJoueur->getDate_naissance();?></td>
							<td><?=$postes[$unJoueur->getPoste()];?></td>
							<td><?=$unJoueur->getNumero();?></td>
							<td><?=($unJoueur->getActif())?'Oui':'Non';?></td>
							<td>
								<button class="btn btn-warning" data-toggle="modal" data-target="#playersModal" data-id="<?=$unJoueur->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
								<button class="btn btn-danger delete-team" data-id="<?=$unJoueur->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</td>
						</tr><?php
					endforeach;
				else:?>
					<tr>
						<td colspan="8">Aucun joueur enregistré</td>
					</tr><?php
				endif;?>
			</table>
		</div>
		<div class="text-center">
			<ul class="pagination"><?php
				$nbrPage = ceil($nbrJoueurs/$nb_par_page);
				for($i=1; $i<=$nbrPage; $i++):
					if($num_page == $i):?>
						<li><a href="#"><?=$i;?></a></li><?php
					else:?>
						<li><a href="admin.php?page=joueurs&num_p=<?=$i;?>"><?=$i;?></a></li><?php
					endif;
				endfor;?>
			</ul>
		</div>
	</div>
</div>