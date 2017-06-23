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

	$options = array('orderby' => 'ordre');
	$listeCategories = $CategorieManager->retourneListe($options);
?>
<div class="wrap calendrier">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Calendrier <?=$annee;?>-<?=$annee+1;?></h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterMatchModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#addMatchModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un match</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#addLeagueModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un championnat</button>
        </div>
        <div class="col-xs-12">
            <table class="table">
                <tr class="thead-inverse">
					<th>Date</th>
					<th>Compétition</th>
					<th>Catégorie</th>
					<th>Adversaires</th>
					<th>Score/Heure</th>
					<th>Options</th>
				</tr><?php
				// echo '<pre>'; var_dump($listeMatchs); echo '</pre>';
				include('liste_calendrier.php');?>
			</table>
			<div class="text-center">
				<ul class="pagination"><?php
					$nbrPage = ceil($nbr_matchs/$nbr_par_page);
					for($i=1; $i<=$nbrPage; $i++):
						if($num_page == $i):?>
							<li class="active"><a href="#"><?=$i;?></a><?php
						else:?>
							<li><a href="admin.php?page=calendrier&amp;num_page=<?=$i;?>"><?=$i;?></a></li><?php
						endif;
					endfor;?>
				</ul>
			</div>
		</div>
		<!-- <input type="hidden" id="liste_filtres" value="<?=$input_filtres?>"/> -->
	</div>
    <div class="modal fade" id="filterMatchModal" tabindex="-1" role="dialog" aria-labelledby="filterMatchLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterMatchLabel">Filtrer les matchs</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="categorie">Categorie</label><br><select id="categorie" class="form-control selectpicker" multiple title="Filtrer par catégorie"><?php
                                        foreach($listeCategories as $uneCategorie):?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="competition">Compétition</label><br><select id="competition" class="form-control selectpicker" multiple title="Filtrer par compétition"><?php
                                        foreach($listeCompetition as $key => $uneCompetition):?>
                                            <option value="<?=$key;?>"><?=$uneCompetition;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="dates">Dates</label><br>
                                    
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="competition">Match joué ?</label><br>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-warning reset-filter-match">Réinitialiser</button>
                    <button type="button" class="btn btn-primary filter-match">Filtrer</button>
                </div>
            </div>
        </div>
    </div>
</div>