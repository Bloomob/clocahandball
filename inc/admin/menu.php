<?php
	$MenuManager = new MenuManager($connexion);

	$options = array('where' => 'parent = 0','orderby' => 'ordre');
	$listeMenus = $MenuManager->retourneListe($options);
	// $listeMenusTries = $MenuManager->triListe($listeMenus);
	// echo '<pre>';
	// var_dump($listeMenusTries);
	// echo '</pre>';
?>
<div class="tab_content2 menu">
	<h3>Menus</h3>
	<div class="boutons-actions menus-action">
		<div class="right">
			<a href="#" class="btn btn-save">Sauvegarder tout le menu</a>
		</div>
		<div class="clear_b"></div>
	</div>
	<div class="wrapper marginTB10">
		<div id="onglets">
			<div class="select-tabs">
				<ul><?php
					$i=0;
					foreach($listeMenus as $unMenu): ?>
						<li><a href="#tabs-<?=$i;?>"><?=$unMenu->getNom();?></a></li> <?php
						$i++;
					endforeach;?>
					<li class="locked"><a href="#tabs-<?=$i;?>">+</a></li>
				</ul>
			</div><?php
			$i=0;
			foreach($listeMenus as $unMenu): ?>
				<div id="tabs-<?=$i;?>" class="liste-tabs">
					<div class="paddingTB10 table">
						<div class="cell cell-1-2">
							<label for="menu-nom">Nom du menu</label><br/>
							<input id="menu-nom" type="text" value="<?=$unMenu->getNom();?>" />
						</div>
						<div class="cell cell-1-2">
							<label for="menu-url">URL du menu</label><br/>
							<input id="menu-url" type="text" value="<?=$unMenu->getURL();?>" />
						</div>
					</div>
					<div class="boutons-actions menu-action">
						<div class="left">
							<a href="#" class="btn btn-suppr">Supprimer le menu</a>
						</div>
						<div class="right"><?php
							if($unMenu->getActif()):?>
								<a href="#" class="btn btn-visiblity btn-invisible">Masquer le menu</a><?php
							else:?>
								<a href="#" class="btn btn-visiblity btn-visible">Afficher le menu</a><?php
							endif;?>
						</div>
						<div class="clear_b"></div>
					</div><?php
					$options = array('where' => 'parent = '.$unMenu->getId(), 'orderby' => 'ordre');
					$listeSousMenus = $MenuManager->retourneListe($options);
					if(!empty($listeSousMenus)):?>
						<div class="liste-menus sortable<?=(!$unMenu->getActif()) ? ' invisible' : '' ;?>"><?php
							$j = 0;
							foreach($listeSousMenus as $unSousMenu):?>
								<div class="sous-menu-<?=$j;?>">
									<h4><?=$unSousMenu->getNom();?><a href="<?=$j;?>" class="arrow-down right">D&eacute;tails</a></h4>
									<div style="display: none;">
										<div class="paddingTB10 table">
											<div class="cell cell-1-2">
												<label for="sous-menu-<?=$j;?>-nom">Nom du sous menu</label><br/>
												<input type="text" id="sous-menu-<?=$j;?>-nom" class="sous-menu-nom" value="<?=$unSousMenu->getNom();?>"/>
											</div>
											<div class="cell cell-1-2">
												<label for="sous-menu-<?=$j;?>-url">URL du sous menu</label><br/>
												<input type="text" id="sous-menu-<?=$j;?>-url" class="sous-menu-url" value="<?=$unSousMenu->getURL();?>"/>
											</div>
										</div>
										<div class="boutons-actions sous-menus-action">
											<div class="left">
												<a href="#" class="btn btn-suppr">Supprimer</a>
											</div>
											<div class="clear_b"></div>
										</div>
									</div>
								</div><?php
								$j++;
							endforeach;?>
						</div><?php
					else:?>
						<div class="liste-menus<?=(!$unMenu->getActif()) ? ' invisible' : '' ;?>">
							<p>Pour cr&eacute;er un sous-menu, cliquer sur le bouton.</p>
						</div><?php
					endif;?>
					<div class="boutons-actions sous-menus-action">
						<div class="right">
							<a href="#" class="btn btn-ajout">Ajouter un sous-menu</a>
						</div>
						<div class="clear_b"></div>
					</div>
				</div><?php
				$i++;
			endforeach;?>
			<div id="tabs-<?=$i;?>" class="liste-tabs">
				<div class="paddingTB10 table">
						<div class="cell cell-1-2">
							<label for="nv_menu_nom">Nom du menu</label><br/>
							<input id="nv_menu_nom" type="text" value="" />
						</div>
						<div class="cell cell-1-2">
							<label for="nv_menu_url">URL du menu</label><br/>
							<input id="nv_menu_url" type="text" value="" />
						</div>
					</div>
				<div class="boutons-actions menu-action">
					<div class="right">
						<a href="#" class="btn btn-ajout">Ajouter un menu</a>
					</div>
					<div class="clear_b"></div>
				</div>
			</div>
		</div>
	</div>
</div>