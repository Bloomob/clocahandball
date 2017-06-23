<?php
if(!empty($listeMatchs)):
	foreach($listeMatchs as $unMatch):
		// On récupère les infos de la catégorie
		$options = array('where' => 'id = '. $unMatch->getCategorie());
		$uneCategorie = $CategorieManager->retourne($options); ?>

		<tr class="cat_<?=$unMatch->getCategorie();?>">
			<td><?php
				if($unMatch->getJoue()):?>
					<button class="btn btn-success"><i class="fa fa-play" aria-hidden="true"></i> <?=$unMatch->remplace_date(1);?></button><?php
				else:?>
					<button class="btn btn-danger"><i class="fa fa-pause" aria-hidden="true"></i> <?=$unMatch->remplace_date(1);?></button><?php 
				endif;?>
			</td>
			<td class="competition">
				<div class="competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
					<?=$listeCompetition[$unMatch->getCompetition()];?> 
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
				else:?>
					<span class='violet'><?=$unMatch->remplace_heure();?></span><?php
				endif; ?>
			</td>
			<td>
				<button class="btn btn-warning edit-match" data-id="<?=$unMatch->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
				<button class="btn btn-danger delete-match" data-id="<?=$unMatch->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</td>
		</tr><?php
	endforeach;
else : ?>
	<tr>
		<td colspan='7'>Pas de match enregistré</td>
	</tr><?php
endif;?>