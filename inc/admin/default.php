<div class="wrapper">
    <div class="row">
        <div class="col-xs-12">
            <?php
                $MenuManagerManager = new Menu_managerManager($connexion);

                $options = array('where' => 'actif = 1 && parent = 0', 'orderby' => 'ordre');
                $listeMenuManager = $MenuManagerManager->retourneListe($options);

                foreach($listeMenuManager as $unMenuManager) {?>
                    <div class="bloc-admin">
                        <h3><?=$unMenuManager->getNom();?></h3>
                        <div class="ligne-admin"><?php
                            $options = array('where' => 'actif = 1 && parent = '.$unMenuManager->getId(), 'orderby' => 'ordre');
                            $listeSousMenuManager = $MenuManagerManager->retourneListe($options);

                            foreach($listeSousMenuManager as $unSousMenuManager){
                                $lien = ($unSousMenuManager->getLien() != "")?"admin.php?page=".$unSousMenuManager->getLien():"admin.php";
                                    ?>
                                <a href="<?=$lien;?>"><i class="fa fa-<?=$unSousMenuManager->getImage();?>" aria-hidden="true"></i><?=$unSousMenuManager->getNom();?></a><?php
                            }?>
                        </div>
                    </div><?php
                }
            ?>
            <div class="bloc-admin">
                <h3>Application adhérent</h3>
                <div class="ligne-admin">
                    <a href='admin.php?page=afficher_tenue' id="afficher_tenue"><i class="fa fa-eye" aria-hidden="true"></i>Liste tenues</a>
                    <a href='admin.php?page=ajout_tenue' id="ajout_tenue"><i class="fa fa-plus" aria-hidden="true"></i>Ajout tenue</a>
                    <a href='admin.php?page=afficher_adherents' id="afficher_adherents"><i class="fa fa-eye" aria-hidden="true"></i>Liste adhérents</a>
                    <a href='admin.php?page=ajout_adherent' id="ajout_adherent"><i class="fa fa-plus" aria-hidden="true"></i>Ajout Adhérent</a>
                </div>
            </div>
        </div>
    </div>
</div>