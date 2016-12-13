<?php
$listeMatchs = liste_matchs_par_equipe($equipe['raccourci']);?>
<table id="tab_cal_equipe2" class="calendrier_gen">
	<?php
	if(is_array($listeMatchs)) {
		$i=2;
		$mois = '';
		$convoc = true;
		foreach($listeMatchs as $unMatch) {
			if($unMatch['mois'] != $mois) {?>
				<tr class="cal_month" >
					<th colspan='7'><?=$unMatch['mois'];?></th>
				</tr><?php
			}?>
			<tr class="cells cell<?=$i;?>">
				<td class="laDate"><?=$unMatch['laDate'];?></td>
				<td class="competition">
					<div class="<?=$unMatch['img_competition'];?>"><?=$unMatch['competition'];?></div>
				</td>
				<!--<td class="images"><?=$unMatch['images'];?></td>-->
				<?php if($unMatch['lieu']==0) { ?>
				<td class="equipe1">Ach&egrave;res</td>
				<td class="score"><?=($unMatch['joue'])? $unMatch['score'] : "<span>".$unMatch['newHeure']."</span>";?></td>
				<td class="equipe2"><?=$unMatch['adversaire'];?></td>
				<?php } else { ?>
				<td class="equipe1"><?=$unMatch['adversaire'];?></td>
				<td class="score"><?=($unMatch['joue']) ? $unMatch['score'] : "<span>".$unMatch['newHeure']."</span>";?></td>
				<td class="equipe2">Ach&egrave;res</td>
				<?php } ?>
				<td class="convoc">
					<a href="<?=$unMatch['id']?>" class="suppr_match">Supprimer le match</a>
					<a href="<?=$unMatch['id']?>" class="modif_match">Modifier le match</a><?php
					if($convoc && $unMatch['joue']==0 && $unMatch['date'] > date('Ymd')) {?>
						<a href="<?=$unMatch['id']?>_<?=$j;?>" class="convoc_match">Convocation de match</a><?php
						$convoc = false;
					}?>
				</td>
			</tr><?php
			$i++;
			if($i==3) $i=1;
			$mois = $unMatch['mois'];
		}
	}
	else {?>
		<tr>
			<td colspan='8'>Pas de match enregistré pour cet équipe.</td>
		</tr><?php
	}?>
</table>