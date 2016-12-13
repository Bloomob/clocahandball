<?php
	$MatchManager = new MatchManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$ClubManager = new ClubManager($connexion);

	$nbr_par_page = 25;
	$num_page = 1;


	if(isset($_GET['num_page']))
		$num_page = $_GET['num_page'];

	$limite_start =  ($num_page-1) * $nbr_par_page;
	$limite_end = $nbr_par_page;

	$options = array('where' => 'joue = 0 AND date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630', 'orderby' => 'date, heure', 'limit' => $limite_start .', '. $limite_end);
	$listeMatchs = $MatchManager->retourneListe($options);
	$nbr_matchs = count($listeMatchs);
?>
<div class="tab_content2 calendrier">
	<h3>Calendrier <?=$annee;?>-<?=$annee+1;?></h3>
	<div id="zone-ajout">
		<div class="boutons-actions action-ajout">
			<div class="left">
				<a href="#" class="btn btn-ajout ajout-match">Ajouter un match</a>
				<a href="#" class="btn btn-ajout ajout-champ">Ajouter un championnat</a>
			</div>
			<div class="right">
				<a href="#" class="btn btn-search" data-default="Afficher les filtres">Afficher les filtres</a>
			</div>
			<div class="clear_b"></div>
		</div>
	</div>
	<div id="tab_admin">
		<div id="filtres" style="display: none;">
			<div class="table">
				<div class="row boutons-actions">
					<div class="cell cell-1-2">
						<div class="btn btn-valide"> Valider</div>
					</div>
					<div class="cell cell-1-2 align_right">
						<div class="btn btn-reset btn-picto"> Réinitialisé</div>
					</div>
				</div>
			</div>
			<div class="table marginT">
				<div class="row">
					<div class="cell cell-1-1">
						<h4><div class="icon">+</div> Catégories</h4>
						<div class="liste_categories" style="display: none;">
							<div>
								<input type="checkbox" id="cat_all" class="checked" /> <label for="cat_all">Tout</label>
							</div><?php
							$options2 = array('orderby' => 'ordre');
							$listeCategorie = $CategorieManager->retourneListe($options2);
							foreach($listeCategorie as $uneCategorie) {?>
								<div>
									<input type="checkbox" id="cat_<?=$uneCategorie->getId();?>" class="checked" /> <label for="cat_<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></label>
								</div><?php
							}?>
						</div>
						<input type="hidden" id="filtres_categories"/>
					</div>
				</div>
				<div class="row">
					<div class="cell cell-1-1">
						<h4><div class="icon">+</div> Compétitions</h4>
						<div class="liste_competitions" style="display: none;">
							<div>
								<input type="checkbox" id="comp_all" class="checked" /> <label for="comp_all">Tout</label>
							</div><?php
							$liste_competition = liste_competition();
							foreach($liste_competition as $key => $uneCompetition) {?>
								<div>
									<input type="checkbox" id="comp_<?=$key;?>" class="checked"/> <label for="comp_<?=$key;?>"><?=$uneCompetition;?></label>
								</div><?php
							}?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cell cell-1-1">
						<h4><div class="icon">+</div> Dates</h4>
						<div class="liste_dates" style="display: none;">
							<div>
								<input type="checkbox" id="date_all" class="checked" /> <label for="date_all">Tout</label>
							</div><?php
							$liste_date = liste_date($annee);
							foreach($liste_date as $key => $uneDate) {?>
								<div>
									<input type="checkbox" id="date_<?=$key;?>" class="checked" /> <label for="date_<?=$key;?>"><?=$uneDate;?></label>
								</div><?php
							}?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cell cell-1-1">
						<h4><div class="icon">+</div> Joué</h4>
						<div class="liste_joue" style="display: none;">
							<div>
								<input type="checkbox" id="joue" class="" /> <label for="joue">Joué</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Date</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Compétition</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Catégorie</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Adversaires</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Scores</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th>
					<h4>Options</h4>
				</th>
			</tr><?php
			// echo '<pre>'; var_dump($listeMatchs); echo '</pre>';
			include('liste_calendrier.php');
			?>
		</table>
		<div class="pagination">
			Page : <?php
			$nbrPage = ceil($nbr_matchs/$nbr_par_page);
			for($i=1; $i<=$nbrPage; $i++) {
				if($num_page == $i)
					echo '<span>'.$i.'</span> ';
				else
					echo '<a href="admin.php?page=calendrier&amp;num_page='.$i.'">'.$i.'</a> ';
			}?>
		</div>
	</div>
	<input type="hidden" id="liste_filtres" value="<?=$input_filtres?>"/>
</div>