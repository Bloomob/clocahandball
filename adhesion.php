<?php 
session_start();

// On enregistre notre autoload.
function chargerClasse($classname)
{
	require_once('classes/'.$classname.'.class.php');
}
spl_autoload_register('chargerClasse');

// Initialisation des variables
$page = 'adhesion';
$titre_page = 'adhésion';
$filAriane = array(
	'home', 
	array(
		'url' => $page,
		'libelle' => $titre_page
	),
	array(
		 array(
			'url' => 'comment_sinscrire',
			'libelle' => 'S\'inscrire'
		),
		 array(
			'url' => 'tarifs_cotisation',
			'libelle' => 'Tarifs'
		),
		 array(
			'url' => 'documents_a_telecharger',
			'libelle' => 'Documents'
		),
		 array(
			'url' => 'reglement_interieur',
			'libelle' => 'Règlement interieur'
		),
	)
);

// On inclue la page de connexion à la BDD
include_once("inc/connexion_bdd_pdo.php");
include_once("inc/fonctions.php");
require_once("inc/date.php");
include_once("inc/constantes.php");

if(isset($_GET['onglet']))
	$onglet = $_GET['onglet']; // On récupère la catégorie de staff choisi
else
	$onglet = 'comment_sinscrire'; // Par défaut
	
