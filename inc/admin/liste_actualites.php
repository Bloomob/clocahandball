<?php
if(is_array($listeActualites)):
	foreach($listeActualites as $key => $uneActu):?>
		<tr>
			<td class="align_left"><?=stripslashes($uneActu->getTitre());?></td><?php
			$unUtilisateur = $UtilManager->retourneById($uneActu->getId_auteur_crea()); ?>
			<td><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></td>
			<td><?php
				if($uneActu->getDate_publication()== 0):
					echo '<span class="statut rouge white"><img src="images/icon/png_white/clock.png" style="width: 20px;"/> Non publi&eacute;e</span>';
				elseif($uneActu->getDate_publication()>date('Ymd') || ($uneActu->getDate_publication()==date('Ymd') && $uneActu->getHeure_publication()>date('Hm'))):
					echo '<span class="statut orange white"><img src="images/icon/png_white/clock.png" style="width: 20px;"/> '.$uneActu->getJourP().'/'.$uneActu->getMoisP().' &agrave; '.remplace_heure($uneActu->getHeure_publication()).'</span>';
				else:
					echo '<span class="statut vert white"><img src="images/icon/png_white/clock.png" style="width: 20px;"/> '.$uneActu->getJourP().'/'.$uneActu->getMoisP().' &agrave; '.remplace_heure($uneActu->getHeure_publication()).'</span>';
				endif; ?>
			</td>
			<td class="boutons-actions">
				<a href="<?=$uneActu->getId();?>" class="btn btn-modif btn-slim" title="Modifier l'actualit&eacute;">Modifier l'actualit&eacute;</a>
				<a href="<?=$uneActu->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer l'actualit&eacute;">Supprimer l'actualit&eacute;</a>
			</td>
		</tr><?php
	endforeach;
else:?>
	<tr>
		<td colspan="7">Aucune actualit&eacute; enregistr&eacute;e</td>
	</tr><?php
endif;?>