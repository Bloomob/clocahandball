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
?>
<div class="tab_content2 joueurs">
	<h3 class="">Liste des joueurs</h3>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter un joueur</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div>Il y a <?php echo nbr_joueurs();?> joueurs au total</div>
	<div  id="tab_admin">
		<table>
			<tr class="titres">
				<th></th>
				<th class="num w_5">N°</th>
				<th class="nom align_left w_50">Nom/Prénom</th>
				<th class="age w_5">Age</th>
				<th class="equipe align_left w_15">Equipe</th>
				<th class="poste align_left w_5">Poste</th>
				<th class="actif align_left w_5">Actif</th>
				<th class="options w_15"></th>
			</tr><?php
			$i = 0;
			$options = array();
			$listeJoueurs = $JoueurManager->retourneListe($options);
			if(!empty($listeJoueurs)):
				foreach($listeJoueurs as $unJoueur):
					$unUtilisateur = $UtilisateurManager->retourneById($unJoueur->getId_utilisateur());?>
					<tr <?php if($i%2==1) echo 'class="odd"'; ?>>
						<td><input type="checkbox" name="joueurs_check" class="joueurs_check"/></td>
						<td><span class="joueurs_date"><?=$unJoueur->getnumero();?></span></td>
						<td><span class="joueurs_nom"><?=$unUtilisateur->getNom();?> <span class="joueurs_prenom"><?=$unUtilisateur->getPrenom();?></span></span></td>
						<td><span class="joueurs_date"><?=$unJoueur->date();?></span></td>
						<td><span class="joueurs_poste"><?=$postes[$unJoueur->getPoste()];?></span></td>
						<td><span class="joueurs_actif"><?=retourneTextBool($unJoueur->getActif());?></span></td>
						<td class="boutons-actions">
							<a href="<?=$unJoueur->getId_utilisateur();?>" class="btn btn-modif btn-slim" title="Modifier">Modifier le joueur</a>
							<a href="<?=$unJoueur->getId_utilisateur();?>" class="btn btn-suppr btn-slim" title="Supprimer">Supprimer le joueur</a>
						</td>
					</tr><?php
					$i++;
				endforeach;
			else:?>
				<tr>
					<td colspan="8">Aucun joueur enregistré</td>
				</tr><?php
			endif;?>
		</table>
	</div>
	<div class="pagination">
		Page : <?php
			$nbrPage = ceil(nbr_joueurs()/$nb_par_page);
			for($i=1; $i<=$nbrPage; $i++) {
				if($num_page == $i)
					echo '<span>'.$i.'</span> ';
				else
					echo '<a href="admin.php?page=joueurs&num_p='.$i.'">'.$i.'</a> ';
			}
		?>
	</div>
</div>