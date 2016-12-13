$(function() {
	
	$("#content .contenu_monProfil > div").hide(); //Hide all content
	$("#content .bloc_profil .ligne_profil a:first").addClass("active").show(); //Activate first tab
	$("#content .contenu_monProfil > div:first").show(); //Show first tab content
	
	$("#content .bloc_profil .ligne_profil a").click(function() {
		$("#content .bloc_profil .ligne_profil a").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$("#content .contenu_monProfil > div").hide(); //Hide all tab content
	
		var activeTab = $(this).attr("href"); //Find the href attribute value to identify the active tab + content
		$("#content .contenu_monProfil > ."+activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	
	$( ".calendar .right div" ).click(function( event ) {
		if($( event.target ).is( 'a.add_match' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/match.php",
				data: { 
					laCategorie: $(this).find('a').attr("href")
				},
				success: function(data) {
					$( "#modif_match" ).html(data);
					var add_match = $( "#modif_match .ajout_match" );
					add_match.dialog({
						title: "Ajouter un match",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/ajouter_match.php",
									data: { 
										team_categorie: $('#team_categorie').val(),
										team_jour: $('#team_jour').val(),
										team_mois: $('#team_mois').val(),
										team_annee: $('#team_annee').val(),
										team_heure: $('#team_heure').val(),
										team_minute: $('#team_minute').val(),
										team_lieu: $('#team_lieu').val(),
										team_gymnase: $('#team_gymnase').val(),
										team_adresse: $('#team_adresse').val(),
										team_ville: $('#team_ville').val(),
										team_code_postal: $('#team_code_postal').val(),
										team_competition: $('#team_competition').val(),
										team_niveau: $('#team_niveau').val(),
										team_journee: $('#team_journee').val(),
										team_tour: $('#team_tour').val(),
										team_adversaire1: $('#team_adversaire1').val(),
										team_adversaire2: $('#team_adversaire2').val(),
										team_adversaire3: $('#team_adversaire3').val(),
										team_dom1: $('#team_dom1').val(),
										team_ext1: $('#team_ext1').val(),
										team_dom2: $('#team_dom2').val(),
										team_ext2: $('#team_ext2').val(),
										team_dom3: $('#team_dom3').val(),
										team_ext3: $('#team_ext3').val(),
										team_joue: $('#team_joue input:checked').val(),
										team_arbitre: $('#team_arbitre').val(),
										team_classement: $('#team_classement').val()
									},
									success: function(data2) {
										$('#modif_match').html('<p>'+ data2 +'</p>');
										add_match.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "mon_profil.php";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_match.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		
		return false;
	});
	
	
	
	
	$( ".players .right div" ).click(function( event ) {
		if($( event.target ).is( 'a.add_joueur' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/joueur.php",
				data: { 
					raccourci: $(this).find('a').attr("href")
				},
				success: function(data) {
					$( "#modif_match" ).html(data);
					var add_joueur = $( "#modif_match .add_joueur" );
					add_joueur.dialog({
						title: "Ajouter un joueur",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/ajouter_joueur.php",
									data: {
										raccourci: cat[0],
										numero: $('#numero').val(),
										id_prenom_nom: $('#id_prenom_nom').val(),
										nom: $('#nom').val(),
										prenom: $('#prenom').val(),
										poste: $('#poste').val()
									},
									success: function(data2) {
										$('#modif_match').html('<p>'+ data2 +'</p>');
										add_joueur.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "mon_profil.php";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_joueur.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		
		return false;
	});
	
	
	$( "#tab_admin table td.boutons-actions a.btn-convoc" ).click( function() {
		var lesIDs = $(this).attr("href").split('_'),
			id_cat = $('#id_equipe').val();

		showLoader();

		$.ajax({
			type: "POST",
			url: "inc/ajax/convocation.php",
			data: { id_cat: id_cat },
			success: function(data) {
				$( '#tab'+ lesIDs[1]+'_2 .wrapper').hide("clip");
				$( '#convoc'+ lesIDs[1] ).html(data);
				$( '#convoc'+ lesIDs[1] ).show("clip");
				hideLoader();
			}
		});
		return false;
	});
	/*
		else if($( event.target ).is( 'a.modif_match' )) {
			var id_match = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax_modif_match.php",
				data: { id: id_match },
				success: function(data) {
					var modif_match = $( "#modif_match" ).html(data);
					modif_match.dialog({
						title: "Modifier un match",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Actualiser": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax_req_modif_match.php",
									data: { 
										id: id_match,
										team_categorie: $('#team_categorie').val(),
										team_jour: $('#team_jour').val(),
										team_mois: $('#team_mois').val(),
										team_annee: $('#team_annee').val(),
										team_heure: $('#team_heure').val(),
										team_minute: $('#team_minute').val(),
										team_lieu: $('#team_lieu').val(),
										team_gymnase: $('#team_gymnase').val(),
										team_adresse: $('#team_adresse').val(),
										team_ville: $('#team_ville').val(),
										team_code_postal: $('#team_code_postal').val(),
										team_competition: $('#team_competition').val(),
										team_niveau: $('#team_niveau').val(),
										team_journee: $('#team_journee').val(),
										team_tour: $('#team_tour').val(),
										team_adversaire1: $('#team_adversaire1').val(),
										team_adversaire2: $('#team_adversaire2').val(),
										team_adversaire3: $('#team_adversaire3').val(),
										team_dom1: $('#team_dom1').val(),
										team_ext1: $('#team_ext1').val(),
										team_dom2: $('#team_dom2').val(),
										team_ext2: $('#team_ext2').val(),
										team_dom3: $('#team_dom3').val(),
										team_ext3: $('#team_ext3').val(),
										team_joue: $('#team_joue input:checked').val(),
										team_arbitre: $('#team_arbitre').val(),
										team_classement: $('#team_classement').val()
									},
									success: function(data2) {
										$('#modif_match').html('<p>'+ data2 +'</p>');
										modif_match.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "mon_profil.php";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_match.dialog('destroy');
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr_match' )) {
			var id_match = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax_suppr_match.php",
				success: function(data) {
					var modif_match = $( "#modif_match" ).html(data);
					modif_match.dialog({
						title: "Supprimer un match",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Supprimer": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax_req_suppr_match.php",
									data: { 
										id: id_match
									},
									success: function(data2) {
										$('#modif_match').html('<p>'+ data2 +'</p>');
										modif_match.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "admin.php";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_match.dialog('destroy');
							} 
						},
						modal: true
					});
				}
			});
		}
		
		return false;
	});
	
	$( ".menu_profil .right div" ).click(function( event ) {
		if($( event.target ).is( 'a.update_classement' )) {
			var id_team = $(this).find('a').attr('href');
			var update_classement = $( "<div id='update_classement'><textarea name='new_classement'></textarea></div>" ).appendTo( "body" );
			update_classement.dialog({
				title: "Actualiser le classement",
				draggable: false,
				resizable: false,
				width: 450,
				height: 350,
				buttons: { 
					"Actualiser": function() {
						var monchamp = $('#update_classement textarea').val().replace(new RegExp("\t\n|\t|\n","g"), ',');
						$.ajax({
							type: "POST",
							url: "inc/ajax_update_classement.php",
							data: { donnees: monchamp, id_equipe: id_team },
							success: function(data) {
								$('#update_classement').html('<p>'+ data +'</p>');
							}
						});
						setTimeout(function(){
							update_classement.remove();
						}, 2000);
					},
					"Annuler": function() {
						update_classement.remove();
					} 
				},
				modal: true
			});
		}
		else if($( event.target ).is( 'a.add_news' )) {
			var id_team = $(this).find('a').attr('href');
			var add_news = $( "<div id='add_news'><div class='news_titre'><label for='news_titre'>Titre :</label><input type='text' id='news_titre' /></div><div class='news_contenu'><textarea name='news_contenu' id='news_contenu'></textarea></div><div class='news_important'><label>Mettre en tête d'affiche ?</label><label for='news_important_oui'>Oui : </label><input type='radio' id='news_important_oui' name='news_important' value='1' /><label for='news_important_non'>Non : </label><input type='radio' id='news_important_non' name='news_important' value='0' checked /></div><div class='news_publie'><label>Publié ?</label><label for='news_publie_oui'>Oui : </label><input type='radio' id='news_publie_oui' name='news_publie' value='1' /><label for='news_publie_non'>Non : </label><input type='radio' id='news_publie_non' name='news_publie' value='0' checked /></div></div>" ).appendTo( "body" );
			add_news.dialog({
				title: "Publier une news",
				draggable: false,
				resizable: false,
				width: 450,
				height: 350,
				buttons: { 
					"Publier": function() {
						var news_titre = $('#add_news .news_titre input').val();
						var news_contenu = $('#add_news .news_contenu textarea').val();
						var news_important = $('#add_news .news_important input:checked').val();
						var news_publie = $('#add_news .news_publie input:checked').val();
						$.ajax({
							type: "POST",
							url: "inc/ajax_add_news.php",
							data: { titre: news_titre, contenu: news_contenu, important: news_important, publie: news_publie, id_equipe: id_team },
							success: function(data) {
								$('#add_news').html('<p>'+ data +'</p>');
							}
						});
						setTimeout(function(){
							location.href = "mon_profil.php";
						}, 1000);
					},
					"Annuler": function() {
						add_news.remove();
					} 
				},
				modal: true
			});
		}
		else if($( event.target ).is( 'a.gest_players' )) {
			var lesIDs = $(this).find('a').attr("href").split('_');
			$.ajax({
				type: "POST",
				url: "inc/ajax_joueurs.php",
				data: { raccourci: lesIDs[0], j: lesIDs[1] },
				success: function(data) {
					
					$( '#tab'+ lesIDs[1]+'_2 .onglets').hide("clip");
					$( '#gestion_joueurs_'+ lesIDs[1] ).html(data);
					$( '#gestion_joueurs_'+ lesIDs[1] ).show("clip");
				}
			});
		}
		else if($( event.target ).is( 'a.gest_calendar' )) {
			var lesIDs = $(this).find('a').attr("href").split('_');
			$( '#tab'+ lesIDs[1]+'_2 .onglets').hide("clip");
			$( '#cal'+ lesIDs[1]).show("clip");
		}
		else if($( event.target ).is( 'a.gest_equipe' )) {
			var lesIDs = $(this).find('a').attr("href").split('_');
			$( '#tab'+ lesIDs[1]+'_2 .onglets').hide("clip");
			$( '#gestion_infos_'+ lesIDs[1]).show("clip");
		}
		else if($( event.target ).is( 'a.add_match' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax_ajout_match.php",
				data: { 
					laCategorie: $(this).find('a').attr("href")
				},
				success: function(data) {
					var add_match = $( "#modif_match" ).html(data);
					add_match.dialog({
						title: "Ajouter un match",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax_req_ajout_match.php",
									data: { 
										team_categorie: $('#team_categorie').val(),
										team_jour: $('#team_jour').val(),
										team_mois: $('#team_mois').val(),
										team_annee: $('#team_annee').val(),
										team_heure: $('#team_heure').val(),
										team_minute: $('#team_minute').val(),
										team_lieu: $('#team_lieu').val(),
										team_gymnase: $('#team_gymnase').val(),
										team_adresse: $('#team_adresse').val(),
										team_ville: $('#team_ville').val(),
										team_code_postal: $('#team_code_postal').val(),
										team_competition: $('#team_competition').val(),
										team_niveau: $('#team_niveau').val(),
										team_journee: $('#team_journee').val(),
										team_tour: $('#team_tour').val(),
										team_adversaire1: $('#team_adversaire1').val(),
										team_adversaire2: $('#team_adversaire2').val(),
										team_adversaire3: $('#team_adversaire3').val(),
										team_dom1: $('#team_dom1').val(),
										team_ext1: $('#team_ext1').val(),
										team_dom2: $('#team_dom2').val(),
										team_ext2: $('#team_ext2').val(),
										team_dom3: $('#team_dom3').val(),
										team_ext3: $('#team_ext3').val(),
										team_joue: $('#team_joue input:checked').val(),
										team_arbitre: $('#team_arbitre').val(),
										team_classement: $('#team_classement').val()
									},
									success: function(data2) {
										$('#modif_match').html('<p>'+ data2 +'</p>');
										add_match.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "mon_profil.php";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_match.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		
		return false;
	});
	
	*/
	
	// $(".calendrier_gen").find("tr.cells").hide();
	// $(".calendrier_gen").find("tr.cells:last").show();
	
	// $(".calendrier_gen tr.cal_month").click(function() {
		// $(".calendrier_gen").find("tr.cells").hide();
		// $(this).nextUntil("tr.cal_month").toggle();
	// });

	/* ------------------------------ */
	/* ---- Liste des fonctions ----- */
	/* ------------------------------ */

	// Affiche le gif de chargement
	var showLoader = function(){
		$('#fond').show();
		$('#main').append('<img src="images/loading.gif" alt="chargement ..." class="ico_chargement" />');
	};
	// Cache le gif de chargement
	var hideLoader = function(){
		$('#fond').hide();
		$('#main').find('.ico_chargement').remove();
	};
});