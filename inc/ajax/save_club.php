<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");
	include_once("../../inc/fonctions.php");
	include_once("../../inc/constantes.php");
	include_once("../../inc/date.php");

	$ClubManager = new ClubManager($connexion);

	$nbr_par_page = 25;
	$num_page = 1;


	if(isset($_GET['num_page']))
		$num_page = $_GET['num_page'];

	$limite_start =  ($num_page-1) * $nbr_par_page;
	$limite_end = $nbr_par_page;

	$options = array('orderby' => 'nom', 'limit' => $limite_start .', '. $limite_end);
	$listeClubs = $ClubManager->retourneListe($options);
	$nbr_clubs = $ClubManager->compte();

	if(isset($_POST['club'])):
		$club = new Club( array() );

		foreach ($_POST['club'] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($club, $method)) {
				$club->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}

		// var_dump($club);

		if($club->getId() != 0):
			$ClubManager->modifier($club);
		else:
			$ClubManager->ajouter($club);
		endif;
		$options = array('orderby' => 'nom, numero', 'limit' => $limite_start .', '. $limite_end);
		$listeClubs = $ClubManager->retourneListe($options);?>
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Nom</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Raccourci</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Num&eacute;ro</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Ville</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Actif</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th>
					<h4>Options</h4>
				</th>
			</tr><?php
			if(is_array($listeClubs)):
				foreach($listeClubs as $key => $unClub):?>
					<tr class="<?php if($key%2==0) echo 'odd'; ?>">
						<td><input type="checkbox" name="id_<?=$unClub->getId();?>"/></td>
						<td><?=$unClub->getNom();?></td>
						<td><?=$unClub->getRaccourci();?></td>
						<td><?=$unClub->getNumero();?></td>
						<td><?=$unClub->getVille();?></td>
						<td><?=$unClub->getActif();?></td>
						<td class="boutons-actions">
							<a href="<?=$unClub->getId();?>" class="btn btn-modif btn-slim" title="Modifier le match">Modifier le match</a>
							<a href="<?=$unClub->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le match">Supprimer le match</a>
						</td>
					</tr><?php
				endforeach;
			else:?>
				<tr>
					<td colspan="7">Aucun club enregistrée</td>
				</tr><?php
			endif;?>
		</table>
		<div class="pagination">
			Page : <?php
				$nbrPage = ceil($nbr_clubs/$nbr_par_page);
				for($i=1; $i<=$nbrPage; $i++) {
					if($num_page == $i)
						echo '<span>'.$i.'</span> ';
					else
						echo '<a href="admin.php?page=clubs&amp;num_page='.$i.'">'.$i.'</a> ';
				}
			?>
		</div><?php
	endif;
	// fin si l'equipe existe
?>