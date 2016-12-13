<?php
    function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    require_once("../connexion_bdd_pdo.php");
    require_once("../constantes.php");
    require_once("../fonctions.php");

    $ClubManager = new ClubManager($connexion);

    if(!isset($_POST['clubId'])):
        $titre = "Ajout d'un club";
        $unClub = new Club(array());
    else:
        $titre = "Modification du club n°" .$_POST['clubId'];
        $unClub = $ClubManager->retourne($_POST['clubId']);
    endif;
?>
<div class="form">
    <div class="content">
        <h4><?=$titre;?></h4>
        <div class="pad">
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="nom">Nom :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input type="text" id="nom" class="require" value="<?=$unClub->getNom(); ?>" >
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="raccourci">Raccourci :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input type="text" id="raccourci" class="require"  value="<?=$unClub->getRaccourci(); ?>" >
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="numero">Numéro :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <select id="numero" class="require">
                            <option value="0">Choisissez un numéro</option><?php
                            for ($i=1; $i<=5; $i++): ?>
                                <option value="<?=$i;?>" <?=($unClub->getNumero()==$i)?'selected':''; ?> ><?=$i;?></option><?php
                            endfor;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="ville">Ville :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input type="text" id="ville" class="require" value="<?=$unClub->getVille(); ?>" >
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="code_postal">Code postal :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input type="text" id="code_postal" class="require numeric" value="<?=($unClub->getCode_postal()!=0)?$unClub->getCode_postal():''; ?>" >
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10 <?=(!isset($_POST['clubId']))?'hidden':''; ?>">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="actif">Actif :</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect actif require">
                            <input type="button" class="select <?=($unClub->getActif()==1)?'actif':''; ?>" value="Oui" data-value="1" />
                            <input type="button" class="select <?=($unClub->getActif()==0)?'actif':''; ?>" value="Non" data-value="0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="boutons-actions">
        <input type="hidden" id="id_club" value="<?=$unClub->getId();?>" />
        <a href="#" class="btn btn-save <?=(!isset($_POST['clubId']))?"disable":"";?> marginR">Sauvegarder</a>
        <a href="#" class="btn btn-annul">Annuler</a>
    </div>
</div>