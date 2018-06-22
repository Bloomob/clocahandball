<?php
$listeStats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
if(!empty($listeStats)):?>
    <div class="marginT">
        <div class="row">
            <div class="col-sm-6 bilan_matchs">
                <div id="chart"></div>
            </div>
            <div class="col-sm-6 stats_buts"><?php
                $liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
                // debug($liste_stats);?>
                <div class="buts_pour clear_b">
                    <h4>Buts marqu&eacute;s</h4>
                    <div class="total_buts_pour"><?=$liste_stats['nb_bp'];?></div>
                    <div class="total_buts_pour_dom">Domicile : <strong><?=$liste_stats['nb_bp_dom'];?></strong></div>
                    <div class="total_buts_pour_ext">Exterieur : <strong><?=$liste_stats['nb_bp_ext'];?></strong></div>
                </div>
                <div class="buts_contre clear_b">
                    <h4>Buts encaiss&eacute;s</h4>
                    <div class="total_buts_contre"><?=$liste_stats['nb_bc'];?></div>
                    <div class="total_buts_contre_dom">Domicile : <strong><?=$liste_stats['nb_bc_dom'];?></strong></div>
                    <div class="total_buts_contre_ext">Exterieur : <strong><?=$liste_stats['nb_bc_ext'];?></strong></div>
                </div>
                <div class="<?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'buts_diff_pos':'buts_diff_neg';?> clear_b">
                    <h4>Diff&eacute;rence de buts</h4>
                    <div class="total_buts_diff"><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp']-$liste_stats['nb_bc'];?></div>
                    <div class="total_buts_diff_dom">Domicile : <strong><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp_dom']-$liste_stats['nb_bc_dom'];?></strong></div>
                    <div class="total_buts_diff_ext">Exterieur : <strong><?=($liste_stats['nb_bp']-$liste_stats['nb_bc']>0)?'+':'';?><?=$liste_stats['nb_bp_ext']-$liste_stats['nb_bc_ext'];?></strong></div>
                </div>
            </div>
        </div>
    </div><?php
endif;?>