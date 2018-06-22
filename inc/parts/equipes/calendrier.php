<?php
// var_dump($laCategorie->getId(), $annee_actuelle, $annee_suiv);
$options = array('where' => 'categorie = '. $laCategorie->getId() .' AND date > '. $annee_actuelle .'0701 AND date < '. $annee_suiv .'0630', 'orderby' => 'date, heure');
$listeMatchs = $MatchManager->retourneListe($options);
// debug($listeMatchs);
if(!empty($listeMatchs)):?>
    <div class="calendrier">
        <div class="wrapper"><?php
            if(!empty($listeMatchs)):
                foreach($listeMatchs as $unMatch): ?>
                    <div class="row">
                        <div class="col-sm-2 col-lg-2 date">
                            <div class="jour"><?=$unMatch->getJour();?></div>
                            <div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
                        </div>
                        <div class="col-sm-2">
                            <div class="compet competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
                                <span><?=($unMatch->getJournee()!=0)?'J'.$unMatch->getJournee():$unMatch->getTour();?></span>
                            </div>
                        </div><?php
                        $options2 = array('where' => 'id = '. $unMatch->getCategorie());
                        $uneCategorie = $CategorieManager->retourne($options2);
                        if($unMatch->getLieu() == 0):?>
                            <div class="col-sm-4">
                                <div class="dom puce"><div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a></div>
                                <div class="ext"><?php
                                    $tab = explode(',', $unMatch->getAdversaires());
                                    if(is_array($tab) ):
                                        foreach($tab as $key => $club):
                                            if($key > 0) { echo " - "; }
                                            $unClub = $ClubManager->retourne($club);
                                            echo stripslashes($unClub->getRaccourci())." ".$unClub->getNumero();
                                        endforeach;
                                    endif; ?>
                                </div>
                            </div><?php
                        else: ?>
                            <div class="col-sm-4">
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
                                <div class="ext puce"><div class="cat_<?=$uneCategorie->getRaccourci();?>"></div><a href="equipes.php?onglet=<?=$uneCategorie->getRaccourci();?>"><strong><?=$uneCategorie->getCategorie();?> <?=substr($uneCategorie->getGenre(),0,1);?><?=$uneCategorie->getNumero();?></strong></a></div>
                            </div><?php
                        endif;?>
                        <div class="col-sm-2"><?php
                            if(!$unMatch->getJoue()):?>
                                <div class="heure"><span><?=$unMatch->remplace_heure()?></span></div><?php
                            else:?>
                                <div class="scores"><?php
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
                                    endif;?>
                                </div><?php
                            endif;?>
                        </div>
                        <div class="col-sm-2">
                            <a href="#" class="info"><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a>
                        </div>
                    </div><?php
                endforeach;
            else: ?>
                <p>Pas de match pr&eacute;vu pour le moment</p><?php
            endif; ?>
        </div>
    </div><?php
endif;?>