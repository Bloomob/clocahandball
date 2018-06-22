<fieldset>
    <legend>Légende</legend>
    <p>PA = Petite Arche</p>
    <p>PdC = Pierre de Coubertin</p>
    <p>C = COSEC (Poissy)</p>
    <p>HdS = Halle des sports (Poissy)</p>
    <p>LF = Laura Flessel (Chanteloup-les-vignes)</p>
</fieldset>
<?php
$PH = $HoraireManager->planningHoraires($annee_actuelle);
$old_gymnase = '';
$old_jour = '';
$tabHeure = array();

if(is_array($PH)): ?>
    <table class="planning">
        <tr>
            <td colspan="2"></td><?php
            for($i=1000; $i<=2200; $i+=100):
                if($i<1300 || $i>=1700):?>
                    <td class="heure" colspan="4"><?=substr($i, 0, 2);?>h</td><?php

                endif;
            endfor;?>
        </tr>
        <tr class="minutes"><td colspan="2" class="no_minute"></td>
            <?php
            for($i=930, $y=2; $i<=2230; $i+=15):
                if(substr($i, -2)==60) $i+=40;
                if($i<=1230 || $i>1630):?>
                    <td <?=(substr($i, -2)==00)?'class="minute"':''; ?>><?=(substr($i, -2)==30)?substr($i, -2):''; ?></td><?php
                    $tabHeure[] = $i;
                    $y++;
                endif;
            endfor;?>
        </tr>
        <?php
        $z = 3;
        foreach($PH as $J=>$gymnase):
            $nbr_gymnase = count($gymnase);?>
            <tr class="ligne_planning j<?=$J;?>">
                <th rowspan='<?=$nbr_gymnase?>' class="jour"><?=substr($jour_de_la_semaine[$J-1], 0, 3)?></th><?php
                foreach($gymnase as $G=>$horaire) {
                    if($old_gymnase != ''):
                        $colblank = $y-$z;
                        if($colblank>0)
                            echo '<td colspan="'.$colblank.'"></td>';
                        echo '</tr><tr class="ligne_planning j'.$J.'">';
                        $z = 3;
                    endif;?>
                    <td><?=$G?></td><?php
                    $retour = '';
                    $old_key = 0;
                    $last_end_cat = 0;

                    foreach($horaire as $H=>$categorie) {
                        $deb = explode('-', $H);
                        if($old_key==0 || $last_end_cat != $deb[0]) {
                            $key = array_keys($tabHeure, $deb[0]);
                            $new_key = $key[0]++;
                            $K = $new_key - $old_key;
                            $retour .= '<td colspan="'.$K.'"></td>';
                            $old_key = $new_key;
                            $z+=$K;
                        }

                        $classeCat = str_replace('-', ' cat_', $categorie);

                        $key = array_keys($tabHeure, $deb[1]);
                        $new_key = $key[0]++;
                        $K = $new_key - $old_key;
                        $listeCatParHeure = explode('-', $categorie);
                        $max = count($listeCatParHeure);
                        $maChaine = '';
                        for($i=0; $i<$max; $i++) {
                            $options = array('where' => 'raccourci LIKE "'.$listeCatParHeure[$i].'"');
                            $uneCat = $CategorieManager->retourne($options);
                            $maChaine .= '<a href="/equipes.php?onglet='.$uneCat->getRaccourci().'">'.strtoupper($uneCat->getRaccourci()).'</a><br/><br/>';
                        }
                        $maChaine = substr($maChaine, 0, strlen($maChaine)-5);

                        $retour .= '<td colspan="'.$K.'" class="cat cat_'.$classeCat.'" id="'.$categorie.'/'.$J.'">'.$maChaine.'</td>';
                        $old_key = $new_key;
                        $z+=$K;

                        $last_end_cat = $deb[1];
                    }
                    echo $retour;
                    $old_gymnase = $G;
                }
                $colblank = $y-$z;
                if($colblank>0)
                    echo '<td colspan="'.$colblank.'"></td>';
                $z = 3;?>
            </tr><?php
            $old_gymnase = '';
        endforeach;?>
    </table><?php
endif; ?>