<?php
	$ClubManager = new ClubManager($connexion);

	$nbr_par_page = 25;
	$num_page = 1;


	if(isset($_GET['num_page']))
		$num_page = $_GET['num_page'];

	$limite_start =  ($num_page-1) * $nbr_par_page;
	$limite_end = $nbr_par_page;

	$options = array('orderby' => 'nom, numero', 'limit' => $limite_start .', '. $limite_end);
	$listeClubs = $ClubManager->retourneListe($options);
	$nbr_clubs = $ClubManager->compte();
?>
<div class="tab_content2 clubs">
	<h3>Liste des clubs</h3>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout ajout-match">Ajouter un club</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div id="tab_admin">
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
					<h4>Code Postal</h4>
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
						<td><?=$unClub->getCode_postal();?></td>
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
		</div>
	</div>
</div>