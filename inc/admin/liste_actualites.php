<?php
if(is_array($listeActualites)):
	foreach($listeActualites as $key => $uneActu):?>
		<tr>
			<td><?=stripslashes($uneActu->getTitre());?></td><?php
			$unUtilisateur = $UtilManager->retourneById($uneActu->getId_auteur_crea()); ?>
			<td><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></td>
			<td><?php
				if($uneActu->getDate_publication()== 0):?>
					<span class="statut bg-danger text-danger"><i class="fa fa-clock-o" aria-hidden="true"></i> Non publiée</span><?php
				elseif($uneActu->getDate_publication()>date('Ymd') || ($uneActu->getDate_publication()==date('Ymd') && $uneActu->getHeure_publication()>date('Hm'))): ?>
					<span class="statut bg-warning text-warning"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $uneActu->getJourP().'/'.$uneActu->getMoisP().' à '.remplace_heure($uneActu->getHeure_publication());?> </span><?php
				else: ?>
					<span class="statut bg-success text-success"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $uneActu->getJourP().'/'.$uneActu->getMoisP().' à '.remplace_heure($uneActu->getHeure_publication()); ?></span><?php
				endif; ?>
			</td>
			<td>
				<button class="btn btn-warning edit-match" data-id="<?=$uneActu->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
				<button class="btn btn-danger delete-match" data-id="<?=$uneActu->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</td>
		</tr><?php
	endforeach;
else:?>
	<tr>
		<td colspan="7">Aucune actualité enregistrée</td>
	</tr><?php
endif;?>