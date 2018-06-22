<?php
// $listeMatchs = liste_resultats_semaine($now);
$options = array('where' => 'date <= '. $now .' AND date > '. date_moins_7J($now) .' AND joue = 1', 'orderby' => 'date, heure');
$listeMatchs = $MatchManager->retourneListe($options);
// debug($listeMatchs);?>
<div class="legende"><i class="fa fa-info-circle" aria-hidden="true"></i>La liste des matchs qui se sont déroulés lors des 7 derniers jours.</div>
<div class="liste-matchs"><?php
    if(!empty($listeMatchs)):
        foreach($listeMatchs as $unMatch):
            $options2 = array('where' => 'id = '. $unMatch->getCategorie());
            $uneCategorie = $CategorieManager->retourne($options2); ?>
            <div class="row">
                <div class="col-sm-2 date">
                    <div class="jour"><?=$unMatch->getJour();?></div>
                    <div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
                </div>
                <!-- <div class="col-sm-1 heure">
                <span><?=($unMatch->remplace_heure()!=0)?$unMatch->remplace_heure():'';?></span>
                </div> -->
                <div class="col-sm-3">
                    <div class="compet competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
                        <span><?=$listeCompetition[$unMatch->getCompetition()];?>
                            <br/><?=($unMatch->getJournee()!=0)?'Journ&eacute;e '.$unMatch->getJournee():$unMatch->getTour();?></span>
                    </div>
                </div>
                <div class="col-sm-4"><?php
                    if($unMatch->getLieu()==0):?>
                        <div class="dom puce">
                            <div class="cat_<?=$uneCategorie->getRaccourci();?>"></div>
                            <a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>">
                                <strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong>
                            </a>
                        </div>
                        <div class="ext"><?php
                            $tab = explode(',', $unMatch->getAdversaires());
                            if(is_array($tab)):
                                foreach($tab as $key => $club):
                                    if($key > 0) { echo " - "; }
                                    $unClub = $ClubManager->retourne($club);
                                    echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
                                endforeach;
                            endif; ?>
                        </div><?php
                        else: ?>
                        <div class="dom"><?php
                            $tab = explode(',', $unMatch->getAdversaires());
                            if(is_array($tab)):
                                foreach($tab as $key => $club):
                                    if($key > 0) { echo " - "; }
                                    $unClub = $ClubManager->retourne($club);
                                    echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
                                endforeach;
                            endif; ?>
                        </div>
                        <div class="ext puce">
                            <div class="cat_<?=$uneCategorie->getRaccourci();?>"></div>
                            <a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>">
                                <strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong>
                            </a>
                        </div><?php
                    endif;?>
                </div>
                <div class="col-sm-2">
                    <div class="scores"><?php
                        if($unMatch->getJoue()):
                        $score_dom = explode(',', $unMatch->getScores_dom());
                        $score_ext = explode(',', $unMatch->getScores_ext());
                        if($unMatch->getLieu()==0):
                        if(is_array($score_dom) && is_array($score_ext)):
                        for($i=0; $i<count($score_dom); $i++):
                        if($score_dom[$i] > $score_ext[$i]):
                        $color = "vert";
                        elseif($score_dom[$i] < $score_ext[$i]):
                        $color = "rouge";
                        else:
                        $color = "orange";
                        endif;
                        echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
                        endfor;
                        else:
                        if($score_dom > $score_ext):
                        $color = "vert";
                        elseif($score_dom < $score_ext):
                        $color = "rouge";
                        else:
                        $color = "orange";
                        endif;	
                        echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
                        endif;
                        else:
                        if(is_array($score_dom) && is_array($score_ext)):
                        for($i=0; $i<count($score_dom); $i++):
                        if($score_dom[$i] < $score_ext[$i]):
                        $color = "vert";
                        elseif($score_dom[$i] > $score_ext[$i]):
                        $color = "rouge";
                        else:
                        $color = "orange";
                        endif;
                        echo "<span class=".$color.">".$score_dom[$i]." - ".$score_ext[$i].'</span><br/>';
                        endfor;
                        else:
                        if($score_dom < $score_ext):
                        $color = "vert";
                        elseif($score_dom > $score_ext):
                        $color = "rouge";
                        else:
                        $color = "orange";
                        endif;
                        echo "<span class=".$color.">".$score_dom." - ".$score_ext.'</span><br/>';
                        endif;
                        endif;
                        else:
                        echo "<span>". $unMatch->remplace_heure() ."</span>";
                        endif; ?>
                    </div>
                </div>
                <div class="col-sm-1">
                    <a href="#" class="info">
                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div><?php
        endforeach;
    else :?>
        <p class='text-center'>Pas de résultats enregistrés pour cette saison.</p><?php
    endif;?>
</div>