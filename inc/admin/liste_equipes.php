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
                    // var_dump($uneEquipe->getEntrainements());
					if($uneEquipe->getEntrainements() != ''):
                        $tab = explode(',', $uneEquipe->getEntrainements());
						foreach($tab as $entrainement):
                            $options = array('where' => 'id = '. $entrainement);
                            $unHoraire = $HoraireManager->retourne($options);
                            // var_dump($unHoraire);
                            $gymnase = (is_int($unHoraire->getGymnase())) ? $gymnases[$unHoraire->getGymnase()] : $unHoraire->getGymnase();
                            echo $jours[$unHoraire->getJour()] .' de '. $unHoraire->remplace_heure($unHoraire->getHeure_debut()) .' à '. $unHoraire->remplace_heure($unHoraire->getHeure_fin()) .' ('. $gymnase .')<br/>';
						endforeach;
					endif; ?>
				</td>
				<td>
					<button class="btn btn-warning" data-toggle="modal" data-target="#teamModal" data-id="<?=$uneEquipe->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
					<button class="btn btn-danger delete-team" data-id="<?=$uneEquipe->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
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