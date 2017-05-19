<?php
	$UtilisateurManager = new UtilisateurManager($connexion);
	// header("Location: /en_travaux/index.html");
	
	if(isset($_POST['bouton_connexion'])) {
		$pseudo = htmlspecialchars($_POST['login']);
		$mot_de_passe = md5(htmlspecialchars($_POST['mot_de_passe']));
		if($pseudo!='' && $mot_de_passe != '') {
			$tab_connexion = test_connexion($pseudo, $mot_de_passe);
			if(is_array($tab_connexion)) {
				$_SESSION['id'] =  $tab_connexion['id'];
				$_SESSION['nom'] = $tab_connexion['nom'];
				$_SESSION['prenom'] = $tab_connexion['prenom'];
				$_SESSION['rang'] = $tab_connexion['rang'];
				
				if($_SESSION['rang']==1) {
					header("Location: admin.php");
					exit;
				}
				
				header("Location: mon_profil.php");
				exit;
			}
		}
		header("Location: ".$page.".php");
		exit;
	}
	elseif(isset($_POST['bouton_inscription'])) {
		if(isset($page)):
			header("Location: ".$page.".php");
			exit;
		else:
			header("Location: index.php");
			exit;
		endif;
	}

	if(!isset($_SESSION['nom']) && $page == 'mon_profil') {
		header("Location: index.php");
	}
	
	if((!isset($_SESSION['rang']) OR !accesAutorise($_SESSION['rang'])) && $page == 'admin') {
		header("Location: index.php");
	}
	
	if(isset($_SESSION['id']))
		$id = $_SESSION['id'];
	else 
		$id = 0;
		
	$UtilisateurManager->ajoutUserOnline($id, ip2long($_SERVER['REMOTE_ADDR']), $page);
?>