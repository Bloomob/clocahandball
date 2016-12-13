<?php    
    function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    require_once("../connexion_bdd_pdo.php");
    require_once("../constantes.php");
    require_once("../fonctions.php");

    $EquipeManager = new EquipeManager($connexion);
    $CategorieManager = new CategorieManager($connexion);
    $ClubManager = new ClubManager($connexion);
    $MatchManager = new MatchManager($connexion);

    if(!isset($_POST['matchId'])):
        $titre = "Ajout d'un match";
        $unMatch = new Match(array());
    else:
        $titre = "Modification d'un match";
        $unMatch = $MatchManager->retourne($_POST['matchId']);
    endif;
?>

<div class="form">
    <div class="content">
        <h4><?=$titre;?></h4>
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
                                <option value="<?=$uneCat->getId();?>" <?=$unMatch->getCategorie()==$uneCat->getId()?"selected":"";?>><?=$uneCat->getCategorieAll();?></option><?php
                            endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="date_publication">Date du match</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input class="datepicker require" id="date" type="hidden" value="<?=$unMatch->getDate()==0?"":$unMatch->getDate();?>">
                        <span class="date"><?=$unMatch->getDate()==0?"Aucune date selectionnée":$unMatch->getJour()." ".$mois_de_lannee[intval($unMatch->getMois())-1]." ".$unMatch->getAnnee();?></span>
                        <span class="heure" style="display: none;"> à 
                            <select id="heure">
                                    <option value="0">-</option><?php
                                for($i=900;$i<2130;$i+=15):
                                    if(substr($i, -2)==60) $i+=40;?>
                                    <option value="<?=$i;?>" <?=($i==$unMatch->getHeure())?'selected':'';?>><?=substr($i,0,-2);?>h<?=substr($i,-2);?></option><?php
                                endfor; ?>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="competition">Competition</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="competition">
                            <option value="">Entrer la competition</option><?php
                            foreach($listeCompetition as $key => $uneCompet):?>
                                <option value="<?=$key;?>" <?=$unMatch->getCompetition()==$key?"selected":"";?>><?=$uneCompet;?></option><?php
                            endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10 journee_tour" style="display: none;">
                 <div class="table">
                    <div class="cell cell-1-5"><?php
                        if($unMatch->getCompetition()==1 || $unMatch->getCompetition()==4):
                            echo '<label for="journee">Journée</label>';
                        elseif($unMatch->getCompetition()==2 || $unMatch->getCompetition()==3):
                            echo '<label for="tour">Tour</label>';
                        endif; ?>
                    </div>
                    <div class="cell cell-4-5"><?php
                        $numeric = ($unMatch->getCompetition()==1 || $unMatch->getCompetition()==4)?'numeric':'';
                        $placeholder = ($unMatch->getCompetition()==1 || $unMatch->getCompetition()==4)?'Entrez la journée':'Entrez le tour';
                        $value = ($unMatch->getCompetition()==1 || $unMatch->getCompetition()==4)?$unMatch->getJournee():$unMatch->getTour();
                        $id = ($unMatch->getCompetition()==1 || $unMatch->getCompetition()==4)?'journee':'tour';
                        ?>
                        <input type="text" id="<?=$id;?>" class="require min_input <?=$numeric;?>" placeholder="<?=$placeholder;?>" value="<?=$value;?>"/>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="lieu">Lieu</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect lieu require">
                            <input type="button" class="select <?=($unMatch->getLieu()==0 && $unMatch->getId()!=0)?'actif':'';?>" value="Domicile" data-value="0" />
                            <input type="button" class="select <?=($unMatch->getLieu()==1 && $unMatch->getId()!=0)?'actif':'';?>" value="Exterieur" data-value="1" />
                            <input type="button" class="select <?=($unMatch->getLieu()==2 && $unMatch->getId()!=0)?'actif':'';?>" value="Neutre" data-value="2" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10 depLieu">
                <div class="table tabAdversaires"><?php
                    if($unMatch->getAdversaires() != 0):
                        $tabAdversaires = explode(',', $unMatch->getAdversaires());
                        $tabScoreDom = explode(',', $unMatch->getScores_dom());
                        $tabScoreExt = explode(',', $unMatch->getScores_ext());
                        foreach ($tabAdversaires as $key => $adversaire): ?>
                            <div class="row adversaire">
                                <div class="cell cell-1-5 boutons-actions align_center"><?php
                                    if($key>0):?>
                                        <span class="btn btn-suppr btn-slim">Suppr</span><?php
                                    endif; ?>
                                </div>
                                <div class="cell cell-3-5 unAdversaire"><?php
                                    if($unMatch->getLieu()!=1):?>
                                        <div class="uneEquipe home">ACH&Egrave;RES</div><?php
                                    endif; ?>
                                    <div class="uneEquipe"><?php
                                        $unClub = $ClubManager->retourne($adversaire);
                                        ?>
                                        <input class="choixAdversaire require" type="text" value="<?=$unClub->getRaccourci();?> <?=$unClub->getNumero();?>" placeholder="Entrez un adversaire" data-club="<?=$unClub->getId();?>"/>
                                    </div><?php
                                    if($unMatch->getLieu()==1):?>
                                        <div class="uneEquipe home">ACH&Egrave;RES</div><?php
                                    endif; ?>
                                </div>
                                <div class="cell cell-1-5">
                                    <div class="unScore"><input class="score1 numeric" type="text" value="<?=$tabScoreDom[$key];?>" placeholder="0"/></div>
                                    <div class="unScore"><input class="score2 numeric" type="text" value="<?=$tabScoreExt[$key];?>" placeholder="0"/></div>
                                </div>
                            </div><?php
                        endforeach;
                    else:?>
                        <div class="row adversaire">
                            <div class="cell cell-1-5 boutons-actions align_center"></div>
                            <div class="cell cell-3-5 unAdversaire">
                                <div class="uneEquipe"><input class="choixAdversaire require" type="text" placeholder="Entrez un adversaire"/></div>
                            </div>
                            <div class="cell cell-1-5">
                                <div class="unScore"><input class="score1 numeric" type="text" placeholder="0" /></div>
                                <div class="unScore"><input class="score2 numeric" type="text" placeholder="0"/></div>
                            </div>
                        </div><?php
                    endif;?>
                </div>
                <div class="table">
                    <div class="row">
                        <div class="cell cell-1-5 boutons-actions align_right">
                            <span class="btn btn-ajout btn-slim">Ajout</span>
                        </div>
                        <div class="cell cell-4-5">
                            <div class="">Ajouter un adversaire</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="joue">Joué</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect joue require">
                            <input type="button" class="select <?=($unMatch->getJoue()==1 && $unMatch->getId()!=0)?'actif':'';?>" value="Oui" data-value="1" />
                            <input type="button" class="select <?=($unMatch->getJoue()==0 && $unMatch->getId()!=0)?'actif':'';?>" value="Non" data-value="0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="boutons-actions">
        <a href="#" class="btn btn-save save-match <?=(!isset($_POST['matchId']))?'disable':'';?> marginR">Sauvegarder</a>
        <a href="#" class="btn btn-annul">Annuler</a>
        <input id="id_match" type="hidden" value="<?=$unMatch->getId();?>" />
    </div>
</div>