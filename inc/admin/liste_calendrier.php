<?php
if(!empty($listeMatchs)):
	foreach($listeMatchs as $unMatch):
		// On récupère les infos de la catégorie
		$options = array('where' => 'id = '. $unMatch->getCategorie());
		$uneCategorie = $CategorieManager->retourne($options); ?>

		<tr class="cat_<?=$unMatch->getCategorie();?>">
			<td><input type="checkbox" id="match_<?=$unMatch->getId();?>"/></td>
			<td>
				<?php if($unMatch->getJoue()) {
					echo '<span class="boutons-actions"><span class="btn btn-play btn-slim btn-unclickable">'.$unMatch->remplace_date(1).'</span></span>';
				} else {
					echo '<span class="boutons-actions"><span class="btn btn-pause btn-slim btn-unclickable">'.$unMatch->remplace_date(1).'</span></span>'; 
				} ?>
			</td>
			<td class="competition">
				<div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
					<?=retourneCompetitionById($unMatch->getCompetition());?> 
					<br/><?=($unMatch->getJournee()!=0)?'Journ&eacute;e '.$unMatch->getJournee():$unMatch->getTour();?>
				</div>
			</td>
			<td class="puce">
				<div class="cat_<?=$uneCategorie->getRaccourci();?>"></div>
				<?=$uneCategorie->getCategorieAll();?>
			</td>
			<td><?php
				$tab = explode(',', $unMatch->getAdversaires());
				if(is_array($tab)):
					foreach($tab as $club):
						$unClub = $ClubManager->retourne($club);
						echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero().'<br/>';
					endforeach;
				else:
					$unClub = $ClubManager->retourne($club);
					echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
				endif; ?>
			</td>
			<td class="score-team2"><?php
				if($unMatch->getJoue()):
					$score_dom = explode(',', $unMatch->getScores_dom());
					$score_ext = explode(',', $unMatch->getScores_ext());
					if($unMatch->getLieu()==0):
						if(is_array($score_dom) && is_array($score_ext)):
							for($i=0; $i<count($score_dom); $i++):
								if($score_dom[$i]>$score_ext[$i]):
									$color = "vert";
								elseif($score_dom[$i]<$score_ext[$i]):
									$color = "rouge";
								else:
									$color = "orange";
								endif;
								echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
							endfor;
						else:
							if($score_dom>$score_ext):
								$color = "vert";
							elseif($score_dom<$score_ext):
								$color = "rouge";
							else:
								$color = "orange";
							endif;	
							echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
						endif;
					else:
						if(is_array($score_dom) && is_array($score_ext)):
							for($i=0; $i<count($score_dom); $i++):
								if($score_dom[$i]<$score_ext[$i]):
									$color = "vert";
								elseif($score_dom[$i]>$score_ext[$i]):
									$color = "rouge";
								else:
									$color = "orange";
								endif;
								echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
							endfor;
						else:
							if($score_dom<$score_ext):
								$color = "vert";
							elseif($score_dom>$score_ext):
								$color = "rouge";
							else:
								$color = "orange";
							endif;
							echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
						endif;
					endif;
				else:
					echo "<span class='violet'>". $unMatch->remplace_heure() ."</span>";
				endif; ?>
			</td>
			<td class="boutons-actions">
				<a href="<?=$unMatch->getId();?>" class="btn btn-modif btn-slim" title="Modifier le match">Modifier le match</a>
				<a href="<?=$unMatch->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le match">Supprimer le match</a>
			</td>
		</tr><?php
	endforeach;
else : ?>
	<tr>
		<td colspan='7'>Pas de match enregistré</td>
	</tr><?php
endif;?>