<?php
$ClubManager = new ClubManager($connexion);

$options = array('where' => 'date >= '. $now .' AND date < '. date_plus_7J($now) .' AND joue = 0', 'orderby' => 'date, heure');
$listeMatchs = $MatchManager->retourneListe($options);
// debug($listeMatchs);
$i = 2; ?>

<div class="wrapper plus">
	<h3><i class="fa fa-tachometer" aria-hidden="true"></i>Tableau de bord</h3>
	<div class="contenu tableau-bord"><?php
        // var_dump($listeMatchs);
        if(!empty($listeMatchs)):
            foreach($listeMatchs as $unMatch): ?>
                <div class="row">
                    <div class="col-xs-3 col-sm-2 col-lg-2 date">
                        <div class="jour"><?=$unMatch->getJour();?></div>
                        <div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
                    </div>
                    <div class="col-xs-2 col-sm-2 competition">
                        <div class="compet competition_<?=$unMatch->getCompetition();?>_<?=$unMatch->getNiveau();?>">
                            <span><?=($unMatch->getJournee()!=0)?'J'.$unMatch->getJournee():$unMatch->getTour();?></span>
                        </div>
                    </div><?php
                    $options2 = array('where' => 'id = '. $unMatch->getCategorie());
                    $uneCategorie = $CategorieManager->retourne($options2);
                    if($unMatch->getLieu() == 0):?>
                        <div class="col-xs-5 col-sm-4 match">
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
                        <div class="col-xs-5 col-sm-4 match">
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
                    endif; ?>
                    <div class="col-xs-2 col-sm-2 heure"><span><?=$unMatch->remplace_heure()?></span></div>
                    <div class="hidden-xs col-sm-2">
                        <a href="#" class="info"><span><i class="fa fa-info-circle" aria-hidden="true"></i></span></a>
                    </div>
                </div><?php
                $i++;
            endforeach;
        else: ?>
            <p>Pas de match pr&eacute;vu pour le moment</p><?php
        endif; ?>
        <!--<ul class="link hidden clearfix">
            <li><a href="resultats_classements.php?onglet=resultats_week-end">R&eacute;sultats du week-end</a></li>
            <li class="bg_none"><a href="resultats_classements.php?onglet=calendrier">Calendrier complet</a></li>
        </ul>-->
	</div>
    <nav>
        <a href="#" class="voir-plus">Voir plus<i class="fa fa-plus" aria-hidden="true"></i></a>
    </nav>
</div>