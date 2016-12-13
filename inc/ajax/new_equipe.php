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
    $HoraireManager = new HoraireManager($connexion);

    if(!isset($_POST['id'])):
        $titre = "Ajout d'une equipe";
        $uneEquipe = new Equipe(array());
    else:
        $titre = "Modification d'une equipe";
        $uneEquipe = $EquipeManager->retourne($_POST['id']);
    endif;
?>
<div class="form">
    <div class="content">
        <h4><?=$titre;?></h4>
        <div class="pad">
            <div class="wrap marginTB10"><?php
                $options = array('orderby' => 'ordre');
                $listeCategorie = $CategorieManager->retourneListe($options); ?>
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="categorie">Categories :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="categorie" class="require">
                            <option value="-">Choisissez une catégorie</option><?php
                            foreach ($listeCategorie as $uneCategorie): ?>
                                <option value="<?=$uneCategorie->getId();?>" <?=($uneEquipe->getCategorie()==$uneCategorie->getId())?'selected':'';?>><?=$uneCategorie->getCategorieAll();?></option><?php
                            endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10"><?php
                $listeNiveau = liste_niveau(); ?>
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="niveau">Niveau :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="niveau" class="require">
                            <option value="-">Choisissez un niveau</option><?php
                            foreach ($listeNiveau as $id => $nom): ?>
                                <option value="<?=$id;?>" <?=($uneEquipe->getNiveau()==$id)?'selected':'';?>><?=$nom;?></option><?php
                            endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10"><?php
                $listeChampionnat = liste_championnat(); ?>
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="championnat">Championnat :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="championnat" class="require">
                            <option value="0">Choisissez un championnat</option><?php
                            foreach ($listeChampionnat as $id => $nom): ?>
                                <option value="<?=$id;?>" <?=($uneEquipe->getChampionnat()==$id)?'selected':'';?>><?=$nom;?></option><?php
                            endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="entraineurs">Entraineur(s) :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="liste_entraineurs"></div>
                        <input type="text" id="entraineurs" placeholder="Choisissez un entraineur">
                        <input type="hidden" id="liste_id_entraineurs" class="require" value="<?=$uneEquipe->getEntraineurs();?>">
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10"><?php
                $options = array('where' => 'annee = '. $annee_actuelle, 'orderby' => 'jour, heure_debut');
                $listeHoraire = $HoraireManager->retourneListe($options); ?>
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="horaire">Horaires :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="horaire" class="require" multiple>
                            <option value="-">Choisissez un horaire</option>
                            <?php foreach ($listeHoraire as $unHoraire): ?>
                                <option value="<?=$unHoraire->getId();?>" data-id="<?=$unHoraire->getCategorie();?>" <?=($uneEquipe->getEntrainements()==$unHoraire->getId())?'selected':'';?>><?=$jours[$unHoraire->getJour()];?> de <?=$unHoraire->remplace_heure($unHoraire->getHeure_debut()).' &agrave; '.$unHoraire->remplace_heure($unHoraire->getHeure_fin());?> (<?=$unHoraire->getGymnase();?>)</option><?php
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