<?php
	$UtilManager = new UtilisateurManager($connexion);

	$nbr_par_page = 25;
	$num_page = 1;

	if(isset($_GET['num_page']))
		$num_page = $_GET['num_page'];

	$limite_start =  ($num_page-1) * $nbr_par_page;
	$limite_end = $nbr_par_page;

	$options = array('orderby' => 'nom', 'limit' => $limite_start.', '.$limite_end);
	$listeUtilisateurs = $UtilManager->retourneListe($options);
?>

<div class="tab_content2 utilisateurs">	
	<div>
		<h3>Liste des utilisateurs</h3>
	</div>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout">Ajouter un utilisateur</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div class="clear_b"></div>
	<div id="tab_admin">
		<table>
			<tr class="titres">
				<th class="nom w_20">
					<a href="#">Nom</a>
				</th>
				<th class="prenom w_20">
					<a href="#">Prenom</a>
				</th>
				<th class="rang w_15">
					<a href="#">Rang</a>
				</th>
				<th class="actif w_15">
					<a href="#">Compte ?</a>
				</th>
				<th class="options w_15">
				</th>
			</tr>
			<?php include('liste_utilisateurs.php'); ?>
		</table>
	</div>
	<div class="pagination">
		Page : <?php
			$nbrPage = ceil(nbr_utilisateurs()/$nb_par_page);
			for($i=1; $i<=$nbrPage; $i++) {
				if($num_page == $i)
					echo '<span>'.$i.'</span> ';
				else
					echo '<a href="admin.php?page=utilisateurs&num_page='.$i.'">'.$i.'</a> ';
			}
		?>
	</div>
</div>