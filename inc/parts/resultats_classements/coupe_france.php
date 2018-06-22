<?php
$options = array('where' => 'date >= '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0701 AND competition = 3', 'orderby' => 'categorie');
$listeMatchs = $MatchManager->retourneListe($options);?>
<div class="legende"><i class="fa fa-info-circle" aria-hidden="true"></i>Les résultats en coupe des Yvelines de nos équipes.</div>
<table id="tab_result"><?php
    if(is_array($listeMatchs)) {
        $i=2;
        $cat = "";
        foreach($listeMatchs as $unMatch) {
            if($unMatch->getCategorie() != $cat) {
                $uneCategorie = $CategorieManager->retourneById($unMatch->getCategorie());
                $cat = $uneCategorie->getId(); ?>
                <tr>
                    <th colspan="4"><?=$uneCategorie->getCategorieAll();?></th>
                </tr><?php
            }
            $unClub = $ClubManager->retourneById($unMatch->getAdversaires());?>
            <tr class="cell<?=$i;?>">
                <td><?=$unMatch->remplace_date(2);?> <?=($unMatch->remplace_heure()!=0)?'&agrave; '. $unMatch->remplace_heure():'';?></td>
                <td><?=$unMatch->getTour();?></td>
                <td><?=$unClub->getRaccourci();?> <?=$unClub->getNumero()?></td>
                <td class="score-team2"><?php
                    $score_dom = explode(',', $unMatch->getScores_dom());
                    $score_ext = explode(',', $unMatch->getScores_ext());
                    ?>
                </td>
            </tr><?php
            $i++;
            if($i==3) $i=1;
        }
    }
    else {?>
        <tr>
            <td colspan='8'>Pas de résultats enregistrés pour cette saison.</td>
        </tr><?php
    }?>
</table>