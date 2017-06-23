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

	$options = array();
	$listeTousUtilisateurs = $UtilManager->retourneListe($options);
?>
<div class="wrap utilisateurs">
	<div class="row">
		<div class="col-xs-12">
			<h3>Liste des utilisateurs</h3>
	    </div>
	    <div class="col-xs-12 text-right marginB">
	       <button class="btn btn-primary" data-toggle="modal" data-target="#filterUserModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
	       <button class="btn btn-success" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un utilisateur</button>
	    </div>
		<div class="col-xs-12">
			<table class="table">
				<tr class="thead-inverse">
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
					<th>Rang</th>
					<th>Actif ?</th>
					<th></th>
				</tr>
				<?php include('liste_utilisateurs.php'); ?>
			</table>
			<div class="text-center">
				<ul class="pagination"><?php
					$nbrPage = ceil(count($listeTousUtilisateurs)/$nb_par_page);
					for($i=1; $i<=$nbrPage; $i++):
						if ($num_page == $i):?>
							<li class="active"><a href="#"><?= $i;?></a></li><?php
						else:?>
							<li><a href="admin.php?page=utilisateurs&num_page=<?= $i;?>"><?= $i;?></a></li><?php
						endif;
					endfor;?>
				</ul>
			</div>
		</div>
	</div>
    <div class="modal fade" id="filterUserModal" tabindex="-1" role="dialog" aria-labelledby="filterUserLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterUserLabel">Filtrer les utilisateurs</h4>
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
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserLabel">
	    <div class="modal-dialog modal-md" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title" id="myModalLabel">Ajouter un utilisateur</h4>
	            </div>
	            <div class="modal-body">
	                <form>
	                	<div class="row">
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                        <label for="nom">Nom <span class="text-danger">*</span></label><br>
			                        <input type="text" id="nom" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le nom est obligatoire">
			                    </div>
			                </div>
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                        <label for="prenom">Prénom <span class="text-danger">*</span></label><br>
			                        <input type="text" id="prenom" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le prénom est obligatoire">
			                    </div>
		                    </div>
		                </div>
	                	<div class="row">
		                	<div class="col-sm-8">
			                    <div class="form-group">
			                        <label for="mail">Email</label><br>
			                        <input type="email" id="mail" class="form-control">
			                    </div>
		                    </div>
		                	<div class="col-sm-4">
			                    <div class="form-group">
			                        <label for="num_licence">N° de licence</label><br>
			                        <input type="text" id="num_licence" class="form-control">
			                    </div>
		                    </div>
		                </div>
	                	<div class="row">
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                        <label for="mot_de_passe">Mot de passe</label><br>
			                        <input type="password" id="mot_de_passe" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le mot de passe doit faire plus de 5 caractères">
			                    </div>
		                    </div>
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                        <label for="confirm_mot_de_passe">Confirmer le mot de passe</label><br>
			                        <input type="password" id="confirm_mot_de_passe" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Les deux mots de passes sont différents">
			                    </div>
		                    </div>
		                </div>
	                	<div class="row">
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                        <label for="rang">Rang *</label><br>
			                        <select id="rang" class="form-control selectpicker">
			                        	<option value="0">Membre</option>
			                        	<option value="1">Admin</option>
			                        	<option value="2">Redacteur</option>
			                        </select>
			                    </div>
		                    </div>
		                	<div class="col-sm-6">
			                    <div class="form-group">
			                    	<label>Actif ?</label><br>
			                        <div class="btn-group" data-toggle="buttons">
										<label class="btn btn-default">
											<input type="radio" name="actif" id="actif_oui" autocomplete="off"> Oui
										</label>
										<label class="btn btn-default active">
											<input type="radio" name="actif" id="actif_non" autocomplete="off" checked> Non
										</label>
									</div>
			                    </div>
		                    </div>
	                    </div>
	                	<div class="row">
		                	<div class="col-sm-12">
                				<p class="alert alert-danger form-errors hidden">Le formulaire comporte des erreurs.</p>
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
	                <button type="button" class="btn btn-success add-user">Ajouter</button>
	            </div>
	        </div>
	    </div>
	</div>
</div>