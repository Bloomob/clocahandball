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

    $CategorieManager = new CategorieManager($connexion);
    $EquipeManager = new EquipeManager($connexion);
    $ClubManager = new ClubManager($connexion);
    $MatchManager = new MatchManager($connexion);
?>

<div class="form">
    <div class="content">
        <h4>Ajout d'un championnat</h4>
        <div class="pad">
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="categorie">Categorie</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="categorie" class="require">
                            <option value="">Entrer la catégorie</option><?php
                            $options = array("where" => "annee = ". $annee_actuelle);
                            $listeEquipe = $EquipeManager->retourneListe($options);
                            $tab = array();
                            foreach($listeEquipe as $uneEquipe):
                                $tab[] = $uneEquipe->getCategorie();
                            endforeach;
                            $listeIdCat = implode(',', $tab);
                            $options = array("where" => 'id IN ('. $listeIdCat .')',"orderby" => "ordre");
                            $listeCategorie = $CategorieManager->retourneListe($options);
                            foreach($listeCategorie as $uneCat):?>
                                <option value="<?=$uneCat->getId();?>"><?=$uneCat->getCategorieAll();?></option><?php
                            endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table champ">
                    <div class="row head">
                        <div class="cell cell-1-20 cell-head">Lieu</div>
                        <div class="cell cell-1-2 cell-head">Adversaires</div>
                        <div class="cell cell-1-5 cell-head">Date aller</div>
                        <div class="cell cell-1-5 cell-head">Date retour</div>
                        <div class="cell cell-1-20 cell-head"></div>
                    </div>
                    <div class="row">
                        <div class="cell">
                            <select id="lieu" class="require">
                                <option value="">-</option><?php
                                foreach($lieu as $key => $unLieu):?>
                                    <option value="<?=$key;?>" ><?=strtoupper(substr($unLieu,0,3));?></option><?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="cell">
                            <div class="tabAdversaires">
                                <div class="liste boutons-actions"></div>
                                <input class="choixAdversaire" type="text" placeholder="Entrez un adversaire"/>
                                <input class="valeurs require" type="hidden" />
                            </div>
                        </div>
                        <div class="cell aller">
                            <input class="datepicker require date_aller" type="hidden" value="">
                            <span class="date"></span>
                            <span class="heure" style="display: none;"> à 
                                <select>
                                    <option value="0">-</option><?php
                                    for($i=900;$i<2130;$i+=15):
                                        if(substr($i, -2)==60) $i+=40;?>
                                        <option value="<?=$i;?>"><?=substr($i,0,-2);?>h<?=substr($i,-2);?></option><?php
                                    endfor; ?>
                                </select>
                            </span>
                        </div>
                        <div class="cell retour">
                            <input class="datepicker date_retour" type="hidden" value="">
                            <span class="date"></span>
                            <span class="heure" style="display: none;"> à 
                                <select>
                                    <option value="0">-</option><?php
                                    for($i=900;$i<2130;$i+=15):
                                        if(substr($i, -2)==60) $i+=40;?>
                                        <option value="<?=$i;?>"><?=substr($i,0,-2);?>h<?=substr($i,-2);?></option><?php
                                    endfor; ?>
                                </select>
                            </span>
                        </div>
                        <div class="cell supprEquipe">
                            <div class="boutons-actions">
                                <a href="#" class="btn btn-picto btn-slim btn-annul hidden">Supprimer une équipe</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="row">
                        <div class="cell">
                            <div class="boutons-actions">
                                <a href="#" class="btn btn-ajout addEquipe">Ajouter une équipe</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="boutons-actions">
        <a href="#" class="btn btn-save save-champ disable marginR">Sauvegarder</a>
        <a href="#" class="btn btn-annul">Annuler</a>
    </div>
</div>