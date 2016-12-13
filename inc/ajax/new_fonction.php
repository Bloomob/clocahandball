<?php
    function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    require_once("../connexion_bdd_pdo.php");
    require_once("../constantes.php");
    require_once("../fonctions.php");
    require_once("../date.php");

    $EquipeManager = new EquipeManager($connexion);
    $CategorieManager = new CategorieManager($connexion);
    $UtilisateurManager = new UtilisateurManager($connexion);
    $FonctionManager = new FonctionManager($connexion);
    $RoleManager = new RoleManager($connexion);

    if(!isset($_POST['id'])):
        $titre = "Ajout d'une fonction";
        $uneFonction = new Fonction(array());
    else:
        $titre = "Modification d'une fonction";
        $uneFonction = $FonctionManager->retourne($_POST['id']);
    endif;
?>
<div class="form">
    <div class="content">
        <h4><?=$titre;?></h4>
        <div class="pad">
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="utilisateur">Nom/Prénom</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input type="text" id="utilisateur" placeholder="Choisissez un utilisateur" value="">
                        <input type="hidden" id="id_utilisateur" class="require" placeholder="Choisissez un utilisateur" value="<?=$uneFonction->getId_utilisateur();?>">
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="type">Type</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="type" class="require" placeholder="Choisissez le type"><?php
                            $options = array('where' => 'parent = 0');
                            $listeRole = $RoleManager->retourneListe($options);
                            foreach ($listeRole as $role):?>
                                <option value="<?=$role->getId()?>"><?=$role->getNom()?></option><?php
                            endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="role">Rôle</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="role" class="require" placeholder="Choisissez le type"><?php
                            $options = array('where' => 'parent != 0', 'orderby' => 'parent, ordre');
                            $listeRole = $RoleManager->retourneListe($options);
                            foreach ($listeRole as $role):?>
                                <option value="<?=$role->getId()?>" data-parent="<?=$role->getParent()?>"><?=$role->getNom()?></option><?php
                            endforeach;

                            $options = array('orderby' => 'ordre');
                            $listeCategorie = $CategorieManager->retourneListe($options);
                            foreach ($listeCategorie as $categorie):?>
                                <option value="<?=$categorie->getId()?>"data-parent="4"><?=$categorie->getCategorieAll()?></option><?php
                            endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="boutons-actions">
        <a href="#" class="btn btn-save disable marginR">Sauvegarder</a>
        <a href="#" class="btn btn-annul">Annuler</a>
    </div>
</div>