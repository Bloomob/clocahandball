<?php
$ActuManager = new ActualiteManager($connexion);
$options = array('where' => '(date_publication < '. date('Ymd') .' OR date_publication = '. date('Ymd') .' AND heure_publication = '. date('Hi') .') AND slider = 1', 'orderby' => 'date_publication desc, heure_publication desc', 'limit' => '0, 4');
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
				<div class="item <?=($num==0)?"active":"";?>">
					<!--<img src="images/<?=$uneActu->getImage();?>.png" alt="" />-->
					<img src="images/temp/fond_psg.jpeg" alt="" />
					<div class="carousel-caption">
						<div class="theme <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></div>
						<div class="titre"><?=$uneActu->getTitre();?></div>
						<div class="sous_titre">
							<?=substr(stripslashes($uneActu->getSous_titre()),0 , 125);?>
							<?=(strlen(stripslashes($uneActu->getSous_titre())) > 125) ? '...': '';?>
						</div>
					</div>
				</div><?php
			endforeach;?>
		</div>
	</div><?php
endif; ?>