switch($onglet) {
	case 'tarifs_cotisation':
		$titre = 'Les tarifs & cotisations';
	break;
	case 'reglement_interieur':
		$titre = 'Le règlement interieur';
	break;
	case 'documents_a_telecharger':
		$titre = 'Documents à télécharger';
	break;

	case 'comment_sinscrire':
	default:
		$titre = 'Comment s\'inscrire ?';
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
							<h2><i class="fa fa-pencil" aria-hidden="true"></i><?=$titre?></h2>
							<div class="wrapper"><?php
								if($onglet=="comment_sinscrire"):?>
									<div id="comment_sinscrire">
										<p class="sous_titre"><strong>Retrouvez les différents documents nécessaires pour tout renouvellement ou création de licence au CLOC Achères.</strong></p>
										<ol>
											<li>La fiche d'inscription "joueur" completée et signée.</li>
											<li>Pour tout joueur mineur, l'autorisation parentale completée et signée.</li>
											<li>L’attestation/questionnaire de santé (ou le certificat médical fourni par nos soins), completé et signé (tampon + signature du médecin)</li>
											<li>Le montant total de la cotisation à l'ordre du C.L.O.C.A. Handball<span class="red">*</span> (si paiement en 4 fois, prière d'inscrire au dos les mois d'encaissement - avant fin Décembre).</li>
											<li>Un chèque de caution de 100€ (pour le prêt de materiel - maillots, chasuble, ballons ... ).</li>
											<li>Pour tout adhérent, une photocopie de la carte d'identité ou du livret de famille.</li>
										</ol>
										<p><span class="red">*</span> Merci d'indiquer au dos des chèques : les nom, prénom, date de naissance, catégorie et nature du règlement (cotisation ou caution) et si licence entraineur, jeunes arbitres, complément payé par le CE.</p>
										<div class="nouveaute">
											<ol>
												<li>Restitution du dossier (fiche d'inscription + chèques)</li>
												<li>Un mail vous sera envoyé de la part de la FFHB "lhand", cliquez sur le lien</li>
												<li>Cliquez ensuite sur "Complèter le formulaire"</li>
												<li>Scanner ou photographier avec votre smartphone :
													<ul>
														<li>L’attestation/questionnaire de santé ou certificat médical</li>
														<li>La photo d'identité</li>
														<li>La carte d'identité ou livret de famille</li>
														<li>L'autorisation parentale</li>
													</ul>
												</li>
												<li>Enregistrer et finaliser</li>
												<li>Le club recoit votre inscription, vérifie si votre dossier est conforme et valide l’inscription</li>
												<li>Vous recevrez alors un mail de qualification de votre licence vous permettant de jouer</li>
											</ol>
											<p><i class="fa fa-question-circle" aria-hidden="true"></i>Une question ? Le club vous accompagne dans vos démarches.</p>
										</div>
									</div><?php
								elseif($onglet=="tarifs_cotisation"):
									$TarifManager = new TarifManager($connexion);
									$CategorieManager = new CategorieManager($connexion);

									$options = array('orderby' => 'ordre');
									$listeCategories = $CategorieManager->retourneListe($options);?>
									<div id="tarifs">
										<table class="table">
											<tr>
												<th>Né(e) en</th>
												<th>Categories</th>
												<th>Tarifs</th>
											</tr><?php
										if(!empty($listeCategories)):
											$i = 1;
											// debug($listeCategories);
											foreach ($listeCategories as $uneCategorie):
												$options2 = array('where' => 'categorie IN ('.$uneCategorie->getId().') AND annee = '.$annee_actuelle.' AND actif = 1');
												$unTarif = $TarifManager->retourne($options2);
												if($unTarif->getId()>0):?>
													<tr class="cell<?=($i%2==0)?'1':'2';?>">
														<td><?=$unTarif->getDate_naissance();?></td>
														<?php
															$laCategorie = '';
															$lastCategorie = new Categorie(array());
															$tab = explode(',', $unTarif->getCategorie());
															if(is_array($tab)):
																foreach($tab as $key => $club):
																	$options = array('where' => 'id = '. $club);
																	$uneCategorie = $CategorieManager->retourne($options);
																	if($lastCategorie->getCategorie() != $uneCategorie->getCategorie() || $unTarif->getGenre()):                                                                        $laCategorie .= $uneCategorie->getCategorie();
																		$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
																	  if($key < count($tab)-1):
																		$laCategorie .= ', ';
																	 endif;
																	endif;
																	$lastCategorie = $uneCategorie;
																endforeach;
															else:
																$options = array('where' => 'id = '. $tab);
																$uneCategorie = $CategorieManager->retourne($options);
																$laCategorie = $uneCategorie->getCategorie();
																$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
															endif;
														?>
														<td>
															<?=$laCategorie;?>
														</td>
														<td>
															<?=$unTarif->getPrix_old();?> € <sup>(<?=$unTarif->getCondition_old();?>)</sup><br/>
															<?=($unTarif->getPrix_nv()>0)?'('. $unTarif->getPrix_nv() .'  € <sup>('. $unTarif->getCondition_nv() .')</sup> nouveaux adhérents)':'';?>
														</td>
													</tr><?php
													$i++;
												endif;
											endforeach;
											if($i==1): ?>
												<tr>
													<td colspan=3>Les tarifs de la saison <?=$annee_actuelle;?>-<?=$annee_suiv;?> sont en cours de réalisation</td>
												</tr><?php
											endif;
										endif;?>
										</table>
										<?php
										if($i>1): ?>
											<div class="marginT">
											  <p><sup>(1)</sup> Ce prix comprend la licence compétition valable de Septembre <?=$annee_actuelle;?> à Septembre <?=$annee_suiv;?> + 1 équipement de marque Hummel offert (comprenant 1 t-shirt + 1 paire de chaussettes ou 1 poignet en éponge - pour les catégories école de hand et moins de 9 ans)</p>
											  <p class="hidden"><sup>(2)</sup> Ce prix comprend <sup>(1)</sup> + 1 ballon</p>
											  <br/>
											  <p><strong>*</strong> Pour les doublants CLOCA Handball et UNSS Handball du collège une remise de 10 € est à déduire du montant de la cotisation</p>
											</div><?php
										endif; ?>
									</div><?php
								elseif($onglet=="reglement_interieur"): ?>
									<div id="reglement">
										<h3>ARTICLE 1 : Responsabilité. </h3>
										<h4>1.1 Au gymnase. </h4>
										<p>Le club est responsable de vos enfants uniquement à l’intérieur du gymnase, pendant ses horaires d’entraînement et sous la directive d’un entraîneur. Vous devez vérifier la présence de celui-ci avant de déposer vos chérubins. Vous ne devez en aucun cas laisser un enfant seul.</p>
										<h4>1.2 Transport de personnes mineures.</h4>
										<p>La partie « Autorisations Parentales » de la fiche d’inscription joueur doit impérativement être rendue complétée et signée avec le reste du dossier. En cas d’absence de ces autorisations, nous ne pourrions pas assurer les déplacements de votre enfant pour les rencontres se déroulant chez un club adverse.<p>
										<h3>ARTICLE 2 : Entraînements. </h3>
										<h4>2.1 Horaires.</h4>
										<p>Les horaires d’entraînement doivent être respectés ; c’est à dire que les joueurs doivent être sur le terrain, en tenue et à  l’heure du début de séance.</p>
										<h4>2.2 Tenue.</h4>
										<p>Le Handball est un sport en salle, une tenue adéquate est nécessaire. Elle se compose d’un short, d’un maillot (T-shirt) et des  chaussures de salle propres.</p>
										<h4>2.3 Respect du matériel.</h4>
										<p>Tout adhérent se doit de respecter le matériel mis à sa disposition autant sur le fonctionnement que sur la propreté.</p>
										<h3>ARTICLE 3 : Absences.</h3>
										<p>RAPPEL : Le Handball est un sport d’équipe et une équipe comprenant moins de 5 joueurs (4 chez les petits) est déclarée forfait. En conséquence, une sanction financière est appliquée au club. Toute absence « prévisible » devra être signalée, à l’entraîneur, au minimum 24 heures à l’avance.</p>
										<h4>3.1 Entraînement.</h4>
										<p>En cas d’impossibilité de se rendre à un entraînement, il est indispensable de prévenir son entraîneur. Tout manquement à cette règle pourra être sanctionné au gré de l’entraîneur.<p>
										<h4>3.2 Match.</h4>
										<p>En cas d’indisponibilité, il est obligatoire de prévenir, la personne responsable de l’équipe, la veille de la rencontre afin de pouvoir faire le nécessaire. Toute absence non signalée pourra entraîner une sanction.</p>
										<h3>ARTICLE 4 : Sanctions.</h3>
										<h4>4.1 Sanctions morales.</h4>
										<p>L’échelle des sanctions va de la non-qualification pour une rencontre jusqu’à l’exclusion de la section.</p>
										<h4>4.2 Sanctions financières.</h4>
										<p>Le remboursement du montant d’une amende, notifiée par les Autorités compétentes, pourra être demandé au joueur fautif ou à son représentant légal. Toute dégradation de matériel est inacceptable et donnera lieu à facturation.</p>
										<h3>ARTICLE 5 : Paiement.</h3>
										<h4>5.1 Paiement.</h4>
										<p>La licence de joueur ne sera demandée, à la Fédération, qu’après paiement intégral du montant de la cotisation. Certaines facilités de paiement sont possibles sous réserve d’un accord avec les dirigeants. A fin Décembre, la totalité de la cotisation doit être réglée.</p> 
										<h4>5.2 Caution.</h4>
										<p>Tout joueur étant en charge de sa tenue de match doit fournir, lors de son inscription, une caution de 100,00€. Celle-ci ne sera pas encaissée et sera rendue en fin de saison, à la restitution de la tenue complète et en bon état.</p>
										<h3>ARTICLE 6 : Mutation.</h3>
										<p>Pour toute demande de mutation vers le club d’Achères, le mutant devra régler le montant total des frais de mutation par chèque qui ne sera encaissé que si le joueur ne renouvelle pas son inscription la saison suivante. En cas de renouvellement de licence à Achères, le chèque lui sera rendu.</p>
									</div><?php
								else:?>
									<div id="documents_a_venir">
										<div class="row">
                                            <div class="col-sm-6">
								                <a href="upload/fiche_inscription_joueur_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.pdf">
                                                    <img src="upload/fiche_inscription_joueur_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Fiche d'inscription joueur <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
												<a href="upload/attestation_de_sante_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.pdf">
                                                    <img src="upload/attestation_de_sante_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Certificat médical <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
												<a href="upload/certificat_medical_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.pdf">
                                                    <img src="upload/certificat_medical_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Certificat médical <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="upload/plaquette_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg">
                                                    <img src="upload/plaquette_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Plaquette recto <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="upload/charte_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg">
                                                    <img src="upload/charte_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Plaquette recto <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                            <div class="col-sm-6">
                                                <a href="upload/autorisation_parentale_fede_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.pdf" data-lightbox="docs">
                                                    <img src="upload/autorisation_parentale_fede_<?=$annee_actuelle;?>_<?=$annee_suiv;?>.jpg" alt="Autorisation Parentale <?=$annee_actuelle;?>-<?=$annee_suiv;?>"/>
                                                </a>
                                            </div>
                                        </div>
									</div><?php
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
							<?php include_once('inc/modules/partenaires.php'); ?>
						</article>
					</article>
				</div>
			</div>
		</section>
		<footer>
			<?php include_once('inc/footer.php'); ?>
		</footer>
		<div id="fond" class="fond_transparent"></div>
	</div>
	<?php include('inc/script.php'); ?>
</body>
</html>