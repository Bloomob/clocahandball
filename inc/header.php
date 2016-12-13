<?php
	$MenuManager = new MenuManager($connexion);
	$EquipeManager = new EquipeManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
?>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
			<h1>
                <a href="#" class="logo"><img src="images/prev.png" alt="Prev" />C.L.O.C.A. HANDBALL</a>
                <span class="slogan">Le site officiel du Handball Ach&egrave;rois</span>
            </h1>
        </div>
        <div class="col-sm-3">
            <nav>
                <ul id="top_nav"><?php 
                    if(isset($_SESSION['prenom']) && isset($_SESSION['nom'])) { ?>
                        <li><a href='deconnexion.php' id="se_deconnecter">Se d&eacute;connecter</a></li>
                        <li><a href='mon_profil.php' id="profil">Mon profil</a></li><?php
                    } else { ?>
                        <li><a href='#' id="se_connecter">Se connecter</a></li>
                        <!--<li><a href='#' id="s_inscrire">S'inscrire</a></li>--><?php
                    }
                    if(isset($_SESSION['rang']) && $_SESSION['rang']) {?>
                        <li><a href='admin.php'>Admin</a></li><?php
                    }?>
                    <!--<li><a href='#'>Aide</a></li>-->
                    <li><a href='contact.php'>Contact</a></li>
                </ul>
            </nav>
		</div>
    </div>
</div>
<div class="degrade">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php include_once('inc/modules/menu-header.php'); ?>
            </div>
        </div>
    </div>
</div>

<div id="connexion" class="hidden">
    <img src="images/icon/png_black/remove.png" id="fermer"/>
    <div class="c_contenu">
        <form method="post" action="">
            <div class="login">
                <label for="login">Login</label><br/>
                <input type="text" id="login" name="login"/>
            </div>
            <div class="mot_de_passe">
                <label for="mot_de_passe">Mot de passe</label><br />
                <input type="password" id="mot_de_passe" name="mot_de_passe"/>
            </div>
            <div class="boutons-actions">
                <input type="submit" id="bouton_connexion" class="btn btn-play" name="bouton_connexion" value="SE CONNECTER"/>
            </div>
        </form>
    </div>
</div>