<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD
	include_once("../../inc/connexion_bdd_pdo.php");

	$CategorieManager = new CategorieManager($connexion);

	if(isset($_POST['categorie'])) {
		$categorie = new Categorie( array() );

		$_POST['categorie'][0]['numero'] = intval($_POST['categorie'][0]['numero']);
		$_POST['categorie'][0]['ordre'] = intval($_POST['categorie'][0]['ordre']);
		$_POST['categorie'][0]['actif'] = intval($_POST['categorie'][0]['actif']);

		foreach ($_POST['categorie'][0] as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($categorie, $method)) {
				$categorie->$method(htmlspecialchars_decode(htmlentities($value, ENT_QUOTES, "UTF-8")));
				// $categorie->$method($value);
			}
		}
		
		$CategorieManager->ajouter($categorie);

		$options = array('orderby' => 'ordre');
		$listeCategories = $CategorieManager->retourneListe($options);
		?>
		<table>
			<tr class="titres">
				<th></th>
				<th class="boutons-actions">
					<h4>Categorie</h4>
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
			if(!empty($listeCategories)):?>
				<tbody><?php
					foreach($listeCategories as $uneCategorie):?>
						<tr id="id_<?=$uneCategorie->getId();?>" class="infos<?php if($i%2==1) echo ' odd'; ?><?php if($uneCategorie->getActif()==0) echo ' inactif'; ?>">
							<td><input type="checkbox"/></td>
							<td><?=$uneCategorie->getCategorie();?> <?=$uneCategorie->getGenre();?> <?=$uneCategorie->getNumero();?></td>
							<td><?=$uneCategorie->getRaccourci();?></td>
							<td class="boutons-actions">
								<a href="<?=$uneCategorie->getId();?>" class="btn btn-modif btn-slim" title="Modifier la categorie">Modifier la cat&eacute;gorie</a>
								<a href="<?=$uneCategorie->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer la categorie">Supprimer la cat&eacute;gorie</a>
							</td>
						</tr><?php
						$i++;
					endforeach;?>
				</tbody><?php
			else:?>
				<tr>
					<td colspan="4">Aucune cat&eacute;gorie enregistr&eacute;e</td>
				</tr><?php
			endif;?>
		</table>
		<?php
	}
?>