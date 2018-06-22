<?php
$options = array('where' => 'date >= '. $now .' AND date < '. date_plus_7J($now) .' AND joue = 0', 'orderby' => 'date, heure');
$listeMatchs = $MatchManager->retourneListe($options);
// debug($listeMatchs);?>
<div class="legende">
    <i class="fa fa-info-circle" aria-hidden="true"></i>La liste des matchs prévus dans les 7 jours à venir
</div><?php
if(isset($_SESSION['rang'])):
    if($_SESSION['rang']==1):?>
        <img src="images/icon/png_black/doc-out.png" id="export_cal"/><?php
    endif;
endif; ?>
<div class="liste-matchs">
    <?php
    if(!empty($listeMatchs)):
        $jour_actuel = '';
        foreach($listeMatchs as $unMatch) :
            $options2 = array('where' => 'id = '. $unMatch->getCategorie());
            $uneCategorie = $CategorieManager->retourne($options2); ?>
            <div class="row">
                <div class="col-sm-2 date">
                    <div class="jour"><?=$unMatch->getJour();?></div>
                    <div class="mois"><?=$mois_de_lannee_min[$unMatch->getMois()-1];?></div>
                </div>
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
                                echo ($key > 0) ? " - " : "";
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
                    <div class="heure">
                        <span><?=$unMatch->remplace_heure();?></span>
                    </div>
                </div>
                <div class="col-sm-1">
                    <a href="#" class="info">
                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div><?php
        endforeach;
    else: ?>
        <p class="text-center">Pas de matchs à venir prochainement</p><?php
    endif;?>
</div>