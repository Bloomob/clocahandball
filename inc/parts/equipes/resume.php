<div class="row">
    <div class="col-xs-12"><?php
        if($detailsEquipe->getId_photo_equipe()):?>
            <div class="photo_groupe">
                <img src='images/equipe_lambda.png' alt='Lambda' width='100%' />
            </div><?php
        endif;?>
    </div>
    <div class="col-sm-12 infos marginT">
        <div class="bloc">
            <?php  ?>
            <h4><i class="fa fa-search" aria-hidden="true"></i>L'&eacute;quipe &agrave; la loupe</h4>
            <div class="row">
                <div class="col-sm-4">Niveau</div>
                <div class="col-sm-8"><?=$listeNiveau[$detailsEquipe->getNiveau()];?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">Championnat</div><?php
                $championnat = $listeChampionnat[$detailsEquipe->getChampionnat()]; ?>
                <div class="col-sm-8"><?=($championnat)?$championnat:'D&eacute;layage';?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">Entraineurs</div>
                <div class="col-sm-8"><?php
                $tab = explode(',', $detailsEquipe->getEntraineurs());
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
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Entrainements</div>
                <div class="col-sm-8"><?php
                $tab = explode(',', $detailsEquipe->getEntrainements());
                if(is_array($tab)):
                    foreach($tab as $entrainement):
                    $options = array('where' => 'id = '. $entrainement);
                        $unHoraire = $HoraireManager->retourne($options);
                        echo $jours[$unHoraire->getJour()].' de '.$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin()).' ('. $gymnases[$unHoraire->getGymnase()] .')<br/>';
                    endforeach;
                endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Bilan</div>
                <div class="col-sm-8"><?php
                    $liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
                    if(!empty($liste_stats)):
                        $bilan = '<span class="vert">'.$liste_stats['nb_vic'].'V</span> <span class="orange">'.$liste_stats['nb_nul'].'N</span> <span class="rouge">'.$liste_stats['nb_def'].'D</span>';
                    endif; ?>
                    <?=$bilan;?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">S&eacute;rie</div>
                <div class="col-sm-8"><?php
                    $serie = $MatchManager->cinq_derniers_matchs($laCategorie->getId());?>
                    <?=$serie;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="marginT">
    <div class="row">
        <div class="col-sm-6 dernieres_actus">
            <div class="bloc">
                <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Les dernières actus</h4>
                <?php
                $tag = $laCategorie->getRaccourci();
                $options = array('where' => 'tags LIKE "%'.$tag.'%" AND date_publication > '.$annee_actuelle.'0701', 'limit' => '0, 5');
                $listeActu = $ActualiteManager->retourneListe($options);
                // debug($listeActu);
                if(!empty($listeActu)):?>
                    <ul><?php
                        foreach($listeActu as $uneActu):?>
                            <li>
                                <a href="actualites.php?id=<?=$uneActu->getId();?>" class="puce<?=($uneActu->getImportance() == 1) ? ' important' : '';?>">
                                    <span class="date-info"><?=$uneActu->dateTypePublicationNews();?></span><?=$uneActu->getTitre();?>
                                </a>
                            </li>
                            <?php
                        endforeach;?>
                    </ul><?php
                else: ?>
                    <p>Pas d'actualité pour le moment</p><?php
                endif?>
            </div>
        </div>
        <div class="col-sm-6 saison_passee hidden">
            <div class="bloc">
                <h4><i class="fa fa-line-chart" aria-hidden="true"></i>La saison passee</h4><?php
                $liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle-1);
                if(is_array($liste_stats)) {?>
                    <p>Nombre de victoires : <?=$liste_stats['nb_vic'];?></p>
                    <p>Nombre de nuls : <?=$liste_stats['nb_nul'];?></p>
                    <p>Nombre de défaites : <?=$liste_stats['nb_def'];?></p>
                    <p>Nombre de buts pour : <?=$liste_stats['nb_bp'];?></p>
                    <p>Nombre de buts contre : <?=$liste_stats['nb_bc'];?></p><?php
                }
                else { ?>
                    <p>Pas de statistique sur la saison derni&egrave;re</p><?php
                }?>
            </div>
        </div>
    </div>
</div>