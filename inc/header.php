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
                        <li><a href='#' data-toggle="modal" data-target="#inscriptionModal">S'inscrire</a></li><?php
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
                        <label for="mail">Email</label><br>
                        <input type="email" id="mail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label><br>
                        <input type="password" id="password" class="form-control">
                    </div>
                </form>
                <p class="alert alert-danger hidden">L'email ou/et le mot de passe sont erronés. Merci de recommencer. <a href="#">Mot de passe oublié ?</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="btnConnexion">Se connecter</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="inscriptionModal" tabindex="-1" role="dialog" aria-labelledby="connexionLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inscription</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nom">Nom <span class="text-danger">*</span></label><br>
                                <input type="text" id="nom" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le nom est obligatoire">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="prenom">Prénom <span class="text-danger">*</span></label><br>
                                <input type="text" id="prenom" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le prénom est obligatoire">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="mail">Email <span class="text-danger">*</span></label><br>
                                <input type="email" id="mail" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="L'email est obligatoire">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="num_licence">N° de licence</label><br>
                                <input type="text" id="num_licence" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mot_de_passe">Mot de passe <span class="text-danger">*</span></label><br>
                                <input type="password" id="mot_de_passe" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Le mot de passe doit faire plus de 5 caractères">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm_mot_de_passe">Confirmer le mot de passe <span class="text-danger">*</span></label><br>
                                <input type="password" id="confirm_mot_de_passe" class="form-control" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Les deux mots de passes sont différents">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-danger">* Champs obligatoires</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="btnInscription">S'inscrire</button>
            </div>
        </div>
    </div>
</div>