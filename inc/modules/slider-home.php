<?php
$ActuManager = new ActualiteManager($connexion);
$options = array('where' => '(date_publication < '. date('Ymd') .' OR date_publication = '. date('Ymd') .' AND heure_publication < '. date('Hi') .') AND slider = 1 AND date_publication > 20170701', 'orderby' => 'date_publication desc, heure_publication desc', 'limit' => '0, 3');
$listeActualites = $ActuManager->retourneListe($options);

if(is_array($listeActualites)): ?>
	<div id="carousel-home" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators"><?php
			foreach($listeActualites as $num => $uneActu):?>
				<li data-target="#carousel-home" data-slide-to="<?=$num;?>" <?=($num==0)?"class='active'":"";?>></li><?php
			endforeach;?>
		</ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox"><?php
			foreach($listeActualites as $num => $uneActu):?>
				<a href="actualites.php?id=<?=$uneActu->getId();?>" class="item <?=($num==0)?"active":"";?>">
					<img src="<?=$uneActu->getImage();?>" alt="" />
                    <div class="theme <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></div>
					<div class="carousel-caption">
						<div class="titre"><?=$uneActu->getTitre();?></div>
						<div class="sous_titre">
							<?=substr(stripslashes($uneActu->getSous_titre()),0 , 200);?>
							<?=(strlen(stripslashes($uneActu->getSous_titre())) > 200) ? '...': '';?>
						</div>
					</div>
				</a><?php
			endforeach;
            ?>
		</div>
	</div><?php
endif; ?>