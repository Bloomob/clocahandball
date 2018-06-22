<div class="uneActu contenu">
    <h2><i class="fa fa-file-text" aria-hidden="true"></i><?=html_entity_decode(stripslashes($listeActualites->getTitre()));?></h2>
    <div class="wrapper"><?php
        $options = array('where' => 'id = '. $listeActualites->getId_auteur_crea());
        $unUtilisateur = $UtilisateurManager->retourne($options); ?>
        <div class="actu-content">
            <p class="auteur_date">Rédigé par <a href="utilisateur.php?id=<?=$unUtilisateur->getId();?>"><?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?></a>, le <?=$listeActualites->getJourC();?> <?=$mois_de_lannee[$listeActualites->getMoisC()-1];?> <?=$listeActualites->getAnneeC();?></p>
            <p class="sous-titre"><?php echo html_entity_decode(stripslashes($listeActualites->getSous_titre()));?></p><?php
            if($listeActualites->getImage() != ''):
                if(preg_match('/^images\//', $listeActualites->getImage())): ?>
                    <div class="image"><img src="<?=$listeActualites->getImage();?>" alt/></div><?php
                else: ?>
                    <div class="image"><img src="images/<?=$listeActualites->getImage();?>.png" alt/></div><?php
                endif;
            endif; ?>
            <?= html_entity_decode(stripslashes($listeActualites->getContenu()));?>
        </div>
        <div class="navigation row">
            <div class="col-sm-6"><?php
                // Pour retourner l'actualité précédente
                $options = array('where' => 'id != '. $listeActualites->getId() .' AND (date_publication < '. $listeActualites->getDate_publication() .' OR date_publication = '. $listeActualites->getDate_publication() .' AND heure_publication <= '. $listeActualites->getHeure_publication() .')', 'orderby' => 'date_publication desc, heure_publication desc');
                $actuPrec = $ActuManager->retourne($options);
                // echo '<pre>'; var_dump($options, $actuPrec); echo '</pre>'; exit;
                if(is_object($actuPrec) && $actuPrec->getId()!=0): ?>
                    <a href="actualites.php?id=<?=$actuPrec->getId();?>">
                        <div class="contenu gauche">
                            <span><i class="fa fa-arrow-left" aria-hidden="true"></i>Actualit&eacute; pr&eacute;c&eacute;dente</span>
                            <h4>
                                <?=substr($actuPrec->getTitre(), 0, 35);?>
                                <?=(substr($actuPrec->getTitre(), 36,100)=="") ? '' : '...';?>
                            </h4>
                        </div>
                    </a><?php
                endif; ?>
            </div>
            <div class="col-sm-6 text-right">
                <?php
                // Pour retourner l'actualité suivante
                $options = array('where' => 'id != '. $listeActualites->getId() .' AND (date_publication > '. $listeActualites->getDate_publication() .' OR date_publication = '. $listeActualites->getDate_publication() .' AND heure_publication >= '. $listeActualites->getHeure_publication() .')', 'orderby' => 'date_publication desc, heure_publication desc');
                $actuSuiv = $ActuManager->retourne($options);
                // echo '<pre>'; var_dump($options, $actuSuiv); echo '</pre>'; exit;
                if(is_object($actuSuiv) && $actuSuiv->getId()!=0): ?>
                    <a href="actualites.php?id=<?=$actuSuiv->getId();?>">
                        <div class="contenu droite">
                            <span>Actualit&eacute; suivante<i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                            <h4>
                                <?=substr($actuSuiv->getTitre(), 0, 35);?>
                                <?=(substr($actuSuiv->getTitre(), 36,100)=="") ? '' : '...';?>
                            </h4>
                        </div>
                    </a><?php
                endif; ?>
            </div>
        </div>
        <form class="commentaires hidden"><?php
            if(isset($_SESSION)):?>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="publier-commentaire">
                            <h3>Réagissez à cet article</h3>
                            <div class="form-group">
                                <label for="commentaire">Votre commentaire (500 caractères restants)</label>
                                <textarea id="commentaire" class="form-control" placeholder="Entrer votre commentaire"></textarea>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-success">Publier</button>
                            </div>
                        </div>
                    </div>
                </div><?php
            endif; ?>
        </form>
    </div>
</div>