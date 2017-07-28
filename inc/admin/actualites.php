<?php
	$ActuManager = new ActualiteManager($connexion);
	$UtilManager = new UtilisateurManager($connexion);

	$options = array('orderby' => 'date_creation desc, heure_creation desc, date_publication desc, heure_publication desc', 'limit' => '0, 20');
	$listeActualites = $ActuManager->retourneListe($options);
?>
<div class="wrapper actualites">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des actualités</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterActuModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#actuModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter une actualité</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-actualites">
				<tr class="thead-inverse">
					<th>Titre</th>
					<th>Auteur</th>
					<th>Statut</th>
					<th></th>
				</tr>
				<?php include('liste_actualites.php'); ?>
			</table>
		</div>
	</div>
	<div class="modal fade" id="actuModal" tabindex="-1" role="dialog" aria-labelledby="matchLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addActuLabel">Ajouter une actualité</h4>
                    <h4 class="modal-title hidden" id="editActuLabel">Modifier une actualité</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="titre">Titre <span class="text-danger">*</span></label><br>
                                    <input type="text" name="titre" id="titre" class="form-control" placeholder="Entrez un titre">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sous_titre">Sous-titre <span class="text-danger">*</span></label><br>
                                    <input type="text" name="sous_titre" id="sous_titre" class="form-control" placeholder="Entrez un sous-titre">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="contenu">Contenu <span class="text-danger">*</span></label><br>
                                    <textarea name="contenu" id="contenu" class="form-control" placeholder="Entrez un contenu"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="theme">Thème <span class="text-danger">*</span></label><br>
                                    <select id="theme" class="form-control selectpicker" title="Choisissez un thème"><?php
                                        foreach($tabTheme as $key => $value):?>
                                            <option value="<?=$key;?>"><?=$value;?></option><?php
                                        endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="tags">Tags</label><br>
                                    <input type='text' id="tags" class="form-control" data-role="tagsinput"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-4">
                                <div class="form-group publication">
                                    <label for="publication">Publication ? <span class="text-danger">*</span></label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="publication" id="publi_immediate" autocomplete="off" value="0" checked> Immédiate
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="publication" id="publi_programme" autocomplete="off" value="1"> Programmée
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group date hidden">
                                    <label for="date">Date</label><br>
                                    <div class='input-group date' id='date'>
                                        <input type='text' id="date-val" class="form-control" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-sm-4">
                                <div class="form-group slider">
                                    <label for="slider">Afficher dans le slider ? <span class="text-danger">*</span></label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="slider" id="slider_oui" autocomplete="off" value="1"> Oui
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="slider" id="slider_non" autocomplete="off" value="0" checked> Non
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group importance">
                                    <label for="importance">Importance ? <span class="text-danger">*</span></label>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" name="importance" id="importance_haute" autocomplete="off" value="1"> Haute
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="importance" id="importance_moyenne" autocomplete="off" value="2"> Moyenne
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="radio" name="importance" id="importance_basse" autocomplete="off" value="3" checked> Basse
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group publie">
                                    <label for="publie">Etat ? <span class="text-danger">*</span></label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="publie" id="publie_non" autocomplete="off" value="0" checked> Brouillon
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="publie" id="publie_oui" autocomplete="off" value="1"> Publié
                                        </label>
                                    </div>
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
                    <button type="button" class="btn btn-success add-actu">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-actu hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>