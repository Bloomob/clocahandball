<?php
if(is_array($listeUtilisateurs)):
	foreach($listeUtilisateurs as $unUtilisateur):?>
		<tr>
			<td><span class="utilisateurs_nom"><?=$unUtilisateur->getNom();?></span></td>
			<td><span class="utilisateurs_prenom"><?=$unUtilisateur->getPrenom();?></span></td>
			<td><span class="utilisateurs_mail"><?=$rang[$unUtilisateur->getRang()];?></span></td>
			<td><span class="utilisateurs_actif"><?=$unUtilisateur->getActif();?></span></td>
			<td class="boutons-actions">
				<a href="<?=$unUtilisateur->getId();?>" class="btn btn-modif btn-slim" title="Modifier">Modifier l'utilisateur</a>
				<a href="<?=$unUtilisateur->getId();?>" class="btn btn-suppr btn-slim" title="Supprimer">Supprimer l'utilisateur</a>
			</td>
		</tr><?php
	endforeach;
else:?>
	<tr>
		<td colspan="5">Aucun utilisateur enregistré</td>
	</tr><?php
endif;?>