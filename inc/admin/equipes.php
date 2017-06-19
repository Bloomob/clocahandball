<?php
	$EquipeManager = new EquipeManager($connexion);
	$UtilisateurManager = new UtilisateurManager($connexion);
	$CategorieManager = new CategorieManager($connexion);
	$RoleManager = new RoleManager($connexion);
	$HoraireManager = new HoraireManager($connexion);
	
	$options = array('orderby' => 'annee DESC, categorie');
	$listeEquipes = $EquipeManager->retourneListe($options);
	// echo '<pre>';
	// var_dump($listeEquipes);
	// echo '</pre>';
?>
<div class="row">
	<div class="col-xs-12">
        <h3>Liste des équipes</h3>
    </div>
    <div class="col-xs-12 text-right boutons-actions menus-action">
        <a href="#" class="btn btn-ajout">Filtrer</a>
        <a href="#" class="btn btn-ajout">Ajouter une équipe</a>
    </div>
    <div class="col-xs-12">
        <table class="table">
            <tr class="titres">
                <th></th>
                <th class="boutons-actions">
                    <h4>Catégorie</h4>
                    <div>
                        <a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
                        <a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
                    </div>
                </th>
                <th class="boutons-actions">
                    <h4>Année</h4>
                    <div>
                        <a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
                        <a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
                    </div>
                </th>
                <th class="boutons-actions">
                    <h4>Entraineurs</h4>
                    <div>
                        <a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
                        <a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
                    </div>
                </th>
                <th class="boutons-actions">
                    <h4>Entrainements</h4>
                    <div>
                        <a href="#" class="btn btn-tri-down btn-tiny" title="Tri A-Z">Tri down</a>
                        <a href="#" class="btn btn-tri-up btn-tiny marginL2" title="Tri Z-A">Tri up</a>
                    </div>
                </th>
                <th></th>
            </tr>
            <?php include('liste_equipes.php'); ?>
        </table>
    </div>
</div>