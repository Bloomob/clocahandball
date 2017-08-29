<?php
	$RoleManager = new RoleManager($connexion);

	$listeRoles = $RoleManager->retourneListeTries();
	// echo '<pre>';
	// var_dump($listeRoles);
	// echo '</pre>';
?>
<div class="wrapper role">
    <div class="row">
    	<div class="col-xs-12">
            <h3>Liste des rôles</h3>
        </div>
        <div class="col-xs-12 text-right marginB">
           <button class="btn btn-primary" data-toggle="modal" data-target="#filterRoleModal"><i class="fa fa-filter" aria-hidden="true"></i> Filtrer</button>
           <button class="btn btn-success" data-toggle="modal" data-target="#roleModal"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un rôle</button>
        </div>
        <div class="col-xs-12">
            <table class="table liste-roles">
                <tr class="thead-inverse">	
					<th>Nom</th>
					<th>Raccourci</th>
				    <th></th>
                </tr><?php
                if(!empty($listeRoles)):?>
                    <tbody><?php
                        foreach($listeRoles as $key1 => $value1):
                            $options = array('where' => 'id = '.$key1);
                            $unRoleParent = $RoleManager->retourne($options);?>
                            <tr id="id_<?=$unRoleParent->getId();?>" class="infos<?php if($unRoleParent->getActif()==0) echo ' inactif'; ?>">
                                <td><?=$unRoleParent->getNom();?></td>
                                <td><?=$unRoleParent->getRaccourci();?></td>
                                <td class="text-right">
                                    <button class="btn btn-warning edit-match" data-id="<?=$unRoleParent->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
									<button class="btn btn-danger delete-match" data-id="<?=$unRoleParent->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>
                            </tr><?php
                            foreach($value1 as $key2 => $value2):
                                $options2 = array('where' => 'id = '.$value2);
                                $unRoleEnfant = $RoleManager->retourne($options2);?>
                                <tr id="id_<?=$unRoleEnfant->getId();?>" class="infos<?php if($unRoleEnfant->getActif()==0) echo ' inactif'; ?>">
                                    <td><?=$unRoleEnfant->getNom();?></td>
                                    <td><?=$unRoleEnfant->getRaccourci();?></td>
                                    <td class="text-right">
                                        <button class="btn btn-warning edit-match" data-id="<?=$unRoleEnfant->getId();?>"><i class="fa fa-edit" aria-hidden="true"></i></button>
									   <button class="btn btn-danger delete-match" data-id="<?=$unRoleEnfant->getId();?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr><?php
                            endforeach;
                        endforeach;?>
                    </tbody><?php
                else:?>
                    <tr>
                        <td colspan="4">Aucun r&ocirc;le enregistr&eacute;</td>
                    </tr><?php
                endif;?>
            </table>
        </div>
    </div>