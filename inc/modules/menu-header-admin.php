<nav id="navbar">
    <ul class="menu">
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