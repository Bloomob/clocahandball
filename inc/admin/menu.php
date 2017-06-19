<?php
	$MenuManager = new MenuManager($connexion);

	$options = array('where' => 'parent = 0','orderby' => 'ordre');
	$listeMenus = $MenuManager->retourneListe($options);
	// $listeMenusTries = $MenuManager->triListe($listeMenus);
	// echo '<pre>';
	// var_dump($listeMenusTries);
	// echo '</pre>';
?>
<div class="row">
	<div class="col-xs-12">
        <h3>Menus</h3>
    </div>
    <div class="col-xs-12 text-right">
       <button class="btn btn-warning save-all"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauvegarder le menu</a>
    </div>
	<div class="col-xs-12">
        <div class="menu">
            <div class="liste-tabs">
                <ul class="nav nav-tabs" role="tablist"><?php
                    $i=0;
                    foreach($listeMenus as $unMenu): ?>
                        <li role="presentation" class="<?=($i===0)?'active':'';?>"><a href="#tab-<?=$unMenu->getId();?>" aria-controls="<?=$unMenu->getNom();?>" role="tab" data-toggle="tab"><?=$unMenu->getNom();?></a></li><?php
                        $i++;
                    endforeach;?>
                    <li role="presentation" class="locked"><a href="#tabs-<?=$i;?>">+</a></li>
                </ul>
            </div>
            <div class="tab-content"><?php
            $i=0;
            foreach($listeMenus as $unMenu): ?>
                <div role="tabpanel" class="tab-pane <?=($i===0)?'active':'';?>" id="tab-<?=$unMenu->getId();?>">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="menu-nom">Nom du menu</label>
                                </div>
                                <div class="col-sm-7 form-group">
                                    <input id="menu-nom" type="text" value="<?=$unMenu->getNom();?>" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="menu-url">URL du menu</label>
                                </div>
                                <div class="col-sm-7 form-group">
                                    <input id="menu-url" type="text" value="<?=$unMenu->getURL();?>" class="form-control" />                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group"><?php
                                if($unMenu->getActif()):?>
                                    <button href="#" class="btn btn-primary" title="Masquer le menu">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Masquer
                                </button><?php
                                else:?>
                                    <button href="#" class="btn btn-primary" title="Afficher le menu">
                                    <i class="fa fa-eye" aria-hidden="true"></i> Afficher
                                </button><?php
                                endif;?>
                                <button href="#" class="btn btn-danger" title="Supprimer le menu">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div><?php
                    $options = array('where' => 'parent = '.$unMenu->getId(), 'orderby' => 'ordre');
                    $listeSousMenus = $MenuManager->retourneListe($options);
                    if(!empty($listeSousMenus)):?>
                        <div class="liste-menus sortable<?=(!$unMenu->getActif()) ? ' invisible' : '' ;?>"><?php
                            $j = 0;
                            foreach($listeSousMenus as $unSousMenu):?>
                                <div class="sous-menu-<?=$j;?>">
                                    <h4><?=$unSousMenu->getNom();?><a href="<?=$j;?>" class="arrow-down right">D&eacute;tails</a></h4>
                                    <div class="hidden">
                                        <div class="paddingTB10 row">
                                            <div class="col-xs-6">
                                                <label for="sous-menu-<?=$j;?>-nom">Nom du sous menu</label><br/>
                                                <input type="text" id="sous-menu-<?=$j;?>-nom" class="sous-menu-nom" value="<?=$unSousMenu->getNom();?>"/>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="sous-menu-<?=$j;?>-url">URL du sous menu</label><br/>
                                                <input type="text" id="sous-menu-<?=$j;?>-url" class="sous-menu-url" value="<?=$unSousMenu->getURL();?>"/>
                                            </div>
                                        </div>
                                        <div class="row boutons-actions sous-menus-action">
                                            <div class="col-xs-6">
                                                <a href="#" class="btn btn-suppr">Supprimer</a>
                                            </div>
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
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="btn btn-success add-menu"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un sous-menu</a>
                        </div>
                    </div>
                </div><?php
                $i++;
            endforeach;?>
            <!--<div id="tab-<?=$unMenu->getId();?>" class="liste-tabs">
                <div class="paddingTB10 row">
                        <div class="col-xs-6">
                            <label for="nv_menu_nom">Nom du menu</label><br/>
                            <input id="nv_menu_nom" type="text" value="" />
                        </div>
                        <div class="col-xs-6">
                            <label for="nv_menu_url">URL du menu</label><br/>
                            <input id="nv_menu_url" type="text" value="" />
                        </div>
                    </div>
                <div class="row boutons-actions menu-action">
                    <div class="col-xs-6">
                        <a href="#" class="btn btn-ajout">Ajouter un menu</a>
                    </div>
                </div>
            </div>-->
        </div>
	</div>
</div>