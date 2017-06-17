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
        <div class="col-sm-12 icones hidden">
            <a href="//www.facebook.com/clocahandball?fref=ts" class="facebook"><span><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>Facebook</a>
            <a href="#" class="newsletter"><i class="fa fa-envelope" aria-hidden="true"></i>Newsletter</a>
            <a href="#" class="mobile"><i class="fa fa-mobile" aria-hidden="true"></i>Mobile</a>
            <a href="#" class="plan_du_site"><i class="fa fa-map-signs" aria-hidden="true"></i>Plan du site</a>
            <a href="contact.php" class="contact"><i class="fa fa-explication-circle" aria-hidden="true"></i>Contact</a>
        </div>
        <p class="col-sm-12 padding10 text-center">
            &copy; <a href="mailto:contact@clocahandball.fr">C.L.O.C.A. Handball</a> - <?=date('Y');?>
            &nbsp;&nbsp;Tous droits réservés
            &nbsp;&nbsp;<a href="#">Version <?// =derniereVersion(); ?></a>
        </p>
    </div>
</div>