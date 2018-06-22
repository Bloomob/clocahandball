<?php
$TarifManager = new TarifManager($connexion);
$CategorieManager = new CategorieManager($connexion);

$options = array('orderby' => 'ordre');
$listeCategories = $CategorieManager->retourneListe($options);?>
<div id="tarifs">
    <table class="table">
        <tr>
            <th>Né(e) en</th>
            <th>Categories</th>
            <th>Tarifs</th>
        </tr><?php
    if(!empty($listeCategories)):
        $i = 1;
        // debug($listeCategories);
        foreach ($listeCategories as $uneCategorie):
            $options2 = array('where' => 'categorie IN ('.$uneCategorie->getId().') AND annee = '.$annee_actuelle.' AND actif = 1');
            $unTarif = $TarifManager->retourne($options2);
            if($unTarif->getId()>0):?>
                <tr class="cell<?=($i%2==0)?'1':'2';?>">
                    <td><?=$unTarif->getDate_naissance();?></td>
                    <?php
                        $laCategorie = '';
                        $lastCategorie = new Categorie(array());
                        $tab = explode(',', $unTarif->getCategorie());
                        if(is_array($tab)):
                            foreach($tab as $key => $club):
                                $options = array('where' => 'id = '. $club);
                                $uneCategorie = $CategorieManager->retourne($options);
                                if($lastCategorie->getCategorie() != $uneCategorie->getCategorie() || $unTarif->getGenre()):                                                                        $laCategorie .= $uneCategorie->getCategorie();
                                    $laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
                                  if($key < count($tab)-1):
                                    $laCategorie .= ', ';
                                 endif;
                                endif;
                                $lastCategorie = $uneCategorie;
                            endforeach;
                        else:
                            $options = array('where' => 'id = '. $tab);
                            $uneCategorie = $CategorieManager->retourne($options);
                            $laCategorie = $uneCategorie->getCategorie();
                            $laCategorie .= ($unTarif->getGenre()) ? ' '.$uneCategorie->getGenre() : '';
                        endif;
                    ?>
                    <td>
                        <?=$laCategorie;?>
                    </td>
                    <td>
                        <?=$unTarif->getPrix_old();?> € <sup>(<?=$unTarif->getCondition_old();?>)</sup><br/>
                        <?=($unTarif->getPrix_nv()>0)?'('. $unTarif->getPrix_nv() .'  € <sup>('. $unTarif->getCondition_nv() .')</sup> nouveaux adhérents)':'';?>
                    </td>
                </tr><?php
                $i++;
            endif;
        endforeach;
        if($i==1): ?>
            <tr>
                <td colspan=3>Les tarifs de la saison <?=$annee_actuelle;?>-<?=$annee_suiv;?> sont en cours de réalisation</td>
            </tr><?php
        endif;
    endif;?>
    </table>
    <?php
    if($i>1): ?>
        <div class="marginT">
          <p><sup>(1)</sup> Ce prix comprend la licence compétition valable de Septembre <?=$annee_actuelle;?> à Septembre <?=$annee_suiv;?> + 1 équipement de marque Hummel offert (comprenant 1 t-shirt + 1 paire de chaussettes ou 1 poignet en éponge - pour les catégories école de hand et moins de 9 ans)</p>
          <p class="hidden"><sup>(2)</sup> Ce prix comprend <sup>(1)</sup> + 1 ballon</p>
          <br/>
          <p><strong>*</strong> Pour les doublants CLOCA Handball et UNSS Handball du collège une remise de 10 € est à déduire du montant de la cotisation</p>
        </div><?php
    endif; ?>
</div>