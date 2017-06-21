<?php
	$MenuManager = new MenuManager($connexion);
	$MenuManagerManager = new Menu_ManagerManager($connexion);
	$EquipeManager = new EquipeManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
?>
<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<h1>
                <a href="#" class="logo"><img src="images/prev.png" alt="Prev" />C.L.O.C.A. HANDBALL</a>
                <span class="slogan">Le site officiel du Handball Ach&egrave;rois</span>
            </h1>
        </div>
        <div class="col-sm-4">
            <nav>
                <ul id="top_nav"><?php 
                    if(isset($_SESSION['prenom']) && isset($_SESSION['nom'])) { ?>
                        <li><a href='deconnexion.php' id="se_deconnecter"><!-- <i class="fa fa-sign-out" aria-hidden="true"></i>  -->Se d&eacute;connecter</a></li>
                        <li><a href='mon_profil.php' id="profil"><!-- <i class="fa fa-user" aria-hidden="true"></i>  -->Mon profil</a></li><?php
                    } else { ?>
                        <li><a href='#' data-toggle="modal" data-target="#connexionModal"><!-- <i class="fa fa-sign-in" aria-hidden="true"></i>  -->Se connecter</a></li>
                        <li><a href='#' id="s_inscrire">S'inscrire</a></li><?php
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
                <?php
                if ($page === 'admin'):
                    include_once('inc/modules/menu-header-admin.php');
                else:
                    include_once('inc/modules/menu-header.php');
                endif;?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="connexionLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Connexion</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="login">Pseudo</label><br>
                        <input type="text" id="login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label><br>
                        <input type="password" id="password" class="form-control">
                    </div>
                </form>
                <p class="alert alert-danger hidden">Le pseudo ou/et le mot de passe sont erronés. Merci de recommencer. <a href="#">Mot de passe oublié ?</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="btnConnexion">Se connecter</button>
            </div>
        </div>
    </div>
</div>