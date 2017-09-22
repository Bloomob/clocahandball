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
    if(isset($_POST) && !empty($_POST)):
        if(isset($_POST['categorie'])):
            $filtres['categorie'] = 'categorie IN ('. $_POST['categorie'] .')';
        endif;
        if(isset($_POST['competition'])):
            $filtres['competition'] = 'competition IN ('. $_POST['competition'] .')';
        endif;
        if(isset($_POST['date_debut'])):
            $filtres['date_debut'] = 'date > ' . $_POST['date_debut'];
        else:
            $filtres['date_debut'] = 'date > '. $annee_actuelle .'0701';
        endif;
        if(isset($_POST['date_fin'])):
            $filtres['date_fin'] = 'date < ' . $_POST['date_fin'];
        else:
            $filtres['date_fin'] = 'date < '. $annee_suiv .'0630';
        endif;
        if(isset($_POST['joue'])):
            if($_POST['joue'] == 0):
                $filtres['joue'] = 'joue = 0';
            elseif($_POST['joue'] == 1):
                $filtres['joue'] = 'joue = 1';
            endif;
        endif;
    endif;

    $where = '';
    if(isset($filtres) && !empty($filtres)):
        foreach ($filtres as $key => $filtre):
            $where .= $filtre . ' AND ';
        endforeach;
        $where = substr($where, 0, -5);
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

    $options = array('where' => 'annee = '. $annee_actuelle, 'orderby' => 'niveau, championnat');
	$listeEquipe = $EquipeManager->retourneListe($options);

	$options = array('orderby' => 'raccourci');
	$listeClub = $ClubManager->retourneListe($options);
?>
<div class="wrapper calendrier">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Calendrier <?=$annee_actuelle;?>-<?=$annee_suiv;?></h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#matchModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un match</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#leagueModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un championnat</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-matchs">
                <tr class="thead-inverse">
					<th>Date</th>
					<th>Compétition</th>
					<th>Catégorie</th>
                    <th>Lieu</th>
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
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterLabel">Filtrer les matchs</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="formFilter">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="categorie">Categorie</label><br>
                                    <select id="categorie" class="form-control selectpicker" multiple title="Filtrer par catégorie"><?php
                                        foreach($listeEquipe as $uneEquipe):
		                                    $uneCategorie = $CategorieManager->retourneById($uneEquipe->getCategorie());?>
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
                                <div class="form-group joue">
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="categorie">Categorie</label><br>
                                    <select id="categorie" class="form-control selectpicker" title="Choisissez une catégorie"><?php
                                        foreach($listeEquipe as $uneEquipe):
                                            $uneCategorie = $CategorieManager->retourneById($uneEquipe->getCategorie());?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="competition">Compétition</label><br><select id="competition" class="form-control selectpicker" title="Choisissez une compétition"><?php
                                        foreach($listeCompetition as $key => $uneCompetition):?>
                                            <option value="<?=$key;?>"><?=$uneCompetition;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="niveau">Niveau</label><br><select id="niveau" class="form-control selectpicker" title="Choisissez un niveau"><?php
                                        foreach($listeNiveau as $key => $unNiveau):?>
                                            <option value="<?=$key;?>"><?=$unNiveau;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="dates">Dates</label><br>
                                    <div class='input-group date' id='date'>
                                        <input type='text' id="date-val" class="form-control" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group lieu">
                                    <label for="lieu_dom">Lieu</label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="lieu" id="lieu_dom" autocomplete="off" value="0" checked> Domicile
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="lieu" id="lieu_ext" autocomplete="off" value="1"> Exterieur
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="lieu" id="lieu_neu" autocomplete="off" value="2"> Neutre
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group journee">
                                    <label for="journee">Journée</label><br><select id="journee" class="form-control selectpicker" title="Choisissez une journée"><?php
                                        for($i=1; $i <= 26; $i++):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                                <div class="form-group tour hidden">
                                    <label for="tour">Tour</label><br>
                                    <input type="text" id="tour" class="form-control" placeholder="Choisissez un tour">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="adversaires">Adversaire(s)</label><br>
                                    <select id="adversaires" class="form-control selectpicker" multiple data-live-search="true" data-max-options="4" title="Choisissez un adversaire"><?php
                                        foreach($listeClub as $unClub):?>
                                            <option value="<?=$unClub->getId();?>" data-nom="<?=$unClub->getRaccourci();?> <?=$unClub->getNumero();?>"><?=$unClub->getRaccourci();?> <?=$unClub->getNumero();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group joue">
                                    <label for="joue">Match joué ?</label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="joue" id="joue_oui" autocomplete="off" value="1"> Oui
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="joue" id="joue_non" autocomplete="off" value="0" checked> Non
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 rencontres"><?php
                                for($i=1; $i<5; $i++):?>
                                    <div class="row rencontre hidden">
                                        <div class="col-sm-2 lieu">
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default <?=($i==1)?'active':''?>">
                                                    <input type="radio" name="isDom" id="isDom_<?=$i?>" autocomplete="off" value="<?=$i?>" <?=($i==1)?'checked':''?>>Reçoit
                                                </label>
                
                                            </div>
                                        </div>
                                        <div class="col-sm-3 equipe1 text-right">
                                            <p></p>
                                        </div>
                                        <div class="col-sm-2 text-right">
                                            <select id="score_dom_<?=$i?>" class="form-control selectpicker scores_dom"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="score_ext_<?=$i?>" class="form-control selectpicker scores_ext"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 equipe2">
                                            <p></p>
                                        </div>
                                    </div><?php
                                endfor;?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-loader hidden">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success add-match">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-match hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="leagueModal" tabindex="-1" role="dialog" aria-labelledby="leagueLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addLeagueLabel">Ajouter un championnat</h4>
                    <h4 class="modal-title hidden" id="editLeagueLabel">Modifier un championnat</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="categorie">Categorie</label><br>
                                    <select id="categorie" class="form-control selectpicker" title="Choisissez une catégorie"><?php
                                        foreach($listeEquipe as $uneEquipe):
		                                    $uneCategorie = $CategorieManager->retourneById($uneEquipe->getCategorie());?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="competition">Compétition</label><br><select id="competition" class="form-control selectpicker" title="Choisissez une compétition"><?php
                                        foreach($listeCompetition as $key => $uneCompetition):
                                            if($key == 1 || $key == 4):?>
                                                <option value="<?=$key;?>"><?=$uneCompetition;?></option><?php
                                            endif;
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="niveau">Niveau</label><br><select id="niveau" class="form-control selectpicker" title="Choisissez un niveau"><?php
                                        foreach($listeNiveau as $key => $unNiveau):?>
                                            <option value="<?=$key;?>"><?=$unNiveau;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group aller_retour">
                                    <label for="aller_retour">Aller-Retour ?</label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="aller_retour" id="aller" autocomplete="off" value="0" checked=""> Aller
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="aller_retour" id="aller_retour" autocomplete="off" value="1"> Aller-Retour
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rencontres">
                            <div class="row rencontre">
                                <div class="col-sm-1">
                                    <div class="journee-aller form-group">
                                        <label>Journée</label>
                                        <span class="form-control">1</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group lieu">
                                        <label>Lieu du match aller</label><br>
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default active">
                                                <input type="radio" name="lieu_0" id="lieu_dom_0" autocomplete="off" value="0" checked> Dom.
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="lieu_0" id="lieu_ext_0" autocomplete="off" value="1"> Ext.
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="lieu_0" id="lieu_neu_0" autocomplete="off" value="2"> Neu.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Scores</label>
                                    <div class="row scores-aller">
                                        <div class="col-sm-6 form-group">
                                            <select id="score_dom_aller" class="form-control selectpicker scores_dom"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <select id="score_ext_aller" class="form-control selectpicker scores_ext"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group date-aller">
                                        <label for="dates">Dates</label><br>
                                        <div class='input-group date' id='date_aller'>
                                            <input type='text' id="date-aller-val" class="form-control" placeholder="Date aller" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group joue-aller">
                                        <label for="joue">Match joué ?</label><br>
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default">
                                                <input type="radio" name="joue_aller_0" id="joue_aller_oui_0" autocomplete="off" value="1"> Oui
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="radio" name="joue_aller_0" id="joue_aller_non_0" autocomplete="off" value="0" checked> Non
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group journee-retour hidden">
                                        <span class="form-control"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select id="adversaires" class="form-control selectpicker" data-live-search="true" title="Choisissez un adversaire"><?php
                                            foreach($listeClub as $unClub):?>
                                                <option value="<?=$unClub->getId();?>" data-nom="<?=$unClub->getRaccourci();?> <?=$unClub->getNumero();?>"><?=$unClub->getRaccourci();?> <?=$unClub->getNumero();?></option><?php
                                            endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="row scores-retour hidden">
                                        <div class="col-sm-6 form-group">
                                            <select id="score_dom_retour" class="form-control selectpicker scores_dom"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <select id="score_ext_retour" class="form-control selectpicker scores_ext"><?php
                                                for($j=0; $j <= 60; $j++):?>
                                                    <option value="<?=$j;?>"><?=$j;?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group date-retour hidden">
                                        <div class='input-group date' id='date_retour'>
                                            <input type='text' id="date-retour-val" class="form-control" placeholder="Date retour" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group joue-retour hidden">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default">
                                                <input type="radio" name="joue_retour_0" id="joue_retour_oui_0" autocomplete="off" value="1"> Oui
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="radio" name="joue_retour_0" id="joue_retour_non_0" autocomplete="off" value="0" checked> Non
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ajout">
                            <div class="row">
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-success add-journee"><i class="fa fa-plus"></i> Ajouter</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger rm-journee hidden"><i class="fa fa-minus"></i> Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-loader hidden">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success add-league">Ajouter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteMatchModal" tabindex="-1" role="dialog" aria-labelledby="deleteMatchLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteMatchLabel">Supprimer un match</h4>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer ce match ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary delete-match">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>

