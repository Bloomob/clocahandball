<div class="tab_container">
	<div class="tab_content2">
		<?php
			$MenuManagerManager = new Menu_managerManager($connexion);

			$options = array('where' => 'actif = 1 && parent = 0', 'orderby' => 'ordre');
			$listeMenuManager = $MenuManagerManager->retourneListe($options);

			foreach($listeMenuManager as $unMenuManager) {?>
				<div class="bloc_admin">
					<h2><?=$unMenuManager->getNom();?></h2>
					<div class="ligne_admin"><?php
						$options = array('where' => 'actif = 1 && parent = '.$unMenuManager->getId(), 'orderby' => 'ordre');
						$listeSousMenuManager = $MenuManagerManager->retourneListe($options);
						
						foreach($listeSousMenuManager as $unSousMenuManager){
							$lien = ($unSousMenuManager->getLien() != "")?"admin.php?page=".$unSousMenuManager->getLien():"admin.php";
								?>
							<a href="<?=$lien;?>" class="<?=$unSousMenuManager->getImage();?>"><?=$unSousMenuManager->getNom();?></a><?php
						}?>
					</div>
				</div><?php
			}
		?>
		<div class="clear_b"></div>
	</div>
</div>