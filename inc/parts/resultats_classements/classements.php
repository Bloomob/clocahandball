<div class="legende"><i class="fa fa-info-circle" aria-hidden="true"></i>La liste des classements de toutes nos équipes engagées.</div>
<div><?php
    // $lesClassements = retourne_tous_classements($annee);
    $lesClassements = array();
    if(empty($lesClassements)):?>
        <p>Pas de classement pour le moment.</p><?php
    else:
        foreach($lesClassements as $unClassement):?>
            <div class="unClassement">
                <div class="row">
                    <div class="col-xs-4"><?=$unClassement['categorie']?></div>
                    <div class="col-xs-4">mise à jour : <?=$unClassement['newDate']?></div>
                    <div class="col-xs-4"><a href="<?=$unClassement['classement']?>" target="_blank">Lien vers le classement</a></div>
                </div>
            </div><?php
        endforeach;
    endif;?>
</div>