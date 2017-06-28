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

    /* Filtres */
    if(isset($_POST['filtre_cat'])):
        $categorie = $CategorieManager->retourneById($_POST['filtre_cat']);
        if($categorie->getId()):
            $filtres['categorie'] = 'categorie = '. $categorie->getId();
        endif;
    endif;

    if(isset($_POST['filtre_joue'])):
        if($_POST['filtre_joue'] === 0):
            $filtres['joue'] = 'joue = 0';
        elseif($_POST['filtre_joue'] === 1):
            $filtres['joue'] = 'joue = 1';
        endif;
    endif;

    $where = '';
    if(isset($filtres) && !empty($filtres)):
        foreach ($filtres as $key => $filtre):
            $where .= $filtre . ' AND ';
        endforeach;
        $where = substr($where, -5);
    else:
        $where = 'joue = 0 AND date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630';
    endif;
	$options = array(
        'where' => $where,
        'orderby' => 'date, heure',
        'limit' => $limite_start .', '. $limite_end
    );
	$listeMatchs = $MatchManager->retourneListe($options);
	$nbr_matchs = count($listeMatchs);

	$options = array('orderby' => 'ordre');
	$listeCategories = $CategorieManager->retourneListe($options);
?>
<div class="wrapper calendrier">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Calendrier <?=$annee_actuelle;?>-<?=$annee_suiv;?></h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterMatchModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#matchModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un match</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#leagueModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un championnat</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-matchs">
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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="dates">Dates</label><br>
                                    <div class="row">
                                        <div class='col-md-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='date_debut'>
                                                    <input type='text' class="form-control" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='date_fin'>
                                                    <input type='text' class="form-control" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="joue">Match joué ?</label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="joue" id="joue1" autocomplete="off" value="2"> Les deux
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="joue" id="joue2" autocomplete="off" value="1"> Oui
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="joue" id="joue3" autocomplete="off" checked value="0"> Non
                                        </label>
                                    </div>
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
    <div class="modal fade" id="matchModal" tabindex="-1" role="dialog" aria-labelledby="matchLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addMatchLabel">Ajouter un match</h4>
                    <h4 class="modal-title hidden" id="editMatchLabel">Modifier un match</h4>
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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="dates">Dates</label><br>
                                    <div class="row">
                                        <div class='col-md-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='date_debut'>
                                                    <input type='text' class="form-control" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-5'>
                                            <div class="form-group">
                                                <div class='input-group date' id='date_fin'>
                                                    <input type='text' class="form-control" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="joue">Match joué ?</label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="joue" id="joue1" autocomplete="off" value="2"> Les deux
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="joue" id="joue2" autocomplete="off" value="1"> Oui
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="joue" id="joue3" autocomplete="off" checked value="0"> Non
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success add-match">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-match hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>
