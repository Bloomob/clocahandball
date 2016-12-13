<div class="form">
    <div class="content">
        <h4>Contenu</h4>
        <div class="pad">
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="titre">Titre</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input id="titre" type="text" placeholder="Entrer le titre" class="require">
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="sous_titre">Sous-titre</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input id="sous_titre" type="text" placeholder="Entrer le sous-titre">
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="theme">Thème</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect theme require">
                            <input type="button" class="select" value="Administratif" data-value="administratif" />
                            <input type="button" class="select" value="Debriefs" data-value="debriefs" />
                            <input type="button" class="select" value="Divers" data-value="divers" />
                            <input type="button" class="select" value="Evènement" data-value="evenement" />
                            <input type="button" class="select" value="Interviews" data-value="interviews" />
                            <input type="button" class="select" value="Sportif" data-value="sportif" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <textarea class="tinymce" id="contenu" placeholder="Entrer le contenu" class="require"></textarea>
            </div>
        </div>
    </div>
    <div class="content marginT">
        <h4>Tags</h4>
        <div class="pad">
            <input id="tags" type="hidden">
            <div class="tags">
                <div class="liste_tags"></div>
                <input id="add_tag" type="text" placeholder="Ajouter un tag">
            </div>
        </div>
    </div>
    <div class="content marginT">
        <h4>Images</h4>
        <div class="pad tab_container">
            <div class="galerie choix">
                <div class="upload" style="display: none;">
                    <form action="inc/ajax/upload_image.php" method="post" enctype="multipart/form-data">
                        <input type="file" class="image" name="imageFile"/>
                        <input type="submit" class="add" placeholder="Ajouter une image"/>
                    </form>
                </div>
                <div class="clear_b"></div>
                <div class="albums"><?php
                    $table_fichier = array();
                    $nb_fichier = 0;
                    if($dossier = opendir('./../../images/albums/'.$getDossier.'/')){
                        while(false !== ($fichier = readdir($dossier))){
                            if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'){
                                $nb_fichier++; // On incrémente le compteur de 1
                                $table_fichier[] = $fichier;
                            } // On ferme le if (qui permet de ne pas afficher index.php, etc.)
                        } // On termine la boucle
                        echo 'Il y a <strong>' . $nb_fichier .'</strong> fichier(s) dans le dossier';
                        closedir($dossier);
                         
                    }
                    else
                         echo 'Le dossier n\' a pas pu être ouvert';
                    ?>
                    <div class="liste">
                        <input type='hidden' class='dir_courant' value='<?=$getDossier;?>' />
                        <input type="hidden" id="image" value="" />
                        <?php
                            if(!empty($retourDossier)) {?>
                                <a href="<?=$retourDossier;?>" class="nav retour">Remonter d'un dossier</a><?php
                            }

                            foreach ($table_fichier as $key => $value) {
                                if(preg_match("#(.jpg|.png|.gif)$#", $value)) {?>
                                    <a href="images/albums/<?=$getDossier.'/'.$value;?>"><img src="images/albums/<?=$getDossier.'/'.$value;?>" alt="<?=$value;?>" /></a><?php
                                }
                                else{?>
                                    <a class="nav" href="<?=$getDossier.'/'.$value;?>"><?=$value;?></a><?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="clear_b"></div>
            </div>
        </div>
    </div>
    <div class="content marginT">
        <h4>Paramètres de publication</h4>
        <div class="pad">
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="importance">Importance</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect importance">
                            <input type="button" class="select" value="Basse" data-value="3" />
                            <input type="button" class="select" value="Moyenne" data-value="2" />
                            <input type="button" class="select" value="Haute" data-value="1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="slider">Slider</label>
                    </div>
                    <div class="cell cell-4-5">
                        <div class="listeSelect slider">
                            <input type="button" class="select" value="Non" data-value="0" />
                            <input type="button" class="select" value="Oui" data-value="1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap marginTB10">
                <div class="table">
                    <div class="cell cell-1-5">
                        <label for="date">Date de publication</label>
                    </div>
                    <div class="cell cell-4-5">
                        <input class="datepicker" id="date" type="hidden">
                        <span class="date"></span>
                        <span class="heure" style="display: none;"> à 
                            <select id="heure">
                                    <option value="0">-</option><?php
                                for($i=900;$i<2130;$i+=15):
                                    if(substr($i, -2)==60) $i+=40;?>
                                    <option value="<?=$i;?>"><?=substr($i,0,-2);?>h<?=substr($i,-2);?></option><?php
                                endfor; ?>
                            </select>
                        </span>
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