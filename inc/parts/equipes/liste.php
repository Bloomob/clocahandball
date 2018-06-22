<article class="liste_equipe col-sm-8">
    <div class="contenu">
        <h2><i class="fa fa-users" aria-hidden="true"></i><?=$titre?></h2>
        <div class="wrapper"><?php
            $options = array('where' => 'annee = '. $annee_actuelle, 'orderby' => 'niveau, championnat');
            $listeEquipe = $EquipeManager->retourneListe($options);
            // debug($listeEquipe);
            if(!empty($listeEquipe)):
                $i = 0;
                $niveau_actuel = '';
                foreach($listeEquipe as $uneEquipe):
                    $options = array('where' => 'id = '.$uneEquipe->getCategorie());
                    $laCategorie = $CategorieManager->retourne($options);

                    $liste_stats = $MatchManager->liste_stats($laCategorie->getId(), $annee_actuelle);
                    if(!empty($liste_stats)):
                        $bilan = '<span class="vert">'.$liste_stats['nb_vic'].'V</span> <span class="orange">'.$liste_stats['nb_nul'].'N</span> <span class="rouge">'.$liste_stats['nb_def'].'D</span>';
                    endif;

                    $serie = $MatchManager->cinq_derniers_matchs($laCategorie->getId());

                    if($uneEquipe->getNiveau() != $niveau_actuel):
                        if($i>0):?>
                            </div><?php
                        endif;?>
                        <h3>Niveau <?=$listeNiveau[$uneEquipe->getNiveau()];?></h3>
                        <div class="row"><?php
                    elseif($i%2 == 0) :?>
                        </div>
                        <div class="row marginT"><?php
                    endif;?>
                    <div class="col-sm-6">
                        <div class="bloc <?=$laCategorie->getRaccourci();?>">
                            <h4><a href="?onglet=<?=$laCategorie->getRaccourci();?>"><?=$laCategorie->getCategorieAll();?></a></h4>
                            <div class="pad">
                                <p><strong>Championnat : </strong><?=$listeChampionnat[$uneEquipe->getChampionnat()];?></p>
                                <p><strong>Série : </strong><?=$serie;?></p>
                                <p><strong>Bilan : </strong><?=$bilan;?></p>
                            </div>
                        </div>
                    </div><?php
                    $niveau_actuel = $uneEquipe->getNiveau();
                    $i++;
                endforeach;
                if($i%2==1):?>
                    <div class="col-sm-6"></div><?php
                endif; ?>
                </div><?php
            endif;?>
        </div>
    </div>
</article>