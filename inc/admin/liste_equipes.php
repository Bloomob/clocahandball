<?php
	$i=0;
	if(!empty($listeEquipes)):
		foreach($listeEquipes as $uneEquipe):?>
			<tr class="<?=(!$uneEquipe->getActif()) ? 'inactif' : '';?>">
				<td><input type="checkbox" name="id_<?=$uneEquipe->getId();?>"/></td><?php
				$options = array('where' => 'id = '. $uneEquipe->getCategorie());
				$uneCategorie = $CategorieManager->retourne($options);?>
				<td><?=$uneCategorie->getCategorie();?> <?=$uneCategorie->getGenre();?> <?=$uneCategorie->getNumero();?></td>
				<td><?=$uneEquipe->getAnnee();?></td>
				<td><?php
					$tab = explode(',', $uneEquipe->getEntraineurs());
					if(is_array($tab)):
						foreach($tab as $entraineur):
						$options = array('where' => 'id = '. $entraineur);
							$unEntraineur = $UtilisateurManager->retourne($options);
							echo $unEntraineur->getPrenom().' '.$unEntraineur->getNom().'<br/>';
						endforeach;
					else:
						$options = array('where' => 'id = '. $tab);
						$unEntraineur = $UtilisateurManager->retourne($options);
						echo $unEntraineur->getPrenom().' '.$unEntraineur->getNom();
					endif; ?>
				</td>
				<td><?php
					$tab = explode(',', $uneEquipe->getEntrainements());
					if(is_array($tab)):
						foreach($tab as $entrainement):
						$options = array('where' => 'id = '. $entrainement);
							$unHoraire = $HoraireManager->retourne($options);
							echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin()).'<br/>';
						endforeach;
					else:
						$options = array('where' => 'id = '. $tab);
						$unHoraire = $HoraireManager->retourne($options);
						echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin());
					endif; ?>
				</td>
				<td class="boutons-actions">
					<a href="#<?=$uneEquipe->getId();?>" class="btn btn-modif btn-slim" title="Modifier l'équipe">Modifier l'équipe</a>
					<a href="#<?=$uneEquipe->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer l'équipe">Supprimer l'équipe</a>
				</td>
			</tr><?php
			$i++;
		endforeach;
	else:?>
		<tr>
			<td colspan="6">Aucune équipe enregistrée</td>
		</tr><?php
	endif;
?>