<?php
if(is_array($listeUtilisateurs)):
	// debug($listeUtilisateurs);
	foreach($listeUtilisateurs as $unUtilisateur):?>
		<tr>
			<td><?=$unUtilisateur->getNom();?></td>
			<td><?=$unUtilisateur->getPrenom();?></td>
			<td><?=$unUtilisateur->getMail();?></td>
			<td><?=$rang[$unUtilisateur->getRang()];?></td>
			<td><?=$unUtilisateur->getActif();?></td>
			<td>
				<button class="btn btn-warning edit-user"><i class="fa fa-edit" aria-hidden="true"></i></button>
				<button class="btn btn-danger delete-user"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</td>
		</tr><?php
	endforeach;
else:?>
	<tr>
		<td colspan="6">Aucun utilisateur enregistré</td>
	</tr><?php
endif;?>