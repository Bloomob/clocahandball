$(function(){
	/*******************
	***** Dossiers *****
	*******************/
	
	$( ".tab_container .dossiers .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/dossier.php",
				success: function(data) {
					$( "#maDiv" ).html(data);
					var add_dossier = $( ".popin" );
					add_dossier.dialog({
						title: "Ajouter un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							add_dossier.remove();
						},
						buttons: { 
							"Ajouter": function() {
								$.ajax( {
									type: "POST",
									url: "inc/ajax/ajouter_dossier.php",
									data: { 
										dossiers_titre: $('#dossiers_titre').val(),
										dossiers_sous_titre: $('#dossiers_sous_titre').val(),
										dossiers_contenu: tinyMCE.activeEditor.getContent(),
										dossiers_theme: $('#dossiers_theme').val(),
										dossiers_image: $('#dossiers_image').val(),
										dossiers_publie: $('#dossiers_publie').is(':checked')
									},
									success: function(data2) {
										$('.popin').html('<p>'+ data2 +'</p>');
										add_dossier.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_dossier.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		return false;
	});
	
	$( ".tab_container .dossiers td.boutons" ).click(function( event ) {
		var id_dossier = $(this).find('a').attr("href");
		if($( event.target ).is( 'a.voir' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_dossier.php",
				data: { id: id_dossier },
				success: function(data) {
					$( "#maDiv" ).html(data);
					var voir_dossier = $( ".popin" );
					voir_dossier.dialog({
						title: "Détails d'un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							voir_dossier.remove();
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.modif' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/dossier.php",
				data: { id: id_dossier },
				success: function(data) {
					$( "#maDiv" ).html(data);
					var modif_dossier = $( ".popin" );
					modif_dossier.dialog({
						title: "Modifier un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							modif_dossier.remove();
						},
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_dossier.php",
									data: { 
										dossiers_titre: $('#dossiers_titre').val(),
										dossiers_sous_titre: $('#dossiers_sous_titre').val(),
										dossiers_contenu: tinyMCE.activeEditor.getContent(),
										dossiers_theme: $('#dossiers_theme').val(),
										dossiers_image: $('#dossiers_image').val(),
										dossiers_publie: $('#dossiers_publie').is(':checked'),
										dossiers_id: $('#dossiers_id').val()
									},
									success: function(data2) {
										$('.popin').html('<p>'+ data2 +'</p>');
										modif_dossier.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_dossier.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			$( "#maDiv" ).html("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement le dosssier ?</div>");
			var suppr_dossier = $(".popin");
			suppr_dossier.dialog({
				title: "Supprimer un dossier",
				draggable: false,
				resizable: false,
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_dossier.php",
							data: { id: id_dossier },
							success: function(data) {
								$('.popin').html('<p>'+ data +'</p>');
								suppr_dossier.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						suppr_dossier.remove();
					} 
				},
				close: function() {
					suppr_dossier.remove();
				},
				modal: true
			});
		}
		return false;
	});

	/*********************
	******** Club ********
	*********************/
	
	$( ".tab_container > .clubs .ajouter" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/club.php",
				success: function(data) {
					$( "body" ).append(data);
					popin = $( ".popin" );
					popin.dialog({
						title: "Ajouter un club",
						width: 800,
						height: 600,
						close: function() {
							popin.dialog('destroy').remove();
						},
						buttons: { 
							"Ajouter": function() {
								$.ajax( {
									type: "POST",
									url: "inc/ajax/ajouter_club.php",
									data: { 
										nom: $('#nom').val(),
										raccourci: $('#raccourci').val(),
										numero: $('#numero').val(),
										ville: $('#ville').val(),
										code_postal: $('#code_postal').val(),
										actif: $('#actif').is(':checked')
									},
									success: function(data2) {
										popin.html('<p>'+ data2 +'</p>');
										popin.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								popin.dialog('destroy').remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		return false;
	});

	$( ".tab_container > .clubs table" ).click(function( event ) {
		if($( event.target ).is( '.voir' )) {
			var id_club = $( event.target ).attr( "href" );
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_club.php",
				data: { id: id_club },
				success: function(data) {
					$( "body" ).append(data);
					var popin = $( ".popin" );
					popin.dialog({
						title: "Détails d'un club",
						width: 550,
						height: 225,
						close: function() {
							popin.dialog('destroy').remove();
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( '.modif' )) {
			var id_club = $( event.target ).attr( "href" );
			$.ajax({
				type: "POST",
				url: "inc/ajax/club.php",
				data: { id: id_club },
				success: function(data) {
					$( "body" ).append(data);
					var popin = $( ".popin" );
					popin.dialog({
						title: "Modifier un club",
						width: 800,
						height: 600,
						close: function() {
							popin.dialog('destroy').remove();
						},
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_club.php",
									data: { 
										id: id_club,
										nom: $('#nom').val(),
										raccourci: $('#raccourci').val(),
										numero: $('#numero').val(),
										ville: $('#ville').val(),
										code_postal: $('#code_postal').val(),
										actif: $('#actif').is(':checked')
									},
									success: function(data2) {
										popin.html('<p>'+ data2 +'</p>');
										popin.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								popin.dialog('destroy').remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			var id_club = $( event.target ).attr( "href" );
			$( "body" ).append("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement ce club ?</div>");
			var popin = $(".popin");
			popin.dialog({
				title: "Supprimer une actualité",
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_club.php",
							data: { id: id_club },
							success: function(data) {
								$('.popin').html('<p>'+ data +'</p>');
								popin.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						popin.dialog('destroy').remove();
					} 
				},
				close: function() {
					popin.dialog('destroy').remove();
				},
				modal: true
			});
		}
		return false;
	});

	/******************
	***** Galerie *****
	******************/
	
	$( ".tab_container > .galerie .albums" ).on('click', '.liste a.nav', function( event ) {
		if($( event.target ).is( '.dir_plus' )) {
			if($(this).find('.dir_ajout').size() == 0) {
				$(this).removeClass('dir_plus')
					   .addClass('dir_upload')
					   .html("<input type='text' class='dir_ajout' value='Ajouter un dossier' />")
					   .find('.dir_ajout').focus().on('blur', function() {
							if($(this).val() == '')
								$(this).parent()
									.removeClass('dir_upload')
					   				.addClass('dir_plus')
					   				.text("Ajouter un dossier");
						});
			}
		}
		else if($( event.target ).is( '.dir_upload' )) {
			$( "body" ).append('<div class="popin"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous ajouter ce dossier ?</p></div>');
			$( ".popin" ).dialog({
			    resizable: false,
			    height:140,
			    modal: true,
			    buttons: {
			        "Ajouter": function() {
			   			$.ajax( {
							type: "POST",
							url: "inc/ajax/ajouter_album.php",
							data: { 
								nom: $('input.dir_ajout').val(),
								dossier: $('input.dir_courant').val()
							},
							success: function(data) {
								$( ".albums" ).html( data );
								$( ".popin" ).dialog( "close" );
								$( '.picture_file' ).remove();
							}
						});
			        },
			        "Annuler": function() {
			          $( ".popin" ).dialog( "close" );
			          $( ".tab_container > .galerie .albums .liste .dir_ajout" ).removeClass('dir_upload')
				   				.addClass('dir_plus')
				   				.text("Ajouter un dossier");
			        }
			    }
			});
		}
		else if($( event.target ).is( '.picture_plus' )) {
			if($(this).find('.picture_ajout').size() == 0) {
				$(this).removeClass('picture_plus')
					   .addClass('picture_upload')
					   .html("<input type='button' class='picture_ajout' value='Choix de la photo' />")
					 //   .find('.picture_ajout').on('blur', function() {
						// 	$(this).parent()
						// 		.removeClass('picture_upload')
				  //  				.addClass('picture_plus')
				  //  				.text("Ajouter une photo");
				  //  			$( '.picture_file' ).remove();
						// })
					;
				$('body').append("<input type='file' class='picture_file' name='imageFile' />");
			}
			else
				$( '.picture_file' ).remove();
		}
		else if($( event.target ).is( '.picture_upload' )) {
			var files = $('.picture_file');
			var data = [];
			$.each(files, function(key, value) {
				data.append(key, value);
			});
			$( "body" ).append('<div class="popin"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous ajouter cette photo ?</p></div>');
			$( ".popin" ).dialog({
			    resizable: false,
			    height:140,
			    modal: true,
			    buttons: {
			        "Ajouter": function() {
			   			$.ajax( {
							type: "POST",
							url: "inc/ajax/ajouter_photo.php?files",
							processData: false, // Don't process the files
        					contentType: false,
							data: { 
								nom: $('input.picture_ajout').val(),
								dossier: $('input.dir_courant').val()
							},
							success: function(data) {
								$( ".albums" ).html( data );
								$( ".popin" ).dialog( "close" );
								$( '.picture_file' ).remove();
							}
						});
			        },
			        "Annuler": function() {
			          $( ".popin" ).dialog( "close" );
			          $( ".tab_container > .galerie .albums .liste .picture_upload" ).removeClass('picture_upload')
				   				.addClass('picture_plus')
				   				.text("Ajouter un dossier");
				   	$( '.picture_file' ).remove();
			        }
			    }
			});
		}
		else if($( event.target ).is( '.picture_upload .picture_ajout' )) {
			$('body').find('.picture_file').click();
		}
		else {
			var chemin = $(this).attr('href');
			if(chemin == '#')
				chemin = '';
			$.ajax( {
				type: "POST",
				url: "inc/ajax/changer_album.php",
				data: { 
					dossier: chemin
				},
				success: function(data) {
					$( ".albums" ).html( data );
					$( '.picture_file' ).remove();
				}
			});
		}

		return false;
	});

	/********************
	****** Général ******
	********************/
	
	// Fonction d'ajout

	$( ".tab_container .menus-manager .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/dossier.php",
				success: function(data) {
					$( "#maDiv" ).html(data);
					var add_dossier = $( ".popin" );
					add_dossier.dialog({
						title: "Ajouter un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							add_dossier.remove();
						},
						buttons: { 
							"Ajouter": function() {
								$.ajax( {
									type: "POST",
									url: "inc/ajax/ajouter_dossier.php",
									data: { 
										dossiers_titre: $('#dossiers_titre').val(),
										dossiers_sous_titre: $('#dossiers_sous_titre').val(),
										dossiers_contenu: tinyMCE.activeEditor.getContent(),
										dossiers_theme: $('#dossiers_theme').val(),
										dossiers_image: $('#dossiers_image').val(),
										dossiers_publie: $('#dossiers_publie').is(':checked')
									},
									success: function(data2) {
										$('.popin').html('<p>'+ data2 +'</p>');
										add_dossier.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_dossier.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		return false;
	});
	
	$( ".tab_container .menus-manager td.boutons" ).click(function( event ) {
		var id_dossier = $(this).find('a').attr("href");
		if($( event.target ).is( 'a.voir' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_dossier.php",
				data: { id: id_dossier },
				success: function(data) {
					$( "#maDiv" ).html(data);
					var voir_dossier = $( ".popin" );
					voir_dossier.dialog({
						title: "Détails d'un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							voir_dossier.remove();
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.modif' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/dossier.php",
				data: { id: id_dossier },
				success: function(data) {
					$( "#maDiv" ).html(data);
					var modif_dossier = $( ".popin" );
					modif_dossier.dialog({
						title: "Modifier un dossier",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						close: function() {
							modif_dossier.remove();
						},
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_dossier.php",
									data: { 
										dossiers_titre: $('#dossiers_titre').val(),
										dossiers_sous_titre: $('#dossiers_sous_titre').val(),
										dossiers_contenu: tinyMCE.activeEditor.getContent(),
										dossiers_theme: $('#dossiers_theme').val(),
										dossiers_image: $('#dossiers_image').val(),
										dossiers_publie: $('#dossiers_publie').is(':checked'),
										dossiers_id: $('#dossiers_id').val()
									},
									success: function(data2) {
										$('.popin').html('<p>'+ data2 +'</p>');
										modif_dossier.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_dossier.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			$( "#maDiv" ).html("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement le dosssier ?</div>");
			var suppr_dossier = $(".popin");
			suppr_dossier.dialog({
				title: "Supprimer un dossier",
				draggable: false,
				resizable: false,
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_dossier.php",
							data: { id: id_dossier },
							success: function(data) {
								$('.popin').html('<p>'+ data +'</p>');
								suppr_dossier.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						suppr_dossier.remove();
					} 
				},
				close: function() {
					suppr_dossier.remove();
				},
				modal: true
			});
		}
		return false;
	});

	/******************
	***** Joueurs *****
	******************/
	
	$( ".tab_container .joueurs .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/joueur.php",
				success: function(data) {
					var add_utilisateur = $( "#maDiv" ).html(data);
					add_utilisateur.dialog({
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
										raccourci: $('#joueur_categorie').val(),
										numero: $('#joueur_numero').val(),
										id: $('#id_prenom_nom').val(),
										nom: $('#joueur_nom').val(),
										prenom: $('#joueur_prenom').val(),
										poste: $('#joueur_poste').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										add_utilisateur.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_utilisateur.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		return false;
	});
	
	$( ".tab_container .joueurs td.boutons" ).click(function( event ) {
		var id_joueur = $(this).find('a').attr("href");
		if($( event.target ).is( 'a.voir' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_joueur.php",
				data: { id: id_joueur },
				success: function(data) {
					var voir_utilisateur = $( "#maDiv" ).html(data);
					voir_utilisateur.dialog({
						title: "Détails d'un joueur",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.modif' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/joueur.php",
				data: { id: id_joueur },
				success: function(data) {
					var modif_utilisateur = $( "#maDiv" ).html(data);
					modif_utilisateur.dialog({
						title: "Modifier un utilisateur",
						draggable: false,
						resizable: false,
						width: 800,
						height: 600,
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_joueur.php",
									data: { 
										utilisateur_nom: $('#utilisateur_nom').val(),
										utilisateur_prenom: $('#utilisateur_prenom').val(),
										utilisateur_email: $('#utilisateur_email').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										modif_utilisateur.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_utilisateur.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			var suppr_utilisateur = $( "#maDiv" ).html("<div>Souhaitez-vous supprimer d&eacute;finitivement l'utilisateur ?</div>");
			suppr_utilisateur.dialog({
				title: "Supprimer un utilisateur",
				draggable: false,
				resizable: false,
				width: 650,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_utilisateur.php",
							data: { 
								id: id_joueur
							},
							success: function(data) {
								$('#maDiv').html('<p>'+ data +'</p>');
								suppr_utilisateur.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						suppr_utilisateur.remove();
					} 
				},
				modal: true
			});
		}
		return false;
	});
	
	/***********************
	***** Utilisateurs *****
	***********************/
	
	$( ".tab_container .utilisateurs .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/utilisateur.php",
				success: function(data) {
					var add_utilisateur = $( "#maDiv" ).html(data);
					add_utilisateur.dialog({
						title: "Ajouter un utilisateur",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/ajouter_utilisateur.php",
									data: { 
										utilisateur_nom: $('#utilisateur_nom').val(),
										utilisateur_prenom: $('#utilisateur_prenom').val(),
										utilisateur_email: $('#utilisateur_email').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										add_utilisateur.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_utilisateur.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
	});
	
	$( ".tab_container .utilisateurs td.boutons" ).click(function( event ) {
		if($( event.target ).is( 'a.voir' )) {
			var id_utilisateur = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_utilisateur.php",
				data: { id: id_utilisateur },
				success: function(data) {
					var voir_utilisateur = $( "#maDiv" ).html(data);
					voir_utilisateur.dialog({
						title: "Détails d'un utilisateur",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.modif' )) {
			var id_utilisateur = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax/utilisateur.php",
				data: { id: id_utilisateur },
				success: function(data) {
					var modif_utilisateur = $( "#maDiv" ).html(data);
					modif_utilisateur.dialog({
						title: "Modifier un utilisateur",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_utilisateur.php",
									data: { 
										utilisateur_nom: $('#utilisateur_nom').val(),
										utilisateur_prenom: $('#utilisateur_prenom').val(),
										utilisateur_email: $('#utilisateur_email').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										modif_utilisateur.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_utilisateur.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			var id_utilisateur = $(this).find('a').attr("href");
			var suppr_utilisateur = $( "#maDiv" ).html("<div>Souhaitez-vous supprimer d&eacute;finitivement l'utilisateur ?</div>");
			suppr_utilisateur.dialog({
				title: "Supprimer un utilisateur",
				draggable: false,
				resizable: false,
				width: 650,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_utilisateur.php",
							data: { 
								id: id_utilisateur
							},
							success: function(data) {
								$('#maDiv').html('<p>'+ data +'</p>');
								suppr_utilisateur.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						suppr_utilisateur.remove();
					} 
				},
				modal: true
			});
		}
		return false;
	});
	
	/******************
	***** Equipes *****
	******************/
	
	$( ".tab_container .equipes .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/equipe.php",
				success: function(data) {
					var add_team = $( "#maDiv" ).html(data);
					add_team.dialog({
						title: "Ajouter une équipe",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/ajouter_equipe.php",
									data: { 
										team_categorie: $('#team_categorie').val(),
										team_niveau: $('#team_niveau').val(),
										team_championnat: $('#team_championnat').val(),
										team_entraineur1: $('#team_id_entraineur1').val(),
										team_entraineur2: $('#team_id_entraineur2').val(),
										team_active: $('#team_active input:checked').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										add_team.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "admin.php?page=equipes";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_team.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
	});
	
	$( ".tab_container .equipes td.boutons" ).click(function( event ) {
		if($( event.target ).is( 'a.voir' )) {
			var id_equipe = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax/voir_equipe.php",
				data: { id: id_equipe },
				success: function(data) {
					var voir_equipe = $( "#maDiv" ).html(data);
					voir_equipe.dialog({
						title: "Détails d'une équipe",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.modif' )) {
			var id_equipe = $(this).find('a').attr("href");
			$.ajax({
				type: "POST",
				url: "inc/ajax/equipe.php",
				data: { id: id_equipe },
				success: function(data) {
					var modif_equipe = $( "#maDiv" ).html(data);
					modif_equipe.dialog({
						title: "Modifier une équipe",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Modifier": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/modifier_equipe.php",
									data: { 
										team_id: id_equipe,
										team_categorie: $('#team_categorie').val(),
										team_niveau: $('#team_niveau').val(),
										team_championnat: $('#team_championnat').val(),
										team_entraineur1: $('#team_id_entraineur1').val(),
										team_entraineur2: $('#team_id_entraineur2').val(),
										team_active: $('#team_active input:checked').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										modif_equipe.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = window.location.href;
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								modif_equipe.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
		else if($( event.target ).is( 'a.suppr' )) {
			var id_equipe = $(this).find('a').attr("href");
			var suppr_equipe = $( "#maDiv" ).html("<div>Souhaitez-vous supprimer d&eacute;finitivement l'utilisateur ?</div>");
			suppr_equipe.dialog({
				title: "Supprimer un utilisateur",
				draggable: false,
				resizable: false,
				width: 650,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_equipe.php",
							data: { 
								id: id_equipe
							},
							success: function(data) {
								$('#maDiv').html('<p>'+ data +'</p>');
								suppr_equipe.dialog("option", "buttons", []);
								setTimeout(function(){
									location.href = window.location.href;
								}, 1000);
							}
						});
					},
					"Annuler": function() {
						suppr_equipe.remove();
					} 
				},
				modal: true
			});
		}
		return false;
	});
	
	/********************
	***** Fonctions *****
	********************/
	
	$( ".tab_container .fonctions .right div" ).click(function( event ) {
		if($( event.target ).is( '.add' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax/fonction.php",
				success: function(data) {
					var add_function = $( "#maDiv" ).html(data);
					add_function.dialog({
						title: "Ajouter une fonction",
						draggable: false,
						resizable: false,
						width: 650,
						height: 450,
						buttons: { 
							"Ajouter": function() {
								$.ajax({
									type: "POST",
									url: "inc/ajax/ajouter_fonction.php",
									data: { 
										type: $('#fonction_type').val(),
										categorie: $('#fonction_categorie').val(),
										id_utilisateur: $('#fonction_id_nom_prenom').val(),
										active: $('#fonction_active input:checked').val()
									},
									success: function(data2) {
										$('#maDiv').html('<p>'+ data2 +'</p>');
										add_function.dialog("option", "buttons", []);
										setTimeout(function(){
											location.href = "admin.php?page=fonctions";
										}, 1000);
									}
								});
							},
							"Annuler": function() {
								add_function.remove();
							} 
						},
						modal: true
					});
				}
			});
		}
	});
	
	$("#content .tab_container .images .uneImage").mouseover( function() {
		$(this).find(".croix").show();
	});
	
	$("#content .tab_container .images .uneImage").mouseout( function() {
		$(this).find(".croix").hide();
	});
	
	$("#content .tab_container .images .uneImage .croix").click( function() {
		alert('Image supprimée !');
	});
	
	/*
	$( ".tab_content2 .col_gau_400" ).click(function( event ) {
		if($( event.target ).is( '#menu_button' )) {
			$.ajax({
				type: "POST",
				url: "inc/ajax_req_ajout_menu.php",
				data: { 
					menu_nom: $('#menu_nom').val(),
					menu_url: $('#menu_url').val(),
					menu_image: $('#menu_image').val(),
					menu_parent: $('#menu_parent').val()
				},
				beforeSend: function () { $(".cl_ajout_menu .img_chargement").show(); },
				complete: function () { $(".cl_ajout_menu .img_chargement").fadeOut(); },
				success: function(data) {
					$( "#tab_admin" ).html(data);
					$( ".champ input[type=text]" ).val('');
				}
			});
		}
	}); */

	/********************
	******* Menus *******
	********************/

	var admin_menu = $('.admin_panel .menu');

	if(admin_menu.length > 0) {

	    var tabs = $( "#onglets" ).tabs();
	    tabs.find( ".ui-tabs-nav" ).sortable({
			axis: "x",
			items: '> li:not(.locked)',
			stop: function() {
				tabs.tabs( "refresh" );
			}
	    });
		var count_tabs = tabs.find('.liste-tabs').length;
		
		// Lock last tab
		$('#onglets ul > li:last').addClass('locked').mousedown(function(event){
			event.stopPropagation();
		});
		
		$( ".sortable" ).sortable({
			placeholder: "ui-state-highlight"
		});
		$( ".sortable" ).disableSelection();

		/* Ajout d'un menu */
		tabs.on('click', '.menu-action .btn-ajout', function(event) {
			event.preventDefault();
			if($('#nv_menu_nom').val() != '' && $('#nv_menu_url').val() != '') {
				var nv_nom = $('#nv_menu_nom').val();
				var nv_url = $('#nv_menu_url').val();
				var contenu = '<div class="paddingTB10 table"><div class="cell cell-1-2"><label for="menu-nom">Nom du menu</label><br/><input id="menu-nom" type="text" value="'+ nv_nom +'" /></div><div class="cell cell-1-2"><label for="menu-url">URL du menu</label><br/><input id="menu-url" type="text" value="'+ nv_url +'" /></div></div>';
				contenu += '<div class="boutons-actions menu-action"><div class="left"><a href="#" class="btn btn-suppr">Supprimer</a></div><div class="right"><a href="#" class="btn btn-visiblity btn-invisible">Masquer le menu</a></div><div class="clear_b"></div></div>';
				contenu += '<div class="liste-menus"><p>Pour cr&eacute;er un sous-menu, cliquer sur le bouton.</p></div><div class="boutons-actions sous-menus-action"><div class="right"><a href="#" class="btn btn-ajout">Ajouter un sous-menu</a></div><div class="clear_b"></div></div>';
				tabs.find(' ul li').eq( -1 ).before('<li><a href="#tabs-'+ count_tabs +'">'+ nv_nom +'</a></li>');
				tabs.find('.liste-tabs').eq( -1 ).before('<div id="tabs-'+ count_tabs +'" class="liste-tabs">'+ contenu +'</div>');
				$('#nv_menu_nom').val('');
				$('#nv_menu_url').val('');
				tabs.tabs("refresh");
				tabs.tabs("option", "active", tabs.find('.liste-tabs').length-2);
				count_tabs++;
			}
			return false;
		})
		/* Suppression d'un menu */
		.on('click', '.menu-action .btn-suppr', function(event) {
			event.preventDefault();
			var tab = tabs.tabs("option", "active");
			tabs.find('ul li').eq(tab).remove();
			tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls')-1).remove();
			tabs.tabs("refresh");
			tabs.tabs("option", "active", 0);
			return false;
		})
		/* MAsquer/Afficher un menu */
		.on('click', '.menu-action .btn-visiblity', function(event) {
			event.preventDefault();
			var tab = tabs.tabs("option", "active");
			var texte = $(this).text();
			$(this).toggleClass('btn-invisible btn-visible');
			tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').toggleClass('invisible');
			if(texte == 'Afficher le menu') {
				$(this).text('Masquer le menu');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .sous-menus-action').show();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus > .masque').remove();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').sortable( { disabled: false } );
			}
			else {
				$(this).text('Afficher le menu');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .sous-menus-action').hide();
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').append('<div class="masque"></div>');
				tabs.find('#'+ tabs.find('ul li').eq(tab).attr('aria-controls') +' .liste-menus').sortable( { disabled: true } );
			}
			return false;
		})
		/* Ajout d'un sous menu */
		.on('click', '.sous-menus-action .btn-ajout', function(event) {
			event.preventDefault();
			closeAllSousMenus();
			var tab = tabs.tabs("option", "active");
			if(tabs.find('#tabs-'+ tab +' .liste-menus > p'))
				tabs.find('#tabs-'+ tab +' .liste-menus > p').remove();
			var count_div = tabs.find('#tabs-'+ tab +' .liste-menus > div').length;
			var contenu = '<div class="paddingTB10 table"><div class="cell cell-1-2"><label for="sous-menu-'+ count_div +'-nom">Nom du menu</label><br/><input type="text" id="sous-menu-'+ count_div +'-nom" class="sous-menu-nom" value=""/></div><div class="cell cell-1-2"><label for="sous-menu-'+ count_div +'-url">URL de la page</label><br/><input type="text" id="sous-menu-'+ count_div +'-url" class="sous-menu-url" value=""/></div></div>';
			var boutons = '<div class="boutons-actions sous-menus-action"><div class="left"><a href="#" class="btn btn-suppr">Supprimer</a></div><div class="clear_b"></div></div>';
			tabs.find('#tabs-'+ tab +' .liste-menus').append('<div class="sous-menu-'+ count_div +'"><h4>Nouveau menu<a href="'+ count_div +'" class="arrow-up right">D&eacute;tails</a></h4><div>'+ contenu + boutons +'</div></div>');
			return false;
		})
		/* Suppression d'un sous menu */
		.on('click', '.sous-menus-action .btn-suppr', function(event) {
			event.preventDefault();
			$(this).closest('.liste-menus > div').remove();
			return false;
		})
		/* Menu déroulant des sous menus */
		.on('click', '.liste-menus .arrow-up', function(event) {
			event.preventDefault();
			var id_menu = $(this).attr('href');
			$(this).toggleClass('arrow-up arrow-down');
			$('.sous-menu-'+id_menu).find('> div').hide();
			return false;
		})
		.on('click', '.liste-menus .arrow-down', function(event) {
			event.preventDefault();
			closeAllSousMenus();
			var id_menu = $(this).attr('href');
			$(this).toggleClass('arrow-down arrow-up');
			$('.sous-menu-'+id_menu).find('> div').show();
			return false;
		});

		function closeAllSousMenus() {
			$('.liste-menus > div > div').hide();
			$('.liste-menus > div > h4 > a').each(function() {
				if($(this).hasClass('arrow-up'))
					$(this).toggleClass('arrow-down arrow-up');
			});
		}
		/* Sauvegarde du menu */
		admin_menu.on('click', '.menus-action .btn-save', function(event) {
			var MonMenu = new Array();
			var i = 1;
			tabs.find('.select-tabs ul li').each(function (index) {
				
				var tab = $('#'+ $(this).attr('aria-controls'));
				if(tab.find('.btn-visiblity').hasClass('btn-invisible'))
					var actif = 1;
				else
					var actif = 0;
				// NOM - URL - PARENT - ORDRE - ACTIF
				MonMenu.push({'nom': tab.find('#menu-nom').val(), 'url': tab.find('#menu-url').val(), 'image': '', 'parent': 0, 'ordre': index*5, 'actif': actif});
				var id_parent = i;
				tab.find('.liste-menus > div').each(function (index_2) {
					MonMenu.push({'nom': $(this).find('.sous-menu-nom').val(), 'url': $(this).find('.sous-menu-url').val(), 'image': '', 'parent': id_parent, 'ordre': index_2*5, 'actif': 1});
					i++;
				});
				i++;
			});
			MonMenu.pop();
			// console.log(MonMenu);
			$('#fond').show();
			$('#main').append('<img src="/images/loading.gif" alt="chargement ..." class="ico_chargement" />');
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_menu.php",
				data: { 
					menu: MonMenu
				},
				success: function(data) {
					// console.log(data);
					location.href = window.location.href;
				}
			});
			return false;
		});
	}

	/************************
	******* Fonctions *******
	*************************/

	var admin_fonction = $('.admin_panel .fonctions');

	if(admin_fonction.length > 0) {
		/* Intégration du formulaire d'ajout de rôle */
		admin_fonction.on('click', '.action-ajout .btn-ajout', function(event) {
			event.preventDefault();
			var contenu = 	'<div class="form-ajout">';
			contenu += 			'<div class="table">';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 					'<label for="tri_par_type_ajout">Choisissez le type</label><br/>';
			contenu += 					'<select id="tri_par_type_ajout">';
			contenu += 						$('#tri_par_type').html();
			contenu += 					'</select><br/><br/>';
			contenu += 					'<label for="tri_par_role_ajout">Choisissez le rôle</label><br/>';
			contenu += 					'<select id="tri_par_role_ajout">';
			contenu += 						$('#tri_par_role').html();
			contenu += 					'</select>';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 				'</div>';
			contenu += 			'</div>';
			contenu += 		'</div>';
			$("#zone-ajout").html(contenu);

			return false;
		});
	}

	/********************
	******* Rôles *******
	********************/

	var admin_role = $('.admin_panel .roles');

	if(admin_role.length > 0) {

		/* Intégration du formulaire d'ajout de rôle */
		admin_role.on('click', '.action-ajout .btn-ajout', function(event) {
			event.preventDefault();
			var contenu = 	'<div class="form-ajout">';
			contenu += 			'<div class="table">';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 					'<label for="nom">Nom</label><br/>';
			contenu += 					'<input id="nom" type="text"/><br/><br/>';
			contenu += 					'<label for="parent">Parent</label><br/>';
			contenu += 					'<input id="parent" type="text"/><br/><br/>';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 					'<label for="raccourci">Raccourci</label><br/>';
			contenu += 					'<input id="raccourci" type="text"/><br/><br/>';
			contenu += 					'<label for="ordre">Ordre</label><br/>';
			contenu += 					'<input id="ordre" type="text"/><br/><br/>';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3 boutons-actions action-ajout">';
			contenu += 					'<a href="#" class="btn btn-save">Enregistrer ce r&ocirc;le</a>';
			contenu += 				'</div>';
			contenu += 			'</div>';
			contenu += 		'</div>';
			$("#zone-ajout").html(contenu);

			return false;
		}).on('click', '.action-ajout .btn-save', function(event) {
			event.preventDefault();
			var MonRole = new Array();
			MonRole.push({'nom': $("#zone-ajout").find('#nom').val(), 'parent': $("#zone-ajout").find('#parent').val(), 'raccourci': $("#zone-ajout").find('#raccourci').val(), 'ordre': $("#zone-ajout").find('#ordre').val(), 'actif': 1});
			console.log(MonRole);0
			$('#fond').show();
			$('#main').append('<img src="/images/loading.gif" alt="chargement ..." class="ico_chargement" />');
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_role.php",
				data: { 
					role: MonRole
				},
				success: function(data) {
					// console.log(data);
					var contenu = 	"<div class='boutons-actions action-ajout'>";
					contenu += 			"<div class='left'>";
					contenu += 				"<a href='#' class='btn btn-ajout'>Ajouter un r&ocirc;le</a>";
					contenu += 			"</div>";
					contenu += 			"<div class='clear_b'></div>";
					contenu += 		"</div>";
					$("#zone-ajout").html(contenu);
					admin_role.find('#tab_admin').html(data);
					$('#fond').hide();
					$('#main').find('.ico_chargement').remove();
					// location.href = window.location.href;
				}
			});

			return false;
		});
	}

	/************************
	******* Categorie *******
	************************/

	var admin_categorie = $('.admin_panel .categories');

	if(admin_categorie.length > 0) {

		/* Intégration du formulaire d'ajout de rôle */
		admin_categorie.on('click', '.action-ajout .btn-ajout', function(event) {
			event.preventDefault();
			var contenu = 	'<div class="form-ajout">';
			contenu += 			'<div class="table">';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 					'<label for="categorie">Categorie</label><br/>';
			contenu += 					'<input id="categorie" type="text"/><br/><br/>';
			contenu += 					'<label for="genre">Genre</label><br/>';
			contenu += 					'<select id="genre">';
			contenu += 						'<option value="-">Choisissez le genre</option>';
			contenu += 						'<option value="mixte">Mixte</option>';
			contenu += 						'<option value="feminin">Féminin</option>';
			contenu += 						'<option value="masculin">Masculin</option>';
			contenu += 					'</select>';
			contenu += 					'<label for="numero">Numéro</label><br/>';
			contenu += 					'<select id="numero">';
			contenu += 						'<option value="-">Choisissez le numero</option>';
			contenu += 						'<option value="1">1</option>';
			contenu += 						'<option value="2">2</option>';
			contenu += 						'<option value="3">3</option>';
			contenu += 					'</select>';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3">';
			contenu += 					'<label for="raccourci">Raccourci</label><br/>';
			contenu += 					'<input id="raccourci" type="text"/><br/><br/>';
			contenu += 					'<label for="ordre">Ordre</label><br/>';
			contenu += 					'<input id="ordre" type="text"/><br/><br/>';
			contenu += 				'</div>';
			contenu += 				'<div class="cell cell-1-3 boutons-actions action-ajout">';
			contenu += 					'<a href="#" class="btn btn-save">Enregistrer cette catégorie</a>';
			contenu += 				'</div>';
			contenu += 			'</div>';
			contenu += 		'</div>';
			$("#zone-ajout").html(contenu);

			return false;
		}).on('click', '.action-ajout .btn-save', function(event) {
			event.preventDefault();
			var MaCategorie = new Array();
			MaCategorie.push({'categorie': $("#zone-ajout").find('#categorie').val(), 'genre': $("#zone-ajout").find('#genre').val(), 'numero': $("#zone-ajout").find('#numero').val(), 'raccourci': $("#zone-ajout").find('#raccourci').val(), 'ordre': $("#zone-ajout").find('#ordre').val(), 'actif': 1});
			// console.log(MonRole);
			$('#fond').show();
			$('#main').append('<img src="/images/loading.gif" alt="chargement ..." class="ico_chargement" />');
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_categorie.php",
				data: { 
					categorie: MaCategorie
				},
				success: function(data) {
					// console.log(data);
					var contenu = 	"<div class='boutons-actions action-ajout'>";
					contenu += 			"<div class='left'>";
					contenu += 				"<a href='#' class='btn btn-ajout'>Ajouter une cat&eacute;gorie</a>";
					contenu += 			"</div>";
					contenu += 			"<div class='clear_b'></div>";
					contenu += 		"</div>";
					$("#zone-ajout").html(contenu);
					admin_categorie.find('#tab_admin').html(data);
					$('#fond').hide();
					$('#main').find('.ico_chargement').remove();
					// location.href = window.location.href;
				}
			});

			return false;
		});
	}
});