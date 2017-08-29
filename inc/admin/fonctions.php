<?php
	$FonctionManager = new FonctionManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	
	$options = array('orderby' => 'type, role');
	$listeFonctions = $FonctionManager->retourneListe($options);

	$options = array();
	$listeUtilisateurs = $UtilisateurManager->retourneListe($options);

	$options = array('where' => 'parent = 0', 'orderby' => 'ordre');
	$listeTypes = $RoleManager->retourneListe($options);

	$options = array('where' => 'parent = 1', 'orderby' => 'ordre');
	$listeRolesBureau = $RoleManager->retourneListe($options);

	$options = array('where' => 'parent = 5', 'orderby' => 'ordre');
	$listeRolesArbitres = $RoleManager->retourneListe($options);

	$options = array('orderby' => 'ordre');
	$listeRolesEntraineurs = $CategorieManager->retourneListe($options);
?>
<div class="wrapper fonctions">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des fonctions</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filtresModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#functionModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une fonction</button>
        </div>
        <div class="col-xs-12">
            <table class="table">
                <tr class="thead-inverse">
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Années de fonction</th>
                    <th></th>
                </tr><?php
                if(!empty($listeFonctions)):
                    foreach($listeFonctions as $uneFonction):?>
                        <tr class="<?=($uneFonction->getAnnee_fin()!=0)?'inactif':''; ?>"><?php
                            $options = array('where' => 'id = '. $uneFonction->getId_utilisateur());
                            $unUtilisateur = $UtilisateurManager->retourne($options);?>
                            <td><?=$unUtilisateur->getPrenom();?></td>
                            <td><?=$unUtilisateur->getNom();?></td>
                            <?php
                            if($uneFonction->getType()==4):
                                $options = array('where' => 'id = '. $uneFonction->getRole());
                                $uneCategorie = $CategorieManager->retourne($options);?>
                                <td><?=$uneCategorie->getCategorieAll();?></td><?php
                            else:
                                $options = array('where' => 'id = '. $uneFonction->getRole());
                                $unRole = $RoleManager->retourne($options);?>
                                <td><?=$unRole->getNom();?></td><?php
                            endif;
                            ?>
                            <td>
                                <?php
                                if($uneFonction->getAnnee_debut() == 0 && $uneFonction->getAnnee_fin() == 0):?>
                                    Non renseigné<?php
                                elseif($uneFonction->getAnnee_debut() != 0 && $uneFonction->getAnnee_fin() == 0):?>
                                    Depuis <?=$uneFonction->getAnnee_debut();?><?php
                                elseif($uneFonction->getAnnee_debut() == 0 && $uneFonction->getAnnee_fin() != 0):?>
                                    Jusqu'en <?=$uneFonction->getAnnee_fin();?><?php
                                else:?>
                                    <?=$uneFonction->getAnnee_debut();?> à <?=$uneFonction->getAnnee_fin();?><?php
                                endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning edit-function" data-toggle="modal" data-target="#functionModal"  data-id="<?=$uneFonction->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                <button class="btn btn-danger delete-function" data-id="<?=$uneFonction->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>
                        </tr><?php
                    endforeach;
                else:?>
                    <tr>
                        <td colspan="6">Aucune fonction enregistrée</td>
                    </tr><?php
                endif;?>
            </table>
        </div>
    </div>
    <div class="modal fade" id="functionModal" tabindex="-1" role="dialog" aria-labelledby="matchLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addFunctionLabel">Ajouter une fonction</h4>
                    <h4 class="modal-title hidden" id="editFunctionLabel">Modifier une fonction</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="id_utilisateur">Utilisateur <span class="text-danger">*</span></label><br>
                                    <select id="id_utilisateur" class="form-control selectpicker" data-live-search="true" title="Choisissez un utilisateur" data-toggle="popover" data-placement="bottom" data-content="Vous devez choisir un utilisateur"><?php
                                        foreach($listeUtilisateurs as $unUtilisateur):?>
                                            <option value="<?=$unUtilisateur->getId();?>"><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label><br>
                                    <select id="type" class="form-control selectpicker" title="Choisissez un type de rôle" data-toggle="popover" data-placement="bottom" data-content="Vous devez choisir un type de rôle"><?php
                                        foreach($listeTypes as $key => $unType):?>
                                            <option value="<?=$unType->getId();?>"><?=$unType->getNom();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group bureau hidden">
                                    <label for="role">Rôle bureau <span class="text-danger">*</span></label><br>
                                    <select id="role" class="form-control selectpicker role_1" title="Choisissez un rôle" data-toggle="popover" data-placement="bottom" data-content="Vous devez choisir un rôle"><?php
                                        foreach($listeRolesBureau as $key => $unRole):?>
                                            <option value="<?=$unRole->getId();?>"><?=$unRole->getNom();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group entraineur hidden">
                                    <label for="role">Entraineur des <span class="text-danger">*</span></label><br>
                                    <select id="role" class="form-control selectpicker role_4" title="Choisissez une équipe entrainée" data-toggle="popover" data-placement="bottom" data-content="Vous devez choisir une équipe"><?php
                                        foreach($listeRolesEntraineurs as $key => $uneCategorie):?>
                                            <option value="<?=$uneCategorie->getId();?>"><?=$uneCategorie->getCategorieAll();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group arbitre hidden">
                                    <label for="role">Rôle arbitre <span class="text-danger">*</span></label><br>
                                    <select id="role" class="form-control selectpicker role_5" title="Choisissez un rôle" data-toggle="popover" data-placement="bottom" data-content="Vous devez choisir un rôle"><?php
                                        foreach($listeRolesArbitres as $key => $unRole):?>
                                            <option value="<?=$unRole->getId();?>"><?=$unRole->getNom();?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group annee-debut">
                                    <label for="annee_debut">Année de début</label><br>
                                    <select id="annee_debut" class="form-control selectpicker" title="Choisissez une année"><?php
                                        for($i=$annee_suiv; $i > 2000; $i--):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group annee-fin">
                                    <label for="annee_fin">Année de fin</label><br>
                                    <select id="annee_fin" class="form-control selectpicker" title="Choisissez une année"><?php
                                        for($i=$annee_suiv; $i > 2000; $i--):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
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
                    <button type="button" class="btn btn-success add-fonction">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-fonction hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>