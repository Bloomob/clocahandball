<fieldset>
    <legend><i class="fa fa-info" aria-hidden="true"></i>Informations générales</legend>
    <form>
        <div class="row infos">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_prenom">Prénom <span class="text-danger">*</span></label><br>
                    <input type="text" id="infos_prenom" name="infos_prenom" class="form-control" value="<?=$unUtilisateur->getPrenom();?>" placeholder="Entrer votre prénom" required/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_nom">Nom <span class="text-danger">*</span></label><br>
                    <input type="text" id="infos_nom" name="infos_nom" class="form-control" value="<?=$unUtilisateur->getNom();?>" placeholder="Entrer votre nom" required/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_email">Email <span class="text-danger">*</span></label><br>
                    <input type="email" id="infos_email" name="infos_email" class="form-control" value="<?=$unUtilisateur->getMail();?>" placeholder="Entrer votre email" required/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_num_licence">Numéro de licence</label><br>
                    <input type="text" id="infos_num_licence" name="infos_num_licence" class="form-control" value="<?=$unUtilisateur->getNum_licence();?>" placeholder="Entrer votre numéro de licence"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_tel">Téléphone</label><br>
                    <input type="text" id="infos_tel" name="infos_tel" class="form-control" value="<?=$unUtilisateur->getTel_port();?>" placeholder="Entrer votre numéro de téléphone"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class="btn btn-success edit-profil" data-profil="infos">Valider vos informations</button>
            </div>
        </div>
    </form>
</fieldset>
<fieldset>
    <legend><i class="fa fa-key" aria-hidden="true"></i>Changer de mot de passe</legend>
    <form>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_password_old">Mot de passe actuelle <span class="text-danger">*</span></label><br>
                    <input type="password" id="infos_password_old" name="infos_password_old" class="form-control" placeholder="Entrer votre ancien mot de passe"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_password_new">Nouveau mot de passe <span class="text-danger">*</span></label><br>
                    <input type="password" id="infos_password_new" name="infos_password_new" class="form-control" placeholder="Entrer votre nouveau mot de passe"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="infos_password_new_confirm">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label><br>
                    <input type="password" id="infos_password_new_confirm" name="infos_password_new_confirm" class="form-control" placeholder="Confirmer votre nouveau mot de passe"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-success edit-profil" data-profil="password">Valider votre nouveau mot de passe</button>
            </div>
        </div>
    </form>
</fieldset>
<fieldset>
    <legend id="fav"><i class="fa fa-heart" aria-hidden="true"></i>Mes équipes favorites</legend>
    <form>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="liste_equipes_favorites">Vos équipes favorites</label><br>
                    <select id="liste_equipes_favorites" name="liste_equipes_favorites" class="form-control selectpicker" multiple data-live-search="true" data-actions-box="true" title="Choisisser les équipes à suivre"><?php
                        $liste_fav = explode(',', $unUtilisateur->getListe_equipes_favorites());
                        foreach($listeCategories as $uneCategorie):?>
                        <option value="<?=$uneCategorie->getId();?>" <?=(in_array($uneCategorie->getId(), $liste_fav)) ? 'selected' : '';?>><?=$uneCategorie->getCategorieAll();?></option><?php
                        endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-success edit-profil" data-profil="fav-team">Valider vos équipes favorites</button>
            </div>
        </div>
    </form>
</fieldset>