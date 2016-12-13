<?php
	// On enregistre notre autoload.
	function chargerClasse($classname)
	{
		require_once('../../classes/'.$classname.'.class.php');
	}
	spl_autoload_register('chargerClasse');

	// On inclue la page de connexion à la BDD & les constantes
	include_once("../connexion_bdd_pdo.php");
	include_once("../constantes.php");

	$id = (isset($_POST['id'])) ? $_POST['id'] : 0;

	$ActuManager = new ActualiteManager($connexion);
	$options = array('where' => 'id = '. $id);
	$uneActu = $ActuManager->retourne($options);

	if(!empty($uneActu)): ?>
		<div class="modif-fast">
			<div class="pad form">
            	<div class="wrap marginTB10">
					<div class="table">
						<div class="row">
							<div class="cell cell-1-5">
								<label for="titre">Titre</label>
							</div>
							<div class="cell cell-4-5">
								<input id="titre" type="text" placeholder="Entrer le titre" value="<?= stripslashes($uneActu->getTitre());?>" />
							</div>
						</div>
					</div>
				</div>
            	<div class="wrap marginTB10">
					<div class="table">
						<div class="row">
							<div class="cell cell-1-5">
								<label for="sous_titre">Sous-titre</label>
							</div>
							<div class="cell cell-4-5">
								<input id="sous_titre" type="text" placeholder="Entrer le sous-titre" value="<?= stripslashes($uneActu->getSous_titre());?>" />
							</div>
						</div>
					</div>
				</div>
	            <div class="wrap marginTB10">
					<div class="table">
						<div class="row">
							<div class="cell">
								<textarea id="contenu" class="tinymce" placeholder="Entrer le contenu"><?= stripslashes($uneActu->getContenu());?></textarea>
							</div>
						</div>
					</div>
				</div>
            	<div class="wrap marginTB10">
					<div class="table">
						<div class="row">
							<div class="cell cell-1-2 cell-top content">
            					<div class="wrap marginTB10">
									<div class="table">
										<div class="row">
											<div class="cell cell-1-2">
												<label for="theme">Thème</label>
											</div>
											<div class="cell cell-1-2">
								                <select id="theme"><?php
								                	foreach ($tabTheme as $key => $val) { ?>
								                		<option value="<?=$key;?>" <?=$uneActu->getTheme()==$key?'selected':''?>><?=$val;?></option><?php
								                	} ?>
								                </select>
											</div>
										</div>
									</div>
								</div>
				            	<div class="wrap marginTB10">
									<div class="table">
										<div class="row">
										 	<div class="cell cell-1-2">
								                <label for="date">Date de publication</label>
								            </div>
											<div class="cell cell-1-2">
								                <input class="datepicker" id="date" type="hidden" value="<?=$uneActu->getDate_publication()==0?"":$uneActu->getDate_publication();?>">
								                <span class="date"><?=$uneActu->getDate_publication()==0?"Aucune date selectionnée":$uneActu->getJourP()." ".$mois_de_lannee[intval($uneActu->getMoisP())-1]." ".$uneActu->getAnneeP();?></span>
								                <span class="heure" <?=$uneActu->getDate_publication()==0?"style='display:none'":"";?>>
								                    à 
								                    <select id="heure">
						                                <option value="0">-</option><?php
						                                for($i=900;$i<2130;$i+=15):
						                                    if(substr($i, -2)==60) $i+=40;?>
						                                    <option value="<?=$i;?>" <?=$uneActu->getHeure_publication()==$i?"selected":"";?>><?=substr($i,0,-2);?>h<?=substr($i,-2);?></option><?php
						                                endfor; ?>
						                            </select>
								                </span>
								            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="cell cell-1-2 cell-top content">
            					<div class="wrap marginTB10">
									<div class="table">
										<div class="row">
											<div class="cell cell-1-5">
									        	<label for="add_tag">Tags</label>
									        </div>
											<div class="cell cell-4-5">
								            	<input id="tags" type="hidden" value="<?=$uneActu->getTags();?>">
									            <div class="tags">
									            	<div class="liste_tags">
									            		<?php
									            			$listeTags = explode(",", $uneActu->getTags());
									            			foreach($listeTags as $tag):
									            				echo '<span class="tag"><span>'.$tag.'</span><a href="#" title="Retirer le tag">x</a></span>';
									            			endforeach;
									            		?>
									            	</div>
									                <input id="add_tag" type="text" placeholder="Ajouter un tag">
									            </div>
									        </div>
										</div>
									</div>
								</div>
				            	<div class="wrap marginTB10">
									<div class="table">
							            <div class="row">
							            	<div class="cell cell-1-5">
								                <label for="importance">Importance</label>
								            </div>
							            	<div class="cell cell-4-5">
								                <select id="importance"><?php
								                	foreach ($tabImportance as $key => $val) { ?>
								                		<option value="<?=$key;?>" <?=($uneActu->getImportance()==$key)?'selected':''?>><?=$val;?></option><?php
								                	} ?>
								                </select>
								            </div>
								        </div>
							        </div>
							    </div>
				            	<div class="wrap marginTB10">
									<div class="table">
							            <div class="row">
							            	<div class="cell cell-1-5">
							                	<label for="slider">Slider</label>
							                </div>
							            	<div class="cell cell-4-5">
							                    <input type="radio" class="slider" name="slider" value="0" <?=($uneActu->getSlider()==0)?'checked':''?> /> Non | 
							                    <input type="radio" class="slider" name="slider" value="1" <?=($uneActu->getSlider()==1)?'checked':''?> /> Oui
							            	</div>
							            </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="wrap marginTB10 align_left">
					<div class="boutons-actions">
				        <a href="#" class="btn btn-save marginR">Modifier</a>
				        <a href="#" class="btn btn-annul">Annuler</a>
				    </div>
				    <input id="id" type="hidden" value="<?=$uneActu->getId()==0?"":$uneActu->getId();?>">
				    <input id="image" type="hidden" value="<?=$uneActu->getId()==0?"":$uneActu->getImage();?>">
				</div>
			</div>
		</div> <?php
	endif;
?>