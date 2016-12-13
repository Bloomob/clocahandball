<?php
	$MenuManager = new MenuManager($connexion);
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <nav>
                <ul><?php
                    $options = array('where' => 'parent = 0 AND actif = 1', 'orderby' => 'ordre');
                    $listeMenusParent = $MenuManager->retourneListe($options);
                    $nbrMenus = count($listeMenusParent);
                    $i=1;
                    if(!empty($listeMenusParent)):
                        foreach($listeMenusParent as $key => $unMenuParent):?>
                            <li><h4><a href="<?=$unMenuParent->getUrl();?>.php"><?=$unMenuParent->getNom();?></a></h4></li><?php
                            if($unMenuParent->getUrl() == 'actualites'):
                                $options2 = array('where' => 'url LIKE "actualites" && actif = 1', 'orderby' => 'ordre');
                                $listeSousMenusActualites = $MenuManager->retourneListe($options2);
                                if(!empty($listeSousMenusActualites)):
                                    unset($tabTheme['']);
                                    foreach($tabTheme as $url => $unTheme):?>
                                        <li><a href="<?=$unMenuParent->getUrl();?>.php?onglet=<?=$url;?>"><?=$unTheme;?></a></li><?php
                                    endforeach;
                                endif;
                            elseif($unMenuParent->getUrl() == 'equipes'):
                                $options2 = array('where' => 'url LIKE "equipes" && actif = 1');
                                $unMenu = $MenuManager->retourne($options2);

                                $options2 = array('where' => 'actif = 1', 'orderby' => 'ordre');
                                $listeCategories = $CategorieManager->retourneListe($options2);

                                if(!empty($unMenu) && !empty($listeCategories)): 
                                    foreach($listeCategories as $uneCategorie):
                                        $options3 = array('where' => 'annee = '. retourne_annee().' AND categorie = '. $uneCategorie->getId() .' AND actif = 1');
                                        $uneEquipe = $EquipeManager->retourne($options3);
                                        if($uneEquipe->getId()>0):
                                            $rac = retourneRaccourciById($uneCategorie->getId());
                                            $cat = retourneCategorieById($uneCategorie->getId());?>
                                            <li><a href="equipes.php?onglet=<?=$rac?>"> <?=$cat?></a></li><?php
                                        endif;
                                    endforeach;
                                endif;
                            else:
                                $options2 = array('where' => 'parent = '.$unMenuParent->getId().' AND actif = 1', 'orderby' => 'ordre');
                                $listeMenus = $MenuManager->retourneListe($options2);
                                if(!empty($listeMenus)):
                                    foreach($listeMenus as $key => $unMenu):?>
                                        <li><a href="<?=$unMenuParent->getUrl();?>.php?onglet=<?=$unMenu->getUrl();?>"><?=$unMenu->getNom();?></a></li><?php
                                    endforeach;
                                endif;
                            endif;
                            if($i%ceil($nbrMenus/4) == 0)
                                echo '</ul></nav><nav><ul>';
                            $i++;
                        endforeach;
                    else:?>
                        <li><h4><a href="index.php">Accueil</a></h4></li><?php
                    endif;
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
                <a href="//www.facebook.com/clocahandball?fref=ts" class="facebook"><span></span>Facebook</a>
                <a href="#" class="newsletter"><span></span>Newsletter</a>
                <a href="#" class="mobile"><span></span>Mobile</a>
                <a href="#" class="plan_du_site"><span></span>Plan du site</a>
                <a href="#" class="mentions_legales"><span></span>Mentions légales</a>
                <a href="contact.php" class="contact"><span></span>Contact</a>
            </div>
            <p class="clear_b padding10">
                &copy; <a href="mailto:contact@clocahandball.fr">C.L.O.C.A. Handball</a> - <?=date('Y');?>
                &nbsp;&nbsp;Tous droits réservés
                &nbsp;&nbsp;<a href="#">Version <?// =derniereVersion(); ?></a>
            </p>
        </div>
    </div>
</div>