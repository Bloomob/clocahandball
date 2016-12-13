<?php
	$EquipeManager = new EquipeManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	
	$id = $_SESSION['id'];

	$options = array('where' => 'id = '.$id);
	$unUtilisateur = $UtilisateurManager->retourne($options);
	/*echo '<pre>';
	var_dump($unUtilisateur);
	echo '</pre>';*/
?>
<div class="tab_container">
	<div class="tab_content2 compte">
		<div>
			<h3 class="">Mon compte</h3>
		</div>
		<div class="form">
			<div class="content marginT">
				<h4>Informations g&eacute;n&eacute;rales</h4>
				<div class="pad">
					<div class="wrap marginTB10">
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="nom">Nom :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="text" id="nom" placeholder="Nom" value="<?=htmlspecialchars_decode($unUtilisateur->getNom());?>"/>
								</div>
								<div class="cell cell-1-5 red">*</div>
							</div>
						</div>
					</div>
					<div class="wrap marginTB10">
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="prenom">Pr&eacute;nom :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="text" id="prenom" placeholder="Pr&eacute;nom" value="<?=htmlspecialchars_decode($unUtilisateur->getPrenom());?>"/>
								</div>
								<div class="cell cell-1-5 red">*</div>
							</div>
						</div>
					</div>
					<div class="wrap marginTB10">
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="email">Email :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="text" id="email" placeholder="Email" value="<?=htmlspecialchars_decode($unUtilisateur->getMail());?>"/>
								</div>
								<div class="cell cell-1-5 red">*</div>
							</div>
						</div>
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5"></div>
								<div class="cell cell-3-5">
									<div class="boutons-actions align_right">
							      <a href="#" class="btn btn-save marginR">Sauvegarder</a>
							    </div>
								</div>
								<div class="cell cell-1-5 red"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content marginT">
				<h4>Informations de connexion</h4>
				<div class="pad">
					<div class="wrap marginTB10">
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="pseudo">Pseudo :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="text" id="pseudo" placeholder="Pseudo" value="<?=htmlspecialchars_decode($unUtilisateur->getPseudo());?>"/>
								</div>
								<div class="cell cell-1-5 red">*</div>
							</div>
						</div>
					</div>
					<div class="wrap marginTB10">
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="new_mot_de_passe">Nouveau mot de passe :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="password" id="new_mot_de_passe" placeholder="Nouveau mot de passe" value=""/>
								</div>
								<div class="cell cell-1-5 red"></div>
							</div>
						</div>
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5">
									<label for="confirm_mot_de_passe">Confirmer le mot de passe :</label>
								</div>
								<div class="cell cell-3-5">
									<input type="password" id="confirm_mot_de_passe" placeholder="Confirmer le mot de passe" value=""/>
								</div>
								<div class="cell cell-1-5 red"></div>
							</div>
						</div>
						<div class="table">
							<div class="row">
								<div class="cell cell-1-5"></div>
								<div class="cell cell-3-5">
									<div class="boutons-actions align_right">
							      <a href="#" class="btn btn-save marginR">Sauvegarder</a>
							    </div>
								</div>
								<div class="cell cell-1-5 red"></div>
							</div>
						</div>
					</div>
				</div>
		    
			</div>
		</form>
	</div>
</div>