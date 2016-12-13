<?php 
	$MenuManager = new MenuManager($connexion);
	$MenuManagerManager = new Menu_managerManager($connexion);
	$EquipeManager = new EquipeManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
?>
<div id="entete">
	<h1><a href="#" id="logo"><img src="images/prev.png" alt="Prev" />C.L.O.C.A. HANDBALL</a><span id="slogan">Le site officiel du Handball Ach&egrave;rois</span></h1>
	<div class="right">
		<nav>
			<ul id="top_nav"><?php 
				if(isset($_SESSION['prenom']) && isset($_SESSION['nom'])) { ?>
					<li><a href='deconnexion.php' id="se_deconnecter">Se d&eacute;connecter</a></li><?php
				} else { ?>
					<li><a href='#' id="se_connecter">Se connecter</a></li>
					<li><a href='#' id="s_inscrire">S'inscrire</a></li><?php
				} if(isset($_SESSION['rang']) && $_SESSION['rang']) {?>
					<li><a href='admin.php'>Admin</a></li><?php
				}?>
				<li><a href='contact.php'>Contact</a></li>
			</ul>
		</nav>
	</div>
	<div id="connexion">
		<img src="images/fermer.png" id="fermer"/>
		<div class="c_contenu">
			<form method="post" action="">
				<label for="login">Login</label><br/>
				<input type="text" id="login" name="login"/><br /><br />
				<label for="mot_de_passe">Mot de passe</label><br />
				<input type="password" id="mot_de_passe" name="mot_de_passe"/><br /><br />
				<input type="submit" id="bouton_connexion" name="bouton_connexion" value="SE CONNECTER"/>
			</form>
		</div>
	</div>
</div>
<nav id="navbar">
	<ul id="menu">
		<li id="navbar-item-0">
			<a href="index.php">
				<span>
					<span>
						Accueil
					</span>
				</span>
			</a>
		</li>
		<?php
		$options = array('where' => 'actif = 1 && parent = 0', 'orderby' => 'ordre');
		$listeMenuManager = $MenuManagerManager->retourneListe($options);

		foreach($listeMenuManager as $unMenuManager) {?>
			<li id="navbar-item-<?=$unMenuManager->getId();?>">
				<a href="#">
					<span>
						<span>
							<?=$unMenuManager->getNom();?>
						</span>
					</span>
				</a>
			</li><?php
		}?>
	</ul>
	<?php
	$options = array('where' => 'parent != 0 && actif = 1', 'orderby' => 'parent, ordre');
	$listeSousMenuManager = $MenuManagerManager->retourneListe($options);
	$parent = 0;
	if(!empty($listeSousMenuManager)):
		foreach($listeSousMenuManager as $key => $unSousMenuManager):
			if($unSousMenuManager->getParent() != $parent):
				if(0 != $parent):?>
					</ul></div><?php
				endif;?>
				<div id="navbar-subnav-<?=$unSousMenuManager->getParent();?>" class="sous_menu"><ul class="col"><?php
			endif;
			if($MenuManagerManager->existeId($unSousMenuManager->getParent())):
				$options = array('where' => 'id = '.$unSousMenuManager->getParent().' && actif = 1');
				$unMenuManager = $MenuManagerManager->retourne($options); ?>
				<li><a href="admin.php?page=<?=$unSousMenuManager->getLien();?>"><?=$unSousMenuManager->getNom();?></a></li><?php			
				$parent = $unSousMenuManager->getParent();
			endif;
		endforeach;?>
		</ul></div><?php
	endif; ?>
</nav>

<?php /*
<nav id="navbar">
	<ul id="menu">
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

*/ ?>