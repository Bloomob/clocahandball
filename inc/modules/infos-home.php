<?php
$ActuManager = new ActualiteManager($connexion);

$options = array(
    'where' => 'date_publication >= "'. $annee_actuelle .'0701" AND (date_publication < '. date('Ymd') .' OR date_publication = '. date('Ymd') .' AND heure_publication < '. date('Hi') .') AND slider = 0 AND publie = 1',
    'orderby' => 'date_publication desc, heure_publication desc',
    'limit' => '0, 6'
);
$listeActu = $ActuManager->retourneListe($options);?>
<div class="wrapper plus">
    <h3><i class="fa fa-newspaper-o" aria-hidden="true"></i>Le fil actu</h3>
    <div class="contenu infos">
        <?php if(!empty($listeActu)):?>
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
    <nav>
        <a href="actualites.php" class="voir-plus">Voir toutes les actualités<i class="fa fa-plus" aria-hidden="true"></i></a>
    </nav>
</div>