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
	$titre_page = 'adhesion';

	// On inclue la page de connexion � la BDD
	include_once("inc/connexion_bdd_pdo.php");

	include_once("inc/constantes.php");
	include_once("inc/fonctions.php");
	include_once("inc/connexion.php");
	include_once("inc/date.php");
	
	$annee = retourne_annee();
	
	if(isset($_GET['onglet']))
		$onglet = $_GET['onglet']; // On r�cup�re la cat�gorie de staff choisi
	else
		$onglet = 'comment_sinscrire'; // Par d�faut
	
	$fil_ariane = array(
		array(
			'url' => 'adhesion.php?onglet=comment_sinscrire',
			'libelle' => 'Comment s\'inscrire'
		),
		array(
			'url' => 'adhesion.php?onglet=tarifs_cotisation',
			'libelle' => 'Tarifs & cotisations'
		),
		array(
			'url' => 'adhesion.php?onglet=reglement_interieur',
			'libelle' => 'R�glement interieur'
		),
		array(
			'url' => 'adhesion.php?onglet=documents_a_telecharger',
			'libelle' => 'Documents � t�l�charger'
		)
	);
	
	switch($onglet) {
		case 'tarifs_cotisation':
			$titre = 'Les tarifs & cotisations';
		break;
		case 'reglement_interieur':
			$titre = 'Le r�glement interieur';
		break;
		case 'documents_a_telecharger':
			$titre = 'Documents � t�l�charger';
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
	<body id="page1">
		<header>
			<?php include_once('inc/header.php'); ?>
		</header>
		<div id='main'>
			<section id="content">
				<nav>
					<ul>
						<li class="nav navhome"><a href="index.php"><!--<img src="images/icon/png_white/home.png"/>-->Home</a></li>
						<li class="nav navtit2"><span><?=$titre_page?></span></li><?php
						foreach($fil_ariane as $fil) {
							$ong = explode('=', $fil['url']);
							if($onglet != $ong[1]) {?>
								<li><span><a href="<?=$fil['url']?>"><?=$fil['libelle']?></a></span></li><?php
							}
							elseif($onglet == $ong[1]) {?>
								<li><span><?=$fil['libelle']?></span></li><?php
							}
						}?>
					</ul>
				</nav>
				<div class="bg1 pad">
					<article class="col2 marg-right1">
						<h2><?=$titre?> <span><?=$annee;?>-<?=$annee+1;?></span></h2>
						<?php if($onglet=="comment_sinscrire") {?>
							<div id="comment_sinscrire">
								<p class="sous_titre">Retrouvez les diff�rents documents n�cessaires pour tout renouvellement ou cr�ation de licence au CLOC Ach�res.</p>
								<ol>
									<li>La fiche d'inscription "joueur" complet�e et sign�e.</li>
									<li>Pour tout joueur mineur, l'autorisation parentale complet�e et sign�e.</li>
									<li>Le certificat m�dical fourni par nos soins, complet� et sign�.</li>
									<li>Le montant total de la cotisation � l'ordre du C.L.O.C.A. Handball<span class="red">*</span> (si paiement en 4 fois, pri�re d'inscrire au dos les mois d'encaissement - avant fin D�cembre).</li>
									<li>Un ch�que de caution de 100� (pour le pr�t de materiel - maillots, chasuble, ballons ... ).</li>
									<li>Pour tout adh�rent, une photocopie de la carte d'identit� ou du livret de famille.</li>
								</ol>
								<p><span class="red">*</span> Merci d'indiquer au dos des ch�ques : les nom, pr�nom, date de naissance, cat�gorie et nature du r�glement (cotisation ou caution) et si licence entraineur, jeunes arbitres, compl�ment pay� par le CE.</p>
								<div class="nouveaute">
									<h4>Nouveaut�</h4>
									<ol>
										<li>Restitution du dossier (fiche d'inscription + ch�ques)</li>
										<li>Un mail vous sera envoy� de la part de la FFHB "lhand", cliquez sur le lien</li>
										<li>Cliquez ensuite sur "Compl�ter le formulaire"</li>
										<li>Scanner ou photographier avec votre smartphone :
											<ul>
												<li>Le certificat m�dical</li>
												<li>La photo d'identit�</li>
												<li>La carte d'identit� ou livret de famille</li>
												<li>L'autorisation parentale</li>
											</ul>
										</li>
										<li>Enregistrer</li>
										<li>Le club recoit votre inscription et la valide</li>
										<li>Si tout est bon, vous �tes inscrit !</li>
									</ol>
									<p>Une question ? Le club vous accompagne dans vos d�marches.</p>
								</div>
							</div><?php
						}
						elseif($onglet=="tarifs_cotisation") {
							$TarifManager = new TarifManager($connexion);
							$CategorieManager = new CategorieManager($connexion);

							$options = array('orderby' => 'ordre');
							$listeCategories = $CategorieManager->retourneListe($options);?>
							<div id="tarifs">
								<table>
									<tr>
										<th>N�(e) en</th>
										<th>Categories</th>
										<th>Tarifs</th>
									</tr><?php
								if(!empty($listeCategories)):
									$i = 1;
									foreach ($listeCategories as $uneCategorie):
										$options2 = array('where' => 'categorie = '.$uneCategorie->getId().' AND annee = '.$annee.' AND actif = 1');
										$unTarif = $TarifManager->retourne($options2);
										if($unTarif->getId()>0):?>
											<tr class="cell<?=($i%2==0)?'1':'2';?>">
												<td><?=$unTarif->getDate_naissance();?></td>
												<?php
													$laCategorie = '';
													$tab = explode(',', $unTarif->getCategorie());
													if(is_array($tab)):
														foreach($tab as $key => $club):
															$options = array('where' => 'id = '. $club);
															$uneCategorie = $CategorieManager->retourne($options);
															$laCategorie .= $uneCategorie->getCategorie();
															$laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
															if($key < count($tab)-1):
																$laCategorie .= ', ';
															endif;
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
													<?=$unTarif->getPrix_old();?> � <sup>(<?=$unTarif->getCondition_old();?>)</sup><br/>
													<?=($unTarif->getPrix_nv()>0)?'('. $unTarif->getPrix_nv() .'  � <sup>('. $unTarif->getCondition_nv() .')</sup> nouveaux adh�rents)':'';?>
												</td>
											</tr><?php
											$i++;
										endif;
									endforeach;
									if($i==1): ?>
										<tr>
											<td colspan=3>Les tarifs de la saison <?=$annee+1;?>-<?=$annee+2;?> sont en cours de r�alisation</td>
										</tr><?php
									endif;
								endif;?>
								</table>
								<?php
								if($i>1): ?>
									<br/>
									<p><sup>(1)</sup> Ce prix comprend la licence comp�tition valable de Septembre <?=$annee;?> � Septembre <?=$annee+1;?> + 1 �quipement de marque Hummel offert (comprenant 1 t-shirt + 1 paire de chaussettes ou 1 poignet en �ponge - pour les cat�gories �cole de hand et moins de 9)</p>
									<p><sup>(2)</sup> Ce prix comprend <sup>(1)</sup> + 1 ballon</p>
									<br/>
									<p><strong>*</strong> Pour les doublants CLOCA Handball et UNSS Handball du coll�ge une remise de 10 � est � d�duire du montant de la cotisation</p><?php
								endif; ?>
							</div><?php
						}
						elseif($onglet=="reglement_interieur") {?>
							<div id="reglement">
								<h3>ARTICLE 1 : Responsabilit�. </h3>
								<h4>1.1 Au gymnase. </h4>
								<p>Le club est responsable de vos enfants uniquement � l�int�rieur du gymnase, pendant ses horaires d�entra�nement et sous la directive d�un entra�neur. Vous devez v�rifier la pr�sence de celui-ci avant de d�poser vos ch�rubins. Vous ne devez en aucun cas laisser un enfant seul.</p>
								<h4>1.2 Transport de personnes mineures.</h4>
								<p>La partie � Autorisations Parentales � de la fiche d�inscription joueur doit imp�rativement �tre rendue compl�t�e et sign�e avec le reste du dossier. En cas d�absence de ces autorisations, nous ne pourrions pas assurer les d�placements de votre enfant pour les rencontres se d�roulant chez un club adverse.<p>
								<h3>ARTICLE 2 : Entra�nements. </h3>
								<h4>2.1 Horaires.</h4>
								<p>Les horaires d�entra�nement doivent �tre respect�s ; c�est � dire que les joueurs doivent �tre sur le terrain, en tenue et �  l�heure du d�but de s�ance.</p>
								<h4>2.2 Tenue.</h4>
								<p>Le Handball est un sport en salle, une tenue ad�quate est n�cessaire. Elle se compose d�un short, d�un maillot (T-shirt) et des  chaussures de salle propres.</p>
								<h4>2.3 Respect du mat�riel.</h4>
								<p>Tout adh�rent se doit de respecter le mat�riel mis � sa disposition autant sur le fonctionnement que sur la propret�.</p>
								<h3>ARTICLE 3 : Absences.</h3>
								<p>RAPPEL : Le Handball est un sport d��quipe et une �quipe comprenant moins de 5 joueurs (4 chez les petits) est d�clar�e forfait. En cons�quence, une sanction financi�re est appliqu�e au club. Toute absence � pr�visible � devra �tre signal�e, � l�entra�neur, au minimum 24 heures � l�avance.</p>
								<h4>3.1 Entra�nement.</h4>
								<p>En cas d�impossibilit� de se rendre � un entra�nement, il est indispensable de pr�venir son entra�neur. Tout manquement � cette r�gle pourra �tre sanctionn� au gr� de l�entra�neur.<p>
								<h4>3.2 Match.</h4>
								<p>En cas d�indisponibilit�, il est obligatoire de pr�venir, la personne responsable de l��quipe, la veille de la rencontre afin de pouvoir faire le n�cessaire. Toute absence non signal�e pourra entra�ner une sanction.</p>
								<h3>ARTICLE 4 : Sanctions.</h3>
								<h4>4.1 Sanctions morales.</h4>
								<p>L��chelle des sanctions va de la non-qualification pour une rencontre jusqu�� l�exclusion de la section.</p>
								<h4>4.2 Sanctions financi�res.</h4>
								<p>Le remboursement du montant d�une amende, notifi�e par les Autorit�s comp�tentes, pourra �tre demand� au joueur fautif ou � son repr�sentant l�gal. Toute d�gradation de mat�riel est inacceptable et donnera lieu � facturation.</p>
								<h3>ARTICLE 5 : Paiement.</h3>
								<h4>5.1 Paiement.</h4>
								<p>La licence de joueur ne sera demand�e, � la F�d�ration, qu�apr�s paiement int�gral du montant de la cotisation. Certaines facilit�s de paiement sont possibles sous r�serve d�un accord avec les dirigeants. A fin D�cembre, la totalit� de la cotisation doit �tre r�gl�e.</p> 
								<h4>5.2 Caution.</h4>
								<p>Tout joueur �tant en charge de sa tenue de match doit fournir, lors de son inscription, une caution de 100,00�. Celle-ci ne sera pas encaiss�e et sera rendue en fin de saison, � la restitution de la tenue compl�te et en bon �tat.</p>
								<h3>ARTICLE 6 : Mutation.</h3>
								<p>Pour toute demande de mutation vers le club d�Ach�res, le mutant devra r�gler le montant total des frais de mutation par ch�que qui ne sera encaiss� que si le joueur ne renouvelle pas son inscription la saison suivante. En cas de renouvellement de licence � Ach�res, le ch�que lui sera rendu.</p>
							</div><?php
						}
						else {?>
							<div id="documents_a_venir">
								<h3>Documents � t�l�charger <?=$annee;?>/<?=$annee + 1;?> :</h3>
								<table>
									<tr>
										<td><a href="upload/fiche_inscription_joueur_<?=$annee;?>_<?=$annee + 1;?>.pdf"><img src="upload/fiche_inscription_joueur_<?=$annee;?>_<?=$annee + 1;?>.jpg" alt="Fiche d'inscription joueur <?=$annee;?>-<?=$annee + 1;?>"/></a></td>
										<td><a href="upload/certificat_medical_<?=$annee;?>_<?=$annee + 1;?>.pdf"><img src="upload/certificat_medical_<?=$annee;?>_<?=$annee + 1;?>.jpg" alt="Certificat m�dical <?=$annee;?>-<?=$annee + 1;?>"/></a></td>
									</tr>
									<tr>
										<td><a href="upload/plaquette_recto_<?=$annee;?>_<?=$annee + 1;?>.jpg"><img src="upload/plaquette_recto_<?=$annee;?>_<?=$annee + 1;?>.jpg" alt="Plaquette recto <?=$annee;?>-<?=$annee + 1;?>"/><br/>Plaquette recto <?=$annee;?>-<?=$annee + 1;?></a></td>
										<td><a href="upload/plaquette_verso_<?=$annee;?>_<?=$annee + 1;?>.jpg"><img src="upload/plaquette_verso_<?=$annee;?>_<?=$annee + 1;?>.jpg" alt="Plaquette verso <?=$annee;?>-<?=$annee + 1;?>"/><br/>Plaquette verso <?=$annee;?>-<?=$annee + 1;?></a></td>
									</tr>
									<tr>
										<td><a href="upload/autorisation_parentale_fede_<?=$annee;?>_<?=$annee + 1;?>.pdf" data-lightbox="docs"><img src="upload/autorisation_parentale_fede_<?=$annee;?>_<?=$annee + 1;?>.jpg" alt="Autorisation Parentale <?=$annee;?>-<?=$annee + 1;?>"/></a></td>
										<td></td>
									</tr>
								</table>
							</div><?php
						}?>
					</article>
					<article class="col1">
						<article>
							<?php include_once('inc/infos.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/who_online.php'); ?>
						</article>
						<article class="marginT">
							<?php include_once('inc/partenaires.php'); ?>
						</article>
					</article>
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