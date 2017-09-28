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
<div class="wrapper clubs">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des clubs</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterClubModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#clubModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un club</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-clubs">
				<tr class="thead-inverse">
					<th>Nom</th>
					<th>Raccourci</th>
					<th>Numéro</th>
					<th>Ville</th>
					<th>Code Postal</th>
					<th>Actif</th>
					<th>Options</th>
				</tr><?php
				if(is_array($listeClubs)):
					foreach($listeClubs as $key => $unClub):?>
						<tr>
							<td><?=stripslashes($unClub->getNom());?></td>
							<td><?=stripslashes($unClub->getRaccourci());?></td>
							<td><?=$unClub->getNumero();?></td>
							<td><?=stripslashes($unClub->getVille());?></td>
							<td><?=$unClub->getCode_postal();?></td>
							<td><?=($unClub->getActif())?'Oui':'Non';?></td>
							<td>
								<button class="btn btn-warning edit-match" data-id="<?=$unClub->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
								<button class="btn btn-danger delete-match" data-id="<?=$unClub->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</td>
						</tr><?php
					endforeach;
				else:?>
					<tr>
						<td colspan="7">Aucun club enregistrée</td>
					</tr><?php
				endif;?>
			</table>
			<div class="text-center">
				<ul class="pagination"><?php
					$nbrPage = ceil($nbr_clubs/$nbr_par_page);
					for($i=1; $i<=$nbrPage; $i++):
						if($num_page == $i):?>
							<li><a href="#"><?=$i;?></a></li><?php
						else:?>
							<li><a href="admin.php?page=clubs&amp;num_page=<?=$i;?>"><?=$i;?></a></li><?php
						endif;
					endfor;?>
				</ul>
			</div>
		</div>
	</div>
    <div class="modal fade" id="clubModal" tabindex="-1" role="dialog" aria-labelledby="clubLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addClubLabel">Ajouter une club</h4>
                    <h4 class="modal-title hidden" id="editClubLabel">Modifier un club</h4>
                </div>
                <div class="modal-body">
                    <form id="formClub" action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nom">Nom du club <span class="text-danger">*</span></label><br>
                                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez un nom">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="raccourci">Raccourci <span class="text-danger">*</span></label><br>
                                    <input type="text" name="raccourci" id="raccourci" class="form-control" placeholder="Entrez un raccourci">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="numero">Numéro <span class="text-danger">*</span></label><br>
                                    <select id="numero" class="form-control selectpicker" title="Choisissez un numéro"><?php
                                        for($i=1; $i<5; $i++):?>
                                            <option value="<?=$i;?>"><?=$i;?></option><?php
                                        endfor;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ville">Ville <span class="text-danger">*</span></label><br>
                                    <input type="text" name="ville" id="ville" class="form-control" placeholder="Entrez une ville">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="code_postal">Code postal</label><br>
                                    <input type="number" name="code_postal" id="code_postal" class="form-control"placeholder="Entrez un code postal" min="1" max="99999" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group actif">
                                    <label for="actif">Actif ? <span class="text-danger">*</span></label><br>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                            <input type="radio" name="actif" id="actif_non" autocomplete="off" value="0" checked> Non
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" name="actif" id="actif_oui" autocomplete="off" value="1"> Oui
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
                    <button type="button" class="btn btn-success add-club">Ajouter</button>
                    <button type="button" class="btn btn-warning edit-club hidden">Modifier</button>
                </div>
            </div>
        </div>
    </div>
</div>