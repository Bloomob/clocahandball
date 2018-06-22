<?php
    $options = array('where' => 'categorie = '.$laCategorie->getId());
    $listeJoueurs = $JoueurManager->retourneListe($options);
    if(!empty($listeJoueurs) && false): ?>
        <div class="wrapper">
            <div id="tab_joueur"><?php
                $k=2;
                $poste = 0;
                foreach($listeJoueurs as $unJoueur) {
                    if($unJoueur->getPoste() != $poste) {?>
                        <div class="clear_b"></div>
                        <div class="titre_poste"><?=$postes[$unJoueur->getPoste()];?></div><?php
                    }
                    $unUtilisateur = $UtilisateurManager->retourneById($unJoueur->getId_utilisateur());
                    ?>
                    <div class="ligne_joueur">
                        <div class="left"><img src="images/inconnu.gif" alt="Lambda" width="100px" /><?//=$unJoueur->getPhoto();?></div>
                        <div>
                            <div class="result"><?=$unUtilisateur->getNom();?></div>
                        </div>
                        <div>
                            <div class="result"><?=$unUtilisateur->getPrenom();?></div>
                        </div>
                        <div>
                            <div class="result"><?=$unJoueur->getDate_naissance();?></div>
                        </div><?php /*
                        <div>
                            <div class="result"><?=$unJoueur['matchs_joues'];?> match</div>
                        </div>*/?>
                        <div class="maillot">
                            <img src="images/petit_maillot.jpg" alt="maillot" width="50px">
                            <span class="petit_maillot"><?=$unJoueur->getNumero();?></span>
                        </div>
                    </div><?php
                    $k++;
                    if($k==3) $k=1;
                    $poste = $unJoueur->getPoste();
                }?>
            </div>
        </div><?php
    endif;?>