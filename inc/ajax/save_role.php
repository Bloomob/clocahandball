<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");

	$RoleManager = new RoleManager($connexion);

	if(isset($_POST['role'])) {
		$role = new Role( array() );

		$_POST['role'][0]['parent'] = intval($_POST['role'][0]['parent']);
		$_POST['role'][0]['ordre'] = intval($_POST['role'][0]['ordre']);
		$_POST['role'][0]['actif'] = intval($_POST['role'][0]['actif']);

		foreach ($_POST['role'][0] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($role, $method)) {
				$role->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
			}
		}
		
		$RoleManager->ajouter($role);
		$listeRoles = $RoleManager->retourneListeTries();
		?>
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Nom</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="boutons-actions">
					<h4>Raccourci</h4>
					<div>
						<a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
						<a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
					</div>
				</th>
				<th class="cell"></th>
			</tr>
			</thead><?php
			$i=0;
			if(!empty($listeRoles)):?>
				<tbody><?php
					foreach($listeRoles as $key1 => $value1):
						$options = array('where' => 'id = '.$key1);
						$unRoleParent = $RoleManager->retourne($options);?>
						<tr id="id_<?=$unRoleParent->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($unRoleParent->getActif()==0) echo ' inactif'; ?>">
							<td><input type="checkbox"/></td>
							<td><?=$unRoleParent->getNom();?></td>
							<td><?=$unRoleParent->getRaccourci();?></td>
							<td class="boutons-actions">
								<a href="<?=$unRoleParent->getId();?>" class="btn btn-modif btn-slim" title="Modifier le rôle">Modifier le r&ocirc;le</a>
								<a href="<?=$unRoleParent->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le rôle">Supprimer le r&ocirc;le</a>
							</td>
						</tr><?php
						$i++;
						foreach($value1 as $key2 => $value2):
							$options2 = array('where' => 'id = '.$value2);
							$unRoleEnfant = $RoleManager->retourne($options2);?>
							<tr id="id_<?=$unRoleEnfant->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($unRoleEnfant->getActif()==0) echo ' inactif'; ?>">
								<td><input type="checkbox"/></td>
								<td><?=$unRoleEnfant->getNom();?></td>
								<td><?=$unRoleEnfant->getRaccourci();?></td>
								<td class="boutons-actions">
									<a href="<?=$unRoleEnfant->getId();?>" class="btn btn-modif btn-slim" title="Modifier le rôle">Modifier le r&ocirc;le</a>
									<a href="<?=$unRoleEnfant->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer le rôle">Supprimer le r&ocirc;le</a>
								</td>
							</tr><?php
							$i++;
						endforeach;
					endforeach;?>
				</tbody><?php
			else:?>
				<tr>
					<td colspan="4">Aucun r&ocirc;le enregistr&eacute;</td>
				</tr><?php
			endif;?>
		</table>
		<?php
	}
?>