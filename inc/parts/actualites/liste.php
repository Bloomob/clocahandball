<div class="contenu">
    <h2><i class="fa fa-file-text" aria-hidden="true"></i><?=$titre?></h2>
    <div class="wrapper listeActus"><?php
    if(!empty($listeActualites)):
        foreach($listeActualites as $key => $uneActu):?>
        <!-- <div class="auteur_date"><span><?=$uneActu->getTags();?></span></div> --><?php
        if($uneActu->getImage() != ''):
        if($uneActu->getImportance() == 1):?>
        <div class="row importance1">
            <div class="col-sm-12">
                <div class="image"><?php
                    if(preg_match('/^images\//', $uneActu->getImage())):?>
                    <img src="<?=$uneActu->getImage();?>" alt /><?php
                    else: ?>
                    <img src="images/<?=$uneActu->getImage();?>.png" alt /><?php
                    endif;?>
                </div>
            </div>
            <div class="col-sm-12">
                <h3><a href="?theme=<?=$uneActu->getTheme();?>" class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></a><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></h3>
                <div class="contenu">
                    <p><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></p>
                    <p class="text-right"><a href="?id=<?=$uneActu->getId();?>" class="voir-plus">Lire plus<i class="fa fa-plus" aria-hidden="true"></i></a></p>
                </div>
            </div>
        </div><?php
        elseif($uneActu->getImportance() == 2):?>
        <div class="row importance2">
            <div class="col-sm-6">
                <div class="image"><?php
                    if(preg_match('/^images\//', $uneActu->getImage())):?>
                    <img src="<?=$uneActu->getImage();?>" alt /><?php
                    else: ?>
                    <img src="images/<?=$uneActu->getImage();?>.png" alt /><?php
                    endif;?>
                </div>
            </div>
            <div class="col-sm-6">
                <h3><a href="?theme=<?=$uneActu->getTheme();?>" class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></a><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></h3>
                <div class="contenu">
                    <p><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></p>
                    <p class="text-right"><a href="?id=<?=$uneActu->getId();?>" class="voir-plus">Lire plus<i class="fa fa-plus" aria-hidden="true"></i></a></p>
                </div>
            </div>
        </div><?php
        else:?>
        <div class="row importance3">
            <div class="col-sm-4">
                <div class="image"><?php
                    if(preg_match('/^images\//', $uneActu->getImage())):?>
                    <img src="<?=$uneActu->getImage();?>" alt /><?php
                    else: ?>
                    <img src="images/<?=$uneActu->getImage();?>.png" alt /><?php
                    endif;?>
                </div>
            </div>
            <div class="col-sm-8">
                <h3><a href="?theme=<?=$uneActu->getTheme();?>" class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></a><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></h3>
                <div class="contenu">
                    <p><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></p>
                    <p class="text-right"><a href="?id=<?=$uneActu->getId();?>" class="voir-plus">Lire plus<i class="fa fa-plus" aria-hidden="true"></i></a></p>
                </div>
            </div>
        </div><?php
        endif;
        else: ?>
        <div class="row">
            <div class="col-sm-12">
                <h3><a href="?theme=<?=$uneActu->getTheme();?>" class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></a><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></h3>
                <div class="contenu">
                    <p><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></p>
                    <p class="text-right"><a href="?id=<?=$uneActu->getId();?>" class="voir-plus">Lire plus<i class="fa fa-plus" aria-hidden="true"></i></a></p>
                </div>
            </div>
        </div><?php 
        endif;
        endforeach;
        else:?>
        <p>Aucune actualité pour le moment</p><?php
        endif;?>
    </div>
</div>