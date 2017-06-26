<?php 
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// Initialisation des variables
	$page = 'actualites';
	$titre_page = 'actualites';
	$id_actualite = 0;
	$theme = '';
	$filAriane = array(
        'home', 
        array(
            'url' => $page,
            'libelle' => $titre_page
        )
    );
	
	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");
	
	// Initialisation des managers
	$ActuManager = new ActualiteManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	
	// Si on a spécifié une ID d'actualité dans l'url
	if(isset($_GET['id']))
		$id_actualite = intval($_GET['id']);
	
	// Si on a spécifié un thème d'actualité dans l'url	
	if(isset($_GET['onglet']))
		$theme = $_GET['onglet'];

	if($id_actualite > 0):
		$options = array('where' => 'id = '. $id_actualite);
		$listeActualites = $ActuManager->retourne($options);
		$filAriane[2] = array(
            'url' => $listeActualites->getTheme(),
            'libelle' => $listeActualites->getTheme()
        );
        $filAriane[3] = '';
	else:
		$options = array('orderby' => 'date_publication desc, heure_publication desc', 'limit' => '0, 10');
		if($theme != '')
			$options['where'] = 'theme = "'. $theme .'"';
		$listeActualites = $ActuManager->retourneListe($options);
	endif;
	if($theme != ''):
		$filAriane[2] = array(
            'url' => $theme,
            'libelle' => $theme
        );
        $filAriane[3] = '';
    endif;
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once('inc/head.php'); ?>
	</head>
	<body>
		<header id="entete">
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
			<section id="content" class="<?=$page;?>">
				<?php include_once('inc/fil_ariane.php'); ?>
				<div class="container">
                    <div class="row">
                        <article class="col-sm-8"><?php
                            if(is_object($listeActualites) && $listeActualites->getId() != 0 && $theme == '') {?>
                                <div class="uneActu">
                                    <h2><?=html_entity_decode(stripslashes($listeActualites->getTitre()));?></h2>
                                    <div class="auteur_date">
                                        <span><?php
                                            $options = array('where' => 'id = '. $listeActualites->getId_auteur_crea());
                                            $unUtilisateur = $UtilisateurManager->retourne($options); ?>
                                            R&eacute;dig&eacute; par <?=$unUtilisateur->getPrenom();?> <?=$unUtilisateur->getNom();?>, le <?=$listeActualites->getJourC();?> <?=$mois_de_lannee[$listeActualites->getMoisC()-1];?> <?=$listeActualites->getAnneeC();?>
                                        </span>
                                    </div>
                                    <div class="contenu">
                                        <h4><?php echo html_entity_decode(stripslashes($listeActualites->getSous_titre()));?></h4><?php
                                        if($listeActualites->getImage() != ''){
                                            if(preg_match('/^images\//', $listeActualites->getImage())){?>
                                                <div class="align_center"><img src="<?=$listeActualites->getImage();?>" alt/></div><?php
                                            } else { ?>
                                                <div class="align_center"><img src="images/<?=$listeActualites->getImage();?>.png" alt/></div><?php
                                            }
                                        } ?>
                                        <div class="marginTB10"><?php echo html_entity_decode(stripslashes($listeActualites->getContenu()));?></div>
                                    </div>
                                </div>
                                <div class="navigation marginTB10">
                                    <div class="col-gauche"><?php
                                        // Pour retourner l'actualité précédente
                                        $options = array('where' => 'id != '. $listeActualites->getId() .' AND (date_publication < '. $listeActualites->getDate_publication() .' OR date_publication = '. $listeActualites->getDate_publication() .' AND heure_publication <= '. $listeActualites->getHeure_publication() .')', 'orderby' => 'date_publication desc, heure_publication desc');
                                        $actuPrec = $ActuManager->retourne($options);
                                        // echo '<pre>'; var_dump($options, $actuPrec); echo '</pre>'; exit;
                                        if(is_object($actuPrec) && $actuPrec->getId()!=0) { ?>
                                            <a href="actualites.php?id=<?=$actuPrec->getId();?>">
                                                <div>
                                                    <span>Actualit&eacute; pr&eacute;c&eacute;dente</span>
                                                    <h4>
                                                        <?=substr($actuPrec->getTitre(), 0, 35);?>
                                                        <?=(substr($actuPrec->getTitre(), 36,100)=="") ? '' : '...';?>
                                                    </h4>
                                                </div>
                                            </a><?php
                                        } ?>
                                    </div>
                                    <div class="col-droite">
                                        <?php
                                        // Pour retourner l'actualité suivante
                                        $options = array('where' => 'id != '. $listeActualites->getId() .' AND (date_publication > '. $listeActualites->getDate_publication() .' OR date_publication = '. $listeActualites->getDate_publication() .' AND heure_publication >= '. $listeActualites->getHeure_publication() .')', 'orderby' => 'date_publication desc, heure_publication desc');
                                        $actuSuiv = $ActuManager->retourne($options);
                                        // echo '<pre>'; var_dump($options, $actuSuiv); echo '</pre>'; exit;
                                        if(is_object($actuSuiv) && $actuSuiv->getId()!=0) { ?>
                                            <a href="actualites.php?id=<?=$actuSuiv->getId();?>">
                                                <div>
                                                    <span>Actualit&eacute; suivante</span>
                                                    <h4>
                                                        <?=substr($actuSuiv->getTitre(), 0, 35);?>
                                                        <?=(substr($actuSuiv->getTitre(), 36,100)=="") ? '' : '...';?>
                                                    </h4>
                                                </div>
                                            </a><?php
                                        } ?>
                                    </div>
                                </div>
                                <div class="commentaires">
                                    <div class="pad">
                                        <div class="wrapper">
                                            <h3>Réagissez à cette article</h3>
                                            <div>Votre commentaire (500 caractères restants)</div>
                                            <textarea class=""></textarea>
                                            <div>
                                                <input type="button" value="PUBLIER" />
                                            </div>
                                        </div>
                                    </div>
                                </div><?php							
                            }
                            elseif(is_array($listeActualites) && !empty($listeActualites)) { ?>
                                <div class="listeActus"><?php
                                    foreach($listeActualites as $key => $uneActu):?>
                                        <div class="row">
                                            <!-- <div class="auteur_date"><span><?=$uneActu->getTags();?></span></div> -->
                                            <?php if($uneActu->getImage() != ''):
                                                if($uneActu->getImportance() == 1):?>
                                                    <div class="col-sm-12">
                                                        <div class="image">
                                                            <div class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></div>
                                                            <a href="?id=<?=$uneActu->getId();?>"><?php
                                                                if(preg_match('/^images\//', $uneActu->getImage())){?>
                                                                    <img src="<?=$uneActu->getImage();?>" alt /><?php
                                                                } else { ?>
                                                                    <img src="images/<?=$uneActu->getImage();?>.png" alt /><?php
                                                                }?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <h2><a href="?id=<?=$uneActu->getId();?>"><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></a></h2>
                                                        <div class="contenu">
                                                            <a href="?id=<?=$uneActu->getId();?>"><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="col-sm-12">
                                                    <h2>
	                                                    <div class="theme_actualite <?=$uneActu->getTheme();?>"><?=$uneActu->getTheme();?></div>
	                                                    <a href="?id=<?=$uneActu->getId();?>"><?=html_entity_decode(stripslashes($uneActu->getTitre()));?></a>
                                                    </h2>
                                                    <div class="contenu">
                                                        <a href="?id=<?=$uneActu->getId();?>"><?=html_entity_decode(stripslashes($uneActu->getSous_titre()));?></a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div><?php
                                    endforeach; ?>
                                </div><?php
                            }
                            else {?>
                                <div>
                                    <p>
                                        Cette actualité n'existe pas.<br/>
                                        Pour la liste des actualités : <a href="actualites.php">Cliquez-ici</a>
                                    </p>
                                </div><?php
                            }?>
                        </article>
                        <article class="col-sm-4 modules">
                            <article>
                                <?php include_once('inc/modules/infos-home.php'); ?>
                            </article>
                            <article>
                                <?php // include_once('inc/modules/qui-en-ligne-home.php'); ?>
                            </article>
                            <article>
                                <?php include_once('inc/partenaires.php'); ?>
                            </article>
                        </article>
                    </div>
                </div>
			</section>
			<footer>
				<?php include_once('inc/footer.php'); ?>
			</footer>
		</div>
		<?php include_once('inc/script.php'); ?>
	</body>
</html>