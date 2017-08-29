<?php
	session_start();

	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// Initialisation des variables
	$page = 'entrainements';
	$titre_page = 'entrainements';
	$filAriane = array(
        'home',
        array(
            'url' => $page,
            'libelle' => $titre_page
        ),
        array(
            array(
                'url' => 'horaires_entrainement',
                'libelle' => 'Horaires'
            ),
            array(
                'url' => 'gymnases',
                'libelle' => 'Gymnases'
            )
        )
    );

	// On inclue la page de connexion à la BDD
	include_once("inc/connexion_bdd_pdo.php");
	require_once("inc/connexion_bdd.php");
	include_once("inc/fonctions.php");
	require_once("inc/date.php");
	include_once("inc/constantes.php");
	
	// Initialisation des managers
	$HoraireManager = new HoraireManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
	else
		$onglet = 'horaires_entrainement'; // Par défaut

	switch($onglet) {
		case 'gymnases':
			$titre = 'Les gymnases';
		break;
		case 'horaires_entrainement':
		default:
			$titre = 'Les horaires d\'entrainement';
		break;
	}
	
	
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
                        <article class="col-sm-8">
                            <div class="contenu">
                                <h2><i class="fa fa-clock-o" aria-hidden="true"></i><?=$titre?></h2>
                                <div class="wrapper"><?php
                                    if($onglet=="gymnases"):?>
                                        <ul class="tabs2">
                                            <li class="active">
                                                <a href="#tab1_2">Gymnase Pierre de Coubertin</a>
                                            </li>
                                            <li>
                                                <a href="#tab2_2">Gymnase de la Petite Arche</a>
                                            </li>
                                        </ul>
                                        <div class="tab_container">
                                            <div id="tab1_2" class="tab_content2" style="display: block; ">
                                                <div class="wrapper pad_bot1">

                                                    <div class="new_champ2">
                                                        <div class="define2 left">Lieu :</div>
                                                        <div class="result2">Complexe sportif Georges-Bourgoin</div>
                                                    </div>
                                                    <div class="new_champ2">
                                                        <div class="define2 left">Adresse :</div>
                                                        <div class="result2">42-44 Rue de Saint-Germain, Achères</div>
                                                    </div>
                                                    <div class="new_champ2">
                                                        <div class="define2 left">Tèl :</div>
                                                        <div class="result2">01 39 11 42 39<br/>06 88 06 93 39</div>
                                                    </div>
                                                    <div class="plan_acces">
                                                        <iframe width="580" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=44+Rue+de+Saint-Germain+ach%C3%A8res&amp;aq=&amp;sll=48.956439,2.072039&amp;sspn=0.011554,0.037293&amp;gl=fr&amp;ie=UTF8&amp;hq=&amp;hnear=44+Rue+de+Saint-Germain,+78260+Ach%C3%A8res,+Yvelines,+%C3%8Ele-de-France&amp;ll=48.956439,2.072039&amp;spn=0.011554,0.037293&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=44+Rue+de+Saint-Germain+ach%C3%A8res&amp;aq=&amp;sll=48.956439,2.072039&amp;sspn=0.011554,0.037293&amp;gl=fr&amp;ie=UTF8&amp;hq=&amp;hnear=44+Rue+de+Saint-Germain,+78260+Ach%C3%A8res,+Yvelines,+%C3%8Ele-de-France&amp;ll=48.956439,2.072039&amp;spn=0.011554,0.037293&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">Agrandir le plan</a></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab2_2" class="tab_content2" style="display: none; ">
                                                <div class="wrapper pad_bot1">

                                                    <div class="new_champ2">
                                                        <div class="define2 left">Adresse :</div>
                                                        <div class="result2">33 Impasse Jean-Rostand, Achères</div>
                                                    </div>
                                                    <div class="new_champ2">
                                                        <div class="define2 left">Tèl :</div>
                                                        <div class="result2">01 39 11 61 78</div>
                                                    </div>
                                                    <div class="plan_acces">
                                                        <iframe width="580" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=33+impasse+Jean+Rostand&amp;aq=&amp;sll=48.969997,2.072714&amp;sspn=0.012044,0.033023&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=33+Impasse+Jean+Rostand,+78260+Ach%C3%A8res,+Yvelines,+%C3%8Ele-de-France&amp;ll=48.969992,2.072704&amp;spn=0.012043,0.033023&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=33+impasse+Jean+Rostand&amp;aq=&amp;sll=48.969997,2.072714&amp;sspn=0.012044,0.033023&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=33+Impasse+Jean+Rostand,+78260+Ach%C3%A8res,+Yvelines,+%C3%8Ele-de-France&amp;ll=48.969992,2.072704&amp;spn=0.012043,0.033023&amp;z=14" style="color:#0000FF;text-align:left">View Larger Map</a></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><?php
                                    else:?>
                                        <fieldset>
                                            <legend>Légende</legend>
                                            <p>PA = Petite Arche</p>
                                            <p>PdC = Pierre de Coubertin</p>
                                            <p>C = COSEC (Poissy)</p>
                                            <p>HdS = Halle des sports (Poissy)</p>
                                            <p>LF = Laura Flessel (Chanteloup-les-vignes)</p>
                                        </fieldset>
                                        <?php
                                        $PH = $HoraireManager->planningHoraires($annee_actuelle);
                                        $old_gymnase = '';
                                        $old_jour = '';
                                        $tabHeure = array();

                                        if(is_array($PH)): ?>
                                            <table class="planning">
                                                <tr>
                                                    <td colspan="2"></td><?php
                                                    for($i=1000; $i<=2200; $i+=100):
                                                        if($i<1300 || $i>=1700):?>
                                                            <td class="heure" colspan="4"><?=substr($i, 0, 2);?>h</td><?php

                                                        endif;
                                                    endfor;?>
                                                </tr>
                                                <tr class="minutes"><td colspan="2" class="no_minute"></td>
                                                    <?php
                                                    for($i=930, $y=2; $i<=2230; $i+=15):
                                                        if(substr($i, -2)==60) $i+=40;
                                                        if($i<=1230 || $i>1630):?>
                                                            <td <?=(substr($i, -2)==00)?'class="minute"':''; ?>><?=(substr($i, -2)==30)?substr($i, -2):''; ?></td><?php
                                                            $tabHeure[] = $i;
                                                            $y++;
                                                        endif;
                                                    endfor;?>
                                                </tr>
                                                <?php
                                                $z = 3;
                                                foreach($PH as $J=>$gymnase):
                                                    $nbr_gymnase = count($gymnase);?>
                                                    <tr class="ligne_planning j<?=$J;?>">
                                                        <th rowspan='<?=$nbr_gymnase?>' class="jour"><?=substr($jour_de_la_semaine[$J-1], 0, 3)?></th><?php
                                                        foreach($gymnase as $G=>$horaire) {
                                                            if($old_gymnase != ''):
                                                                $colblank = $y-$z;
                                                                if($colblank>0)
                                                                    echo '<td colspan="'.$colblank.'"></td>';
                                                                echo '</tr><tr class="ligne_planning j'.$J.'">';
                                                                $z = 3;
                                                            endif;?>
                                                            <td><?=$G?></td><?php
                                                            $retour = '';
                                                            $old_key = 0;
                                                            $last_end_cat = 0;

                                                            foreach($horaire as $H=>$categorie) {
                                                                $deb = explode('-', $H);
                                                                if($old_key==0 || $last_end_cat != $deb[0]) {
                                                                    $key = array_keys($tabHeure, $deb[0]);
                                                                    $new_key = $key[0]++;
                                                                    $K = $new_key - $old_key;
                                                                    $retour .= '<td colspan="'.$K.'"></td>';
                                                                    $old_key = $new_key;
                                                                    $z+=$K;
                                                                }

                                                                $classeCat = str_replace('-', ' cat_', $categorie);

                                                                $key = array_keys($tabHeure, $deb[1]);
                                                                $new_key = $key[0]++;
                                                                $K = $new_key - $old_key;
                                                                $listeCatParHeure = explode('-', $categorie);
                                                                $max = count($listeCatParHeure);
                                                                $maChaine = '';
                                                                for($i=0; $i<$max; $i++) {
                                                                    $options = array('where' => 'raccourci LIKE "'.$listeCatParHeure[$i].'"');
                                                                    $uneCat = $CategorieManager->retourne($options);
                                                                    $maChaine .= '<a href="/equipes.php?onglet='.$uneCat->getRaccourci().'">'.strtoupper($uneCat->getRaccourci()).'</a><br/><br/>';
                                                                }
                                                                $maChaine = substr($maChaine, 0, strlen($maChaine)-5);

                                                                $retour .= '<td colspan="'.$K.'" class="cat cat_'.$classeCat.'" id="'.$categorie.'/'.$J.'">'.$maChaine.'</td>';
                                                                $old_key = $new_key;
                                                                $z+=$K;

                                                                $last_end_cat = $deb[1];
                                                            }
                                                            echo $retour;
                                                            $old_gymnase = $G;
                                                        }
                                                        $colblank = $y-$z;
                                                        if($colblank>0)
                                                            echo '<td colspan="'.$colblank.'"></td>';
                                                        $z = 3;?>
                                                    </tr><?php
                                                    $old_gymnase = '';
                                                endforeach;?>
                                            </table><?php
                                        else:
                                            echo "<div>Pas d'horaire d'entrainement pour cette année.</div>";
                                        endif;
                                    endif;?>
                                </div>
                            </div>
                        </article>
                        <article class="col-sm-4 modules">
                            <article>
                                <?php include_once('inc/modules/infos-home.php'); ?>
                            </article>
                            <article>
                                <?php // include_once('inc/modules/qui-en-ligne-home.php'); ?>
                            </article>
                            <article>
                                <?php include_once('inc//modules/partenaires.php'); ?>
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