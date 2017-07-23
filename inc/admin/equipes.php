
<?php
	$EquipeManager = new EquipeManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	
    $options = array('orderby' => 'annee DESC, categorie');
    $listeEquipes = $EquipeManager->retourneListe($options);

    $options = array('orderby' => 'ordre');
    $listeCategories = $CategorieManager->retourneListe($options);

    $options = array('orderby' => 'nom');
    $listeUtilisateurs = $UtilisateurManager->retourneListe($options);

	$options = array();
	$listeHoraires = $HoraireManager->retourneListe($options);
	// debug($listeHoraires);
?>
<div class="wrapper equipes">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des équipes</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filtresModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#teamModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une équipe</button>
        </div>
        <div class="col-xs-12">
            <table class="table">
                <tr class="thead-inverse">
                    <th></th>
                    <th>Catégorie</th>
                    <th>Année</th>
                    <th>Entraineurs</th>
                    <th>Entrainements</th>
                    <th></th>
                </tr>
                <?php include('liste_equipes.php'); ?>
            </table>
        </div>
    </div>
    <div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTeamLabel">Ajouter une équipe</h4>
                    <h4 class="modal-title hidden" id="editTeamLabel">Modifier une équipe</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="categorie">Categorie <span class="text-danger">*</span></label><br><select id="categorie" class="form-control selectpicker" title="Choissisez une catégorie"><?php
                                        foreach($listeCategories as $uneCategorie):?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="niveau">Niveau <span class="text-danger">*</span></label><br>
                                    <select id="niveau" class="form-control selectpicker" title="Choissisez un niveau"><?php
                                        foreach($listeNiveau as $key => $niveau):?>
                                            <option value="<?=$key;?>"><?=$niveau;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="championnat">Championnat <span class="text-danger">*</span></label><br>
                                    <select id="championnat" class="form-control selectpicker" title="Choissisez un championnat"><?php
                                        foreach($listeChampionnat as $key => $championnat):?>
                                            <option value="<?=$key;?>"><?=$championnat;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="annee">Année <span class="text-danger">*</span></label><br>
                                    <select id="annee" class="form-control selectpicker" title="Choissisez une année"><?php
                                        for($i=$annee_suiv; $i >= 2012; $i--):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label for="entraineurs">Entraineur(s) <span class="text-danger">*</span></label><br>
                                    <select id="entraineurs" class="form-control selectpicker" multiple data-live-search="true" title="Choissisez les entraineurs"><?php
                                        foreach($listeUtilisateurs as $unUtilisateur):?>
                                            <option value="<?=$unUtilisateur->getId();?>"><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                                <p class="alert alert-danger taille-mot-de-passe hidden">Le mot de passe doit faire plus de 5 caractères</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="jour_1">Entrainement(s) <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row marginB">
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <select id="jour_1" class="form-control selectpicker"><?php
                                                foreach($jours as $key => $jour):?>
                                                    <option value="<?=$key;?>"><?=$jour;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_debut_1" class="form-control selectpicker"><?php
                                                for($i=900; $i <= 2130; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <span class="text-height">à</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_fin_1" class="form-control selectpicker"><?php
                                                for($i=1000; $i <= 2230; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="gymnase_1" class="form-control selectpicker"><?php
                                                foreach($gymnases as $key => $g):?>
                                                    <option value="<?=$key;?>"><?=$g;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row marginB">
                                        <div class="col-sm-1">
                                            <button class="btn btn-success add-training"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="jour_2" class="form-control selectpicker" disabled><?php
                                                foreach($jours as $key => $jour):?>
                                                    <option value="<?=$key;?>"><?=$jour;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_debut_2" class="form-control selectpicker" disabled>
                                                <option value="0">-</option><?php
                                                for($i=900; $i <= 2130; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <span class="text-height">à</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_fin_2" class="form-control selectpicker" disabled>
                                                <option value="0">-</option><?php
                                                for($i=1000; $i <= 2230; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="gymnase_2" class="form-control selectpicker" disabled>
                                                <option value="">-</option><?php
                                                foreach($gymnases as $key => $g):?>
                                                    <option value="<?=$key;?>"><?=$g;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row marginB">
                                        <div class="col-sm-1">
                                            <button class="btn btn-success add-training"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="jour_3" class="form-control selectpicker" disabled>
                                                <option value="0">-</option><?php
                                                foreach($jours as $key => $jour):?>
                                                    <option value="<?=$key;?>"><?=$jour;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_debut_3" class="form-control selectpicker" disabled>
                                                <option value="0">-</option><?php
                                                for($i=900; $i <= 2130; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <span class="text-height text-center">à</span>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="heure_fin_3" class="form-control selectpicker" disabled>
                                                <option value="0">-</option><?php
                                                for($i=1000; $i <= 2230; $i+=15):
                                                    if(substr($i, -2) == 60):
                                                        $i+=40;
                                                    endif;?>
                                                    <option value="<?=$i;?>"><?=remplace_heure($i);?></option><?php
                                                endfor;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select id="gymnase_3" class="form-control selectpicker" disabled>
                                                <option value="">-</option><?php
                                                foreach($gymnases as $key => $g):?>
                                                    <option value="<?=$key;?>"><?=$g;?></option><?php
                                                endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
		                	<div class="col-sm-12">
			                    <p class="text-danger">* Champs obligatoires</p>
		                    </div>
	                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success add-team">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-team hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>