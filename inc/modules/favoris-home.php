<?php
if(isset($_SESSION['id']) && !empty($_SESSION['id'])):
    $ClubManager = new ClubManager($connexion);
    $UtilisateurManager = new UtilisateurManager($connexion);

    $options = array('where' => 'id = '. $_SESSION['id']);
    $unUtilisateur = $UtilisateurManager->retourne($options);
    $listeFav = $unUtilisateur->getListe_equipes_favorites();

    $options = array('where' => 'date >= '. $now .' AND date < '. date_plus_7J($now) .' AND joue = 0 AND categorie IN ('. $listeFav .')', 'orderby' => 'date, heure');
    $listeMatchs = $MatchManager->retourneListe($options);
    // debug($listeMatchs);
    $i = 2; ?>

    <div class="wrapper plus">
        <h3><i class="fa fa-star" aria-hidden="true"></i>Favoris</h3>
        <div class="contenu tableau-bord"><?php
            // var_dump($listeMatchs);
            if(empty($listeFav)):?>
                <p>Pas d'équipe favorite pour le moment, cliquez <a href="mon_profil.php#fav">ici</a> pour en ajouter une</p><?php
            elseif(!empty($listeMatchs)):
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
                            <div class="col-sm-6 col-lg-6">
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
                            <div class="col-sm-6 col-lg-6">
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
                        <div class="col-sm-2 heure"><span><?=$unMatch->remplace_heure()?></span></div>
                        <!-- <div class="col-sm-2">
                            <span><a href="#"><i class="fa fa-flag" aria-hidden="true"></i></a></span>
                        </div> -->
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
            <a href="resultats_classements.php?onglet=matchs_a_venir" class="voir-plus">Voir tous les matchs à venir<i class="fa fa-plus" aria-hidden="true"></i></a>
        </nav>
    </div><?php
endif; ?>