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
        </div>
    </div>
</div>