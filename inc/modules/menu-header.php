<nav id="navbar">
	<ul class="menu">
		<?php
		$options = array('where' => 'parent = 0 && actif = 1', 'orderby' => 'ordre');
		$listeMenus = $MenuManager->retourneListe($options);
		if(!empty($listeMenus)):
			foreach($listeMenus as $key => $unMenu):?>
				<li id="navbar-item-<?php echo $unMenu->getId();?>">
					<a href="<?php echo $unMenu->getUrl();?>.php" <?php echo ($page==$unMenu->getUrl())?'class="active"':''; ?>>
						<span>
							<span>
								<?php echo ($unMenu->getImage() != '') ? $unMenu->getImage() : $unMenu->getNom();?>
								<!--Accueil <img src="images/home.png" alt="home" height="35px;"/>-->
							</span>
						</span>
					</a>
				</li><?php
			endforeach;
		else:?>
			<li id="navbar-item-1"><a href="index.php" <?php echo ($page=='index')?'class="active"':''; ?>><span><span>Accueil</span></span></a></li><?php
		endif; ?>
	</ul>
	<?php
	$options = array('where' => 'parent != 0 && actif = 1', 'orderby' => 'parent, ordre');
	$listeSousMenus = $MenuManager->retourneListe($options);
	$parent = 0;
	if(!empty($listeSousMenus)):
		foreach($listeSousMenus as $key => $unSousMenu):
			if($unSousMenu->getParent() != $parent):
				if(0 != $parent):?>
					</ul></div><?php
				endif;?>
				<div id="navbar-subnav-<?=$unSousMenu->getParent();?>" class="sous_menu"><ul class="col"><?php
			endif;
			if($MenuManager->existeId($unSousMenu->getParent())):
				$options = array('where' => 'id = '.$unSousMenu->getParent().' && actif = 1');
				$unMenu = $MenuManager->retourne($options); ?>
				<li><a href="<?=$unMenu->getUrl();?>.php?onglet=<?=$unSousMenu->getUrl();?>"><?=$unSousMenu->getNom();?></a></li><?php			
				$parent = $unSousMenu->getParent();
			endif;
		endforeach;?>
		</ul></div><?php
	endif;

	$options = array('where' => 'url LIKE "actualites" && actif = 1');
	$menuActualite = $MenuManager->retourne($options);
	if(!empty($menuActualite)):?>
		<div id="navbar-subnav-<?=$menuActualite->getId();?>" class="sous_menu" >
			<ul class="col"><?php
			unset($tabTheme['']);
			foreach($tabTheme as $url => $unTheme):?>
				<li><a href="actualites.php?onglet=<?=$url?>"> <?=$unTheme?></a></li><?php
			endforeach;
			?>
			</ul>
		</div><?php
	endif;

	$options = array('where' => 'url LIKE "equipes" && actif = 1');
	$unMenu = $MenuManager->retourne($options);
	
	$options = array('where' => 'actif = 1', 'orderby' => 'ordre');
	$listeCategories = $CategorieManager->retourneListe($options);

	if(!empty($unMenu) && !empty($listeCategories)): ?>
		<div id="navbar-subnav-<?=$unMenu->getId();?>" class="sous_menu" >
			<ul class="col"><?php
				foreach($listeCategories as $uneCategorie):
					$options = array('where' => 'annee = '. retourne_annee().' AND categorie = '. $uneCategorie->getId() .' AND actif = 1');
					$uneEquipe = $EquipeManager->retourne($options);
					if($uneEquipe->getId()>0):
						$rac = retourneRaccourciById($uneCategorie->getId());
						$cat = retourneCategorieById($uneCategorie->getId());?>
						<li><a href="equipes.php?onglet=<?=$rac?>"> <?=$cat?></a></li><?php
					endif;
				endforeach;?>
			</ul>
		</div><?php
	endif; ?>
</nav>