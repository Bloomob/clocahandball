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
</div>