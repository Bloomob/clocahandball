$(function(){
	/*************************
	******* Actualités *******
	*************************/

	var actualites = $('.admin_panel .actualites');

	if(actualites.length > 0) {
		// Modification d'une actualité
		actualites.on('click', '#tab_admin .btn-slim.btn-modif', function(e) {
			showLoader();
			
			$.ajax({
				type: "POST",
				url: "inc/ajax/modif_fast_actualite.php",
				data: { 
					id: $(e.currentTarget).attr('href')
				},
				success: function(data) {
					var tr = $(e.currentTarget).closest('tr').after(
						$('<tr/>').append($('<td/>').css('background', '#DDE8EF').attr('colspan', $(e.currentTarget).closest('tr').find('td').length).append(data))
					).hide().next();

					tr.find('.modif-fast').on('click', '.btn-annul', function(e){
						supprTinyMCE('contenu');
				    	$(this).closest('tr').remove();
				    	$(e.currentTarget).closest('tr').show();
				    }).on('keyup', '#add_tag', function(e) {
						if(e.keyCode == 13 || e.keyCode == 188)
				    		addTag();
					}).on('blur', '#add_tag', function() {
						addTag();
					}).on('click', '.liste_tags > .tag > a', function(e) {
						removeTag(e);
						return false;
					});

					hideLoader();
					addTinyMCE();
				    addDatepicker();
				    var date = $( ".datepicker" ).val();
				    var annee = parseInt(date.substr(0,4));
				    var mois = parseInt(date.substr(4,2));
				    var jour = parseInt(date.substr(6,2));
				    $( ".datepicker" ).datepicker("setDate", new Date(annee, mois-1, jour));
				}
			});

			return false;
		}).on('click', '#tab_admin .btn-slim.btn-suppr', function(e) {
			e.preventDefault();
			var btn = $(this);
			
			$( "body" ).append("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement l'actualit&eacute; ?</div>");
			var suppr_actualite = $(".popin");
			suppr_actualite.dialog({
				title: "Supprimer une actualit&eacute;",
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_actualite.php",
							data: { id: btn.attr('href') },
							success: function(data) {
								var nbr_td = btn.closest('tr').find('td').length; 
								btn.closest('tr').html($('<td/>').attr('id','a_supprimer').attr('colspan', nbr_td).text(data));
								suppr_actualite.remove();
								setTimeout(function(){
									$('#a_supprimer').remove();
								}, 3000);
							}
						});
					},
					"Annuler": function() {
						suppr_actualite.remove();
					} 
				},
				close: function() {
					suppr_actualite.remove();
				},
				modal: true
			});

			return false;
		}).on('click', '.action-ajout .btn-ajout', function(e) {
			e.preventDefault();
			// On masque la liste des actualités
			$("#tab_admin").hide();
			showLoader();

			$.ajax({
				type: "POST",
				url: "inc/ajax/new_actualite.php",
				success: function(data) {
					$("#zone-ajout").append(data);
					$("#zone-ajout").find('.action-ajout').hide();

					// On active les fonctions prédéfinis
					addTinyMCE();
				    addDatepicker(0);
				    changeSelect();

				    // Pour la gestion des photos
				    $( ".tab_container > .galerie .albums" ).on('click', '.liste a.nav', function( event ) {
				    	if($( event.target ).is( '.dir_plus' )) {
							if($(this).find('.dir_ajout').size() == 0) {
								$(this).removeClass('dir_plus')
									   .addClass('dir_upload')
									   .html("<input type='text' class='dir_ajout' placeholder='Ajouter un dossier' />")
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
							var formData = new FormData();
							formData.append('imageFile', $('.picture_file')[0].files[0]);
							formData.append('dossier', $('input.dir_courant').val());
							formData.append('nom', $('input.picture_ajout').val());

							$( "body" ).append('<div class="popin"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous ajouter cette photo ?</p></div>');
							$( ".popin" ).dialog({
							    resizable: false,
							    height:140,
							    modal: true,
							    buttons: {
							        "Ajouter": function() {
							   			$.ajax( {
											type: "POST",
											url: "inc/ajax/ajouter_photo.php",
											processData: false, // Don't process the files
				        					contentType: false,
											data: formData,
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

									$(".liste a:not(.nav)").on('click', function(){
										$( ".tab_container > .galerie .albums" ).find('.selection').remove();
										$(this).append($("<div/>").addClass('selection').css({
											'width': $(this).width()-6,
											'height': $(this).height()-6,
										}).append($('<img/>').attr('src', '../images/true.png')));
										$('#image').val($(this).attr('href'));
										return false;
									});
								}
							});
						}

						return false;
					});

					$('input.require').on('blur', verif_require);
					$('.listeSelect.require > .select').on('click', verif_require);


					hideLoader();
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-save:not(.disable)', function(e) {
			e.preventDefault();

			var theme = $('.theme').find('.actif').data('value');
			var slider = $('.slider').find('.actif').data('value');
			var importance =  $('.importance').find('.actif').data('value');

			if($('#id').val() > 0) {
				var id = $('#id').val();
				var theme = $('#theme').val();
				var slider = $('#slider').val();
				var importance = $('#importance').val();
			}

			var erreur = false,
				MonActu = {
					'id': id,
					'titre': $('#titre').val(),
					'sous_titre': $('#sous_titre').val(),
					'contenu': tinymce.activeEditor.getContent(),
					'theme': theme,
					'tags': $('#tags').val(),
					'image': $('#image').val(),
					'slider': slider,
					'importance': importance,
					'date_publication': $('#date').datepicker( "option", "dateFormat", "yymmdd" ).val(),
					'heure_publication': $('#heure').val()
				};

			showLoader();
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_actualite.php",
				dataType: "json",
				data: { 
					actualite: MonActu
				},
				success: function(data) {
					console.log(data);
					if(!data.erreur){
						window.location.href = 'admin.php?page=actualites';
					}
					else {
						hideLoader();
					}
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-annul', function(e) {
			supprTinyMCE('contenu');
			$("#zone-ajout").find('.action-ajout').show();
			$("#zone-ajout").find('.form').remove();
			actualites.find('#tab_admin').show();

			return false;
		}).on('keyup', '.form #add_tag', function(e) {
			e.preventDefault();
			if(e.keyCode == 13 || e.keyCode == 188)
	    		addTag();
		}).on('blur', '.form #add_tag', function(e) {
			e.preventDefault();
			addTag();
		}).on('click', '.form .liste_tags > .tag > a', function(e) {
			e.preventDefault();
			removeTag(e);
			return false;
		}).on('click', 'a', function(e) {
			e.preventDefault();
			
			return false;
		});
	}

	/*************************
	******* Calendrier *******
	*************************/

	var calendrier = $('.admin_panel .calendrier');

	if(calendrier.length > 0) {
		calendrier.on('click', '#zone-ajout .btn-search', function() {
			if($(this).data('default') == $(this).text()){
				calendrier.find('#filtres').show();
				calendrier.find('#tab_admin').addClass('filtre');
				$(this).text("Masquer les filtres");
			}
			else{
				calendrier.find('#filtres').hide();
				calendrier.find('#tab_admin').removeClass('filtre');
				$(this).text($(this).data('default'));
			}
			calendrier.find('#filtres').on('click', 'h4', function(e){
				e.preventDefault();
				var div = $(this).closest('.cell-1-1').find('> div');
				if(div.css('display') == 'none'){
					div.show();
					$(this).find('.icon').text('-');
				}
				else{
					div.hide();
					$(this).find('.icon').text('+');
				}

				return false;
			}).on('click', 'input[type=checkbox]', function(e){
				e.preventDefault();
				if(!$(this).hasClass('checked')){
					$(this).addClass('checked');
				}
				else{
					$(this).removeClass('checked');
				}
				if($(this).is('[id*=_all]')){
					if($(this).hasClass('checked')) {
						$(this).closest('.cell').find('input[type=checkbox]').addClass('checked');
					}
					else {
						$(this).closest('.cell').find('input[type=checkbox]').removeClass('checked');
					}
				}

				return false;
			}).on('click', '.btn.btn-valide', function(e){
				e.preventDefault();
				
				var liste_categories = [],
					liste_dates = [],
					liste_competitions = [],
					liste_joue;

				$('.liste_categories input.checked').each(function(){
					liste_categories.push($(this).attr('id').replace('cat_', ''));
				});
				$('.liste_dates input.checked').each(function(){
					liste_dates.push($(this).attr('id').replace('date_', ''));
				});
				$('.liste_competitions input.checked').each(function(){
					liste_competitions.push($(this).attr('id').replace('comp_', ''));
				});
				if($('.liste_joue input').hasClass('checked')) {
					liste_joue = true;
				} else {
					liste_joue = false;
				}

				var mesFiltres = {
					'categories': liste_categories,
					'dates': liste_dates,
					'competitions': liste_competitions,
					'joue': liste_joue,
				};

				$.ajax({
					type: "POST",
					url: "inc/ajax/filtres_calendrier.php",
					data: { 
						filtres: mesFiltres
					},
					success: function(data) {
						// console.log(data);
						calendrier.find('#tab_admin tr').not('.titres').remove();
						calendrier.find('#tab_admin tr').after(data);
						calendrier.find('#filtres').hide();
						calendrier.find('#tab_admin').removeClass('filtre');
						calendrier.find('.btn-search').text(calendrier.find('.btn-search').data('default'));
					}
				});

				return false;
			});

			return false;
		}).on('click', '#tab_admin .btn-modif', function() {
			showLoader();
			$("#tab_admin").hide();
			$("#zone-ajout").find('.action-ajout').hide();

			$.ajax({
				type: "POST",
				data: {
					matchId: $(this).attr('href')
				},
				url: "inc/ajax/new_match.php",
				success: function(data) {
					$("#zone-ajout").append(data);

					addTinyMCE();
				    addDatepicker(new Date(2015,8,1), new Date(2016,5,30));
				    var date = $( ".datepicker" ).val();
				    var annee = parseInt(date.substr(0,4));
				    var mois = parseInt(date.substr(4,2));
				    var jour = parseInt(date.substr(6,2));
				    $( ".datepicker" ).datepicker("setDate", new Date(annee, mois-1, jour));
				    changeSelect();
				    isNumeric();

				    $("#zone-ajout").find('.heure').show();
				    $("#zone-ajout").find('.journee_tour').show();

				    $("#zone-ajout").on('change', '#competition', function(){
				    	$('.wrap.journee_tour').remove();
				    	if($(this).val() == 2 || $(this).val() == 3) {
				    		$(this).closest('.wrap').append(
				    			$('<div/>').addClass('wrap marginTB10 journee_tour').append(
			    					$('<label/>').attr('for', 'tour').text('Tour'),
			    					$('<input/>').attr('id', 'tour').addClass('min_input').attr('type', 'text').attr('placeholder', 'Entrez le tour')
			    				)
			    			);
				    	}
				    	else if($(this).val() == 1 || $(this).val() == 4) {
				    		$(this).closest('.wrap').append(
				    			$('<div/>').addClass('wrap marginTB10 journee_tour').append(
			    					$('<label/>').attr('for', 'journee').text('Journ\351e'),
			    					$('<input/>').attr('id', 'journee').addClass('min_input numeric').attr('type', 'text').attr('placeholder', 'Entrez la journ\351e')
			    				)
			    			);
				    	}
				    });

					$("#zone-ajout").on("click", ".listeSelect.lieu input", function(){
						$( '.depLieu' ).show();
						$('.depLieu').find('.unAdversaire .uneEquipe.home').remove();
						if($(this).data('value')=='1')
							$('.depLieu').find('.unAdversaire').append($('<div/>').addClass('uneEquipe home').text('Ach\350res'));
						else
							$('.depLieu').find('.unAdversaire').prepend($('<div/>').addClass('uneEquipe home').text('Ach\350res'));

						return false;
					});

				    addSelecteurClub();	

					$("#zone-ajout").on('click', '.boutons-actions btn-ajout', function(){
						var clone = $('.tabAdversaires').find('.row.adversaire').last().clone();
						clone.find('.boutons-actions').append(
							$('<span/>').addClass('btn btn-suppr btn-slim').text('Suppr')
						);
						clone.find('.choixAdversaire').val('');
						clone.find('.unScore input').val('');
						$('.tabAdversaires').find('.row.adversaire').last().after(clone);
						
						addSelecteurClub();	
					    isNumeric();

						return false;
					}).on('click', '.boutons-actions .btn-suppr', function(){
						$(this).closest('.row.adversaire').remove();
						return false;
					});
					hideLoader();
				}
			});

			return false;
		}).on('click', '#tab_admin .btn-slim.btn-suppr', function() {
			var btn = $(this);
			
			$( "body" ).append("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement le match ?</div>");
			var suppr_match = $(".popin");
			suppr_match.dialog({
				title: "Supprimer un match",
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_match.php",
							data: { id: btn.attr('href') },
							success: function(data) {
								var nbr_td = btn.closest('tr').find('td').length; 
								btn.closest('tr').html($('<td/>').attr('id','a_supprimer').attr('colspan', nbr_td).text(data));
								suppr_match.remove();
								setTimeout(function(){
									$('#a_supprimer').remove();
								}, 3000);
							}
						});
					},
					"Annuler": function() {
						suppr_match.remove();
					} 
				},
				close: function() {
					suppr_match.remove();
				},
				modal: true
			});

			return false;
		}).on('click', '.action-ajout .btn-ajout', function() {
			showLoader();
			// On masque la liste
			$("#tab_admin").hide();
			$("#zone-ajout").find('.action-ajout').hide();

			if($(this).hasClass('ajout-match')) {

				$.ajax({
					type: "POST",
					url: "inc/ajax/new_match.php",
					success: function(data) {
						$("#zone-ajout").append(data);

						addDatepicker(new Date(2015,8,1), new Date(2016,5,30));
					    changeSelect();

					    $("#zone-ajout").on('change', '#competition', function(){
					    	$('.wrap.journee_tour').show();
					    	if($(this).val() == 2 || $(this).val() == 3) {
		    					$('.journee_tour label').attr('for', 'tour').text('Tour'),
		    					$('.journee_tour input').attr('id', 'tour').addClass('min_input').attr('placeholder', 'Entrez le tour')
					    	}
					    	else if($(this).val() == 1 || $(this).val() == 4) {
		    					$('.journee_tour label').attr('for', 'journee').text('Journ\351e'),
		    					$('.journee_tour input').attr('id', 'journee').addClass('min_input numeric').attr('placeholder', 'Entrez la journ\351e')
					    	}
					    });

					    $( '.depLieu' ).hide();

						$("#zone-ajout").on("click", ".listeSelect.lieu input", function(){
							$( '.depLieu' ).show();
							$('.depLieu').find('.unAdversaire .uneEquipe.home').remove();
							if($(this).data('value')=='1')
								$('.depLieu').find('.unAdversaire').append($('<div/>').addClass('uneEquipe home').text('Ach\350res'));
							else
								$('.depLieu').find('.unAdversaire').prepend($('<div/>').addClass('uneEquipe home').text('Ach\350res'));

							return false;
						});

					    addSelecteurClub();
					    isNumeric();

						$("#zone-ajout").on('click', '.boutons-actions .btn-ajout', function(){
							var clone = $('.tabAdversaires').find('.row.adversaire').last().clone();
							clone.find('.boutons-actions').append(
								$('<span/>').addClass('btn btn-suppr btn-slim').text('Suppr')
							);
							clone.find('.choixAdversaire').val('');
							clone.find('.unScore input').val('');
							$('.tabAdversaires').find('.row.adversaire').last().after(clone);
							
					    	addSelecteurClub();	
					    	isNumeric();

							return false;
						}).on('click', '.boutons-actions .btn-suppr', function(){
							$(this).closest('.row.adversaire').remove();
							return false;
						});

						$('.require').on('change', verif_require);
						
						hideLoader();
					}
				});
			}
			else if($(this).hasClass('ajout-champ')) {
				$.ajax({
					type: "POST",
					url: "inc/ajax/new_champ.php",
					success: function(data) {
						$("#zone-ajout").append(data);
						addDatepicker(new Date(2015,8,1), new Date(2016,5,30));
						addSelecteurClub2();
						$('.require').on('change', verif_require);

						$('.addEquipe').on('click', function(){
							var row = $('.table.champ .row:not(.head)').first().clone();
							$('.table.champ').append(row);
							$(row).find('#lieu').prop('selectedIndex',0);
							$(row).find('input').val('');
							$(row).find('.datepicker').remove();
							$(row).find('.ui-datepicker-trigger').remove();
							$(row).find('.cell:eq(2)').prepend('<input class="datepicker require date_aller" type="hidden" value="">');
							$(row).find('.cell:eq(3)').prepend('<input class="datepicker require date_retour" type="hidden" value="">');
							$(row).find('.tabAdversaires .liste').text('');
							$(row).find('.date').text('');
							$(row).find('.heure').hide();
							$(row).find('.supprEquipe .btn-annul').removeClass('hidden');
							addDatepicker(new Date(2015,8,1), new Date(2016,5,30));
							addSelecteurClub2();
							$('.require').on('change', verif_require);
							$(row).find('.supprEquipe .btn-annul').on('click', function(){
								$(this).closest('.row').remove();
							});
							
							return false;
						});

						hideLoader();
					}
				});
			}

			return false;
		}).on('click', '.boutons-actions .btn-save:not(.disable)', function() {
			if($(this).hasClass('save-match')) {

				var adversaires = [],
					score_dom = [],
					score_ext = [];
				$.each($('.choixAdversaire'), function(key, val){
					adversaires.push($(val).data('club'));
					s1 = ($($('.score1')[key]).val() == '' ? 0 : $($('.score1')[key]).val());
					score_dom.push(s1);
					s2 = ($($('.score2')[key]).val() == '' ? 0 : $($('.score2')[key]).val());
					score_ext.push(s2);

				});
				var strAdversaires = adversaires.join(',');
				var strScore1 = score_dom.join(',');
				var strScore2 = score_ext.join(',');

				var MonMatch = {
					'id': $('#id_match').val(),
					'categorie': $('#categorie').val(),
					'date': $('#date').datepicker( "option", "dateFormat", "yymmdd" ).val(),
					'heure': $('#heure').val(),
					'competition': $('#competition').val(),
					'niveau': 0,
					'lieu': $('.lieu input.actif').data('value'),
					'gymnase': '',
					'adversaires': strAdversaires,
					'journee': ($('#journee').val() == undefined ? 0 : $('#journee').val()),
					'tour': ($('#tour').val() == undefined ? '' : $('#tour').val()),
					'scores_dom': strScore1,
					'scores_ext': strScore2,
					'joue': $('.joue input.actif').data('value'),
					'arbitre': '',
					'classement': '',
				};

				showLoader();
				$.ajax({
					type: "POST",
					url: "inc/ajax/save_match.php",
					dataType: "json",
					data: { 
						match: MonMatch
					},
					success: function(data) {
						console.log(data);
						if(!data.erreur) {
							window.location.href = 'admin.php?page=calendrier';
						}
						else {
							hideLoader();
						}
					}
				});
			}
			else if($(this).hasClass('save-champ')) {
				var UnChamp = [];
				var i = 1;
				var length = $('.table.champ .row:not(.head)').length;

				$('.table.champ .row:not(.head)').each( function(){

					var UnMatchAller = {
						'categorie': parseInt($('#categorie').val()),
						'date': $(this).find('.date_aller').datepicker( "option", "dateFormat", "yymmdd" ).val(),
						'heure': $(this).find('.aller .heure select').val(),
						'competition': 0,
						'niveau': 0,
						'lieu': parseInt($(this).find('#lieu').val()),
						'gymnase': '',
						'adversaires': $(this).find('.tabAdversaires .valeurs').val(),
						'journee': i,
						'tour': '',
						'scores_dom': '0',
						'scores_ext': '0',
						'joue': 0,
						'arbitre': '',
						'classement': ''
					};
					UnChamp.push(UnMatchAller);

					if($(this).find('.date_retour').datepicker( "option", "dateFormat", "yymmdd" ).val() != '') {
						var UnMatchRetour = {
							'categorie': parseInt($('#categorie').val()),
							'date': $(this).find('.date_retour').datepicker( "option", "dateFormat", "yymmdd" ).val(),
							'heure': $(this).find('.retour .heure select').val(),
							'competition': 0,
							'niveau': 0,
							'lieu': (parseInt($(this).find('#lieu').val())== 0)  ? 1 : 0,
							'gymnase': '',
							'adversaires': $(this).find('.tabAdversaires .valeurs').val(),
							'journee': i + length,
							'tour': '',
							'scores_dom': 0,
							'scores_ext': 0,
							'joue': 0,
							'arbitre': '',
							'classement': ''
						};
						UnChamp.push(UnMatchRetour);
					}
					i++;
				});

				console.log(UnChamp);

				showLoader();
				$.ajax({
					type: "POST",
					url: "inc/ajax/save_champ.php",
					data: { 
						champ: UnChamp
					},
					success: function(data) {
						window.location.href = 'admin.php?page=calendrier';
					}
				});
			}
			return false;
		}).on('click', '.boutons-actions .btn-annul', function() {
			$("#tab_admin").show();
			$("#zone-ajout").find('.action-ajout').show();
			$("#zone-ajout").find('.form').remove();

			return false;
		});
	}

	/**********************
	******* Equipes *******
	**********************/

	var equipes = $('.admin_panel .equipes');

	if(equipes.length > 0) {
		equipes.on('click', '#tab_admin .btn-slim.btn-modif', function() {
			showLoader();
			$("#tab_admin").hide();
			$("#zone-ajout").find('.action-ajout').hide();
			
			$.ajax({
				type: "POST",
				url: "inc/ajax/new_equipe.php",
				data: { 
					id: $(this).attr('href')
				},
				success: function(data) {
					$("#zone-ajout").append(data);

					$('#categorie').on('change', function(){
						var cat_id = $(this).val()*1;
						$('#horaire option').removeAttr('disabled');
						$('#horaire option').each(function(){
							if($(this).data('id') != cat_id && $(this).val() != '-'){
								console.log($(this), 'Yeah !');
								$(this).attr('disabled', 'disabled');
							}
						});
					});

					$( "#entraineurs" ).autocomplete({
			            source: "inc/ajax/liste_utilisateurs.autocomplete.php",
			            minLength: 2,
			            select: function( event, ui ) {
			                if(ui.item){ 
			                	// <span>'+ tag +'</span><a href="#" title="Retirer le tag">x</a>
			                    $('.liste_entraineurs').append($('<span/>').text(ui.item.value).append($('<a/>').attr('href', '#').text('x')));

			                    var idListe = $('#liste_id_entraineurs').val();
					    		if(idListe != '')
					    			$("#liste_id_entraineurs").val(idListe+','+ui.item.id);
					    		else
					    			$("#liste_id_entraineurs").val(ui.item.id);
			                }
			            },
			            close: function( event, ui ) {
			                $('#entraineurs').val('');

			                $('.liste_entraineurs span').on('click', 'a', function(){
					        	var index = $(this).parent().index();
					        	var str = '';
					        	var listeEntraineurs = $('#liste_id_entraineurs').val().split(',');

								for(var i = 0; i < listeEntraineurs.length; i++){
									if(index != i && index != '') {
										if(str == '')
											str += listeEntraineurs[i];
										else
											str += ','+ listeEntraineurs[i];
									}
								}
					        	$('#liste_id_entraineurs').val(str);
					        	$(this).parent().remove();

					        });

					        verif_require();
			            }
			        });
					$('.require').on('change', verif_require);

					hideLoader();
				}
			});

			return false;
		}).on('click', '#tab_admin .btn-slim.btn-suppr', function(e) {
			e.preventDefault();
			var btn = $(this);
			
			$( "body" ).append("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement l'actualit&eacute; ?</div>");
			var suppr_actualite = $(".popin");
			suppr_actualite.dialog({
				title: "Supprimer une actualit&eacute;",
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_actualite.php",
							data: { id: btn.attr('href') },
							success: function(data) {
								var nbr_td = btn.closest('tr').find('td').length; 
								btn.closest('tr').html($('<td/>').attr('id','a_supprimer').attr('colspan', nbr_td).text(data));
								suppr_actualite.remove();
								setTimeout(function(){
									$('#a_supprimer').remove();
								}, 3000);
							}
						});
					},
					"Annuler": function() {
						suppr_actualite.remove();
					} 
				},
				close: function() {
					suppr_actualite.remove();
				},
				modal: true
			});

			return false;
		}).on('click', '.action-ajout .btn-ajout', function() {
			showLoader();
			$("#tab_admin").hide();
			$("#zone-ajout").find('.action-ajout').hide();

			$.ajax({
				type: "POST",
				url: "inc/ajax/new_equipe.php",
				success: function(data) {
					$("#zone-ajout").append(data);

					$('#categorie').on('change', function(){
						var cat_id = $(this).val()*1;
						$('#horaire option').removeAttr('disabled');
						$('#horaire option').each(function(){
							if($(this).data('id') != cat_id && $(this).val() != '-'){
								console.log($(this), 'Yeah !');
								$(this).attr('disabled', 'disabled');
							}
						});
					});

					$( "#entraineurs" ).autocomplete({
			            source: "inc/ajax/liste_utilisateurs.autocomplete.php",
			            minLength: 2,
			            select: function( event, ui ) {
			                if(ui.item){ 
			                	// <span>'+ tag +'</span><a href="#" title="Retirer le tag">x</a>
			                    $('.liste_entraineurs').append($('<span/>').text(ui.item.value).append($('<a/>').attr('href', '#').text('x')));

			                    var idListe = $('#liste_id_entraineurs').val();
					    		if(idListe != '')
					    			$("#liste_id_entraineurs").val(idListe+','+ui.item.id);
					    		else
					    			$("#liste_id_entraineurs").val(ui.item.id);
			                }
			            },
			            close: function( event, ui ) {
			                $('#entraineurs').val('');

			                $('.liste_entraineurs span').on('click', 'a', function(){
					        	var index = $(this).parent().index();
					        	var str = '';
					        	var listeEntraineurs = $('#liste_id_entraineurs').val().split(',');

								for(var i = 0; i < listeEntraineurs.length; i++){
									if(index != i && index != '') {
										if(str == '')
											str += listeEntraineurs[i];
										else
											str += ','+ listeEntraineurs[i];
									}
								}
					        	$('#liste_id_entraineurs').val(str);
					        	$(this).parent().remove();

					        });

					        verif_require();
			            }
			        });
					$('.require').on('change', verif_require);

					hideLoader();
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-save:not(.disable)', function() {
			var erreur = false,
				MonEquipe = {
					'categorie': '',
					'niveau': '',
					'championnat': '',
					'entraineurs': '',
					'entrainements': ''
				};

			if($('#categorie').val() != '')
				MonEquipe.categorie = $('#categorie').val();

			if($('#niveau').val() != '')
				MonEquipe.niveau = $('#niveau').val();

			if($('#championnat').val() != '')
				MonEquipe.championnat = $('#championnat').val();

			if($('#liste_id_entraineurs').val() != '')
				MonEquipe.entraineurs = $('#liste_id_entraineurs').val();

			showLoader();
			$.ajax({
				type: "POST",
				url: "inc/ajax/save_equipe.php",
				data: { 
					equipe: MonEquipe
				},
				success: function(data) {
					$("#zone-ajout").find('.action-ajout').show();
					$("#zone-ajout").find('.form').remove();
					equipes.find('#tab_admin').show().html(data);
					hideLoader();
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-annul', function() {
			$("#zone-ajout").find('.action-ajout').show();
			$("#zone-ajout").find('.form').remove();
			equipes.find('#tab_admin').show();

			return false;
		});
	}

	/**********************
	******** Clubs ********
	**********************/

	var clubs = $('.admin_panel .clubs');

	if(clubs.length > 0) {
		clubs.on('click', '#tab_admin .btn-slim.btn-modif', function() {
			showLoader();
			$("#tab_admin").hide();
			$("#zone-ajout").find('.action-ajout').hide();

			$.ajax({
				type: "POST",
				data: {
					clubId: $(this).attr('href')
				},
				url: "inc/ajax/new_club.php",
				success: function(data) {
					$("#zone-ajout").append(data);

					changeSelect();
					$('.require').on('change', verif_require);
					hideLoader();
				}
			});

			return false;
		}).on('click', '#tab_admin .btn-slim.btn-suppr', function() {
			var btn = $(this);
			
			$( "body" ).append("<div class='popin'>Souhaitez-vous supprimer d&eacute;finitivement le club ?</div>");
			var suppr_club = $(".popin");
			suppr_club.dialog({
				title: "Supprimer un club",
				width: 400,
				height: 150,
				buttons: { 
					"Supprimer": function() {
						$.ajax({
							type: "POST",
							url: "inc/ajax/suppr_club.php",
							dataType: "json",
							data: { id: btn.attr('href') },
							success: function(data) {
								var nbr_td = btn.closest('tr').find('td').length; 
								var tr = btn.closest('tr').clone();
								btn.closest('tr').html($('<td/>').attr('id','a_supprimer').attr('colspan', nbr_td).text(data.message));
								suppr_club.remove();
								if(!data.erreur) {
									setTimeout(function(){
										$('#a_supprimer').remove();
									}, 3000);
								}
								else {
									setTimeout(function(){
										$('#a_supprimer').parent().html(tr.html());
									}, 3000);
								}
							}
						});
					},
					"Annuler": function() {
						suppr_club.remove();
					} 
				},
				close: function() {
					suppr_club.remove();
				},
				modal: true
			});
			
			return false;
		}).on('click', '.action-ajout .btn-ajout', function() {
			showLoader();
			$("#tab_admin").hide();

			$.ajax({
				type: "POST",
				url: "inc/ajax/new_club.php",
				success: function(data) {
					$("#zone-ajout").append(data);
					$("#zone-ajout").find('.action-ajout').hide();
					$('.require').on('change', verif_require);

					hideLoader();
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-save:not(.disable)', function() {

			if($('.hidden .listeSelect.actif').length > 0)
				val_actif = 1;
			else
				val_actif = $('.listeSelect.actif').find('.actif').data('value');

			var MonClub = {
				'id': $("#zone-ajout").find('#id_club').val(),
				'nom': $("#zone-ajout").find('#nom').val(),
		 		'raccourci': $("#zone-ajout").find('#raccourci').val(),
		 		'numero': $("#zone-ajout").find('#numero').val(),
		 		'ville': $("#zone-ajout").find('#ville').val(),
		 		'code_postal': $("#zone-ajout").find('#code_postal').val(),
		 		'actif': val_actif
			 };

			showLoader();

			num_page = getParameterByName('num_page');

			$.ajax({
				type: "POST",
				url: "inc/ajax/save_club.php?num_page="+num_page,
				data: { 
					club: MonClub
				},
				success: function(data) {
					$("#zone-ajout").find('.form').remove();
					$("#zone-ajout").find('.action-ajout').show();
					clubs.find('#tab_admin').html(data).show();
					hideLoader();
				}
			});

			return false;
		}).on('click', '.boutons-actions .btn-annul', function(e) {
			$("#zone-ajout").find('.action-ajout').show();
			$("#zone-ajout").find('.form').remove();
			clubs.find('#tab_admin').show();

			return false;
		});
	}

	/*********************
	******* Tarifs *******
	*********************/

	var admin_tarif = $('.admin_panel .tarifs');

	if(admin_tarif.length > 0) {

		/* Intégration du formulaire d'ajout d'un tarif */
		admin_tarif.on('click', '.action-ajout .btn-ajout', function(event) {
			event.preventDefault();
			var contenu = 	'<div class="form">';
			contenu += 			'<div class="table">';
			contenu += 				'<div class="row">';
			contenu += 					'<div class="cell cell-1-3 pad">';
			contenu += 						'<label for="date_naissance">N&eacute;(e)s en</label><br/>';
			contenu += 						'<input id="date_naissance" type="text"/><br/><br/>';
			contenu += 						'<label for="categorie">Categorie</label><br/>';
			contenu += 						'<input id="categorie" type="text"/><br/><br/>';
			contenu += 						'<label for="annee">Ann&eacute;e</label><br/>';
			contenu += 						'<input id="annee" type="text" class="numeric"/><br/><br/>';
			contenu += 					'</div>';
			contenu += 					'<div class="cell cell-1-3 pad">';
			contenu += 						'<label for="prix_old">Prix/condition</label><br/>';
			contenu += 						'<input id="prix_old" type="text" class="numeric"/>';
			contenu += 						'<select id="condition_old">';
			contenu += 							'<option value="0">Aucune</option>';
			contenu += 							'<option value="1">1</option>';
			contenu += 							'<option value="2">2</option>';
			contenu += 							'<option value="3">3</option>';
			contenu += 						'</select><br/><br/>';
			contenu += 						'<label for="prix_nv">Prix/condition nvx adh&eacute;rents</label><br/>';
			contenu += 						'<input id="prix_nv" type="text" class="numeric"/>';
			contenu += 						'<select id="condition_nv">';
			contenu += 							'<option value="0">Aucune</option>';
			contenu += 							'<option value="1">1</option>';
			contenu += 							'<option value="2">2</option>';
			contenu += 							'<option value="3">3</option>';
			contenu += 						'</select>';
			contenu += 					'</div>';
			contenu += 					'<div class="cell cell-1-3 pad boutons-actions">';
			contenu += 						'<a href="#" class="btn btn-save">Enregistrer ce tarif</a>';
			contenu += 					'</div>';
			contenu += 				'</div>';
			contenu += 			'</div>';
			contenu += 		'</div>';

			$("#zone-ajout").append(contenu);
			$("#zone-ajout").find('.action-ajout').hide();
			isNumeric();

			return false;
		}).on('click', '.boutons-actions .btn-save', function(event) {
			event.preventDefault();
			var MonTarif = {
				'date_naissance': $("#zone-ajout").find('#date_naissance').val(),
		 		'categorie': $("#zone-ajout").find('#categorie').val(),
		 		'genre': 1,
		 		'prix_old': $("#zone-ajout").find('#prix_old').val(),
		 		'prix_nv': $("#zone-ajout").find('#prix_nv').val(),
		 		'condition_old': $("#zone-ajout").find('#condition_old').val(),
		 		'condition_nv': $("#zone-ajout").find('#condition_nv').val(),
		 		'annee': $("#zone-ajout").find('#annee').val()
			 };
			console.log(MonTarif);
			
			showLoader();

			$.ajax({
				type: "POST",
				url: "inc/ajax/save_tarif.php",
				data: { 
					tarif: MonTarif
				},
				success: function(data) {
					// console.log(data);
					$("#zone-ajout form").remove();
					$("#zone-ajout").find('.action-ajout').show();
					admin_tarif.find('#tab_admin').html(data);

					hideLoader();
				}
			});

			return false;
		});
	}


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
	// Ajoute un tag à la liste
	var addTag = function() {
    	var tag = $("#add_tag").val();
    	if(tag != '' && !existeTag(tag)) {
    		$(".tags .liste_tags").append('<span class="tag"><span>'+ tag +'</span><a href="#" title="Retirer le tag">x</a></span>');
    		var tagsListe = $("#tags").val();
    		if(tagsListe != '')
    			$("#tags").val(tagsListe+','+tag);
    		else
    			$("#tags").val(tag);
    	}
    	$("#add_tag").val('');
    };
    // Retire un tag de la liste
    var removeTag = function(e) {
    	var str = '';
    	var listeTags = $('#tags').val().split(',');
		for(var i = 0; i < listeTags.length; i++){
			if(listeTags[i] != $(e.target).parent().find('span').text() && listeTags[i] != '') {
				if(str == '')
					str += listeTags[i];
				else
					str += ','+ listeTags[i];
			}
		}
		$("#tags").val(str);
    	$(e.target).parent().remove();
    };
    // Vérifie l'existence d'un tag
    var existeTag = function(value){
    	var listeTags = $('#tags').val().split(',');
		for(var i = 0; i < listeTags.length; i++){
			if(listeTags[i] == value) {
				return true;
			}
		}
		return false;
    };
    // Ajoute un TinyMCE
    var addTinyMCE = function(){
    	if(tinymce.editors.length<1){
    		tinymce.init({
    			language: "fr_FR",
    			mode: "none",
				selector: ".tinymce",
				plugins: [
			        "advlist autolink lists link image charmap print preview anchor",
			        "searchreplace visualblocks code fullscreen",
			        "insertdatetime media table contextmenu paste"
			    ],
			    toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | link image"
		    });
    	}
    	else if(tinymce.editors.length>0){
    		tinymce.execCommand('mceAddEditor', false, 'contenu');
    	}
    };

	// Supprime un TinyMCE
    var supprTinyMCE = function(id){
    	tinymce.execCommand('mceFocus', false, id);
    	tinymce.execCommand('mceRemoveEditor', false, id);
    };

    // Ajoute un datepicker simple
    var addDatepicker = function(minDate, maxDate){
    	$( ".datepicker" ).datepicker({
	    	buttonImage: 'images/icon/png_black/calendar.png',
	        buttonImageOnly: true,
	        changeMonth: true,
	        changeYear: true,
	        showOn: 'both',
	        altField: "#datepicker",
		    closeText: 'Fermer',
		    prevText: 'Précédent',
		    nextText: 'Suivant',
		    currentText: 'Aujourd\'hui',
		    monthNames: ['Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre'],
		    monthNamesShort: ['Janv.', 'F&eacute;vr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Ao&ucirc;t', 'Sept.', 'Oct.', 'Nov.', 'D&eacute;c.'],
		    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
		    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		    weekHeader: 'Sem.',
	        dateFormat: 'dd/mm/yy',
	        minDate: minDate,
	        maxDate: maxDate,
	    }).on('change', function(){
	    	$(this).parent().find('.date').text($(this).val());
	    	$(this).parent().find('.heure').show();
	    });
    };

    // Change le bouton select choisie
    var changeSelect = function(){
    	$('.listeSelect > .select').click(function(e){
	    	e.preventDefault();
	    	$(this).parent().find('.select').removeClass('actif');
	    	$(this).addClass('actif');
	    });
    };

    var addSelecteurClub = function(){
    	$( ".choixAdversaire" ).autocomplete({
			source: "inc/ajax/liste_clubs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item) {
		    		$(this).data('club', ui.item.id);
				}
			},
			close: function(){
		        verif_require();
			}
		});
    };

    var addSelecteurClub2 = function(){
    	$( ".choixAdversaire" ).autocomplete({
			source: "inc/ajax/liste_clubs.autocomplete.php",
			minLength: 2,
			select: function( event, ui ) {
				if(ui.item) {
					$(this).parent().find('.liste').append($('<span/>').text(ui.item.value).append($('<a/>').attr('href', '#').addClass('btn btn-tiny btn-annul')));
					var valeurs = $(this).parent().find('.valeurs').val();
		    		if(valeurs != '')
		    			$(this).parent().find('.valeurs').val(valeurs+','+ui.item.id);
		    		else
		    			$(this).parent().find('.valeurs').val(ui.item.id);
				}
			},
			close: function(){
				$(this).val('');
				var that = $(this);

				$(this).parent().find('.liste span').on('click', 'a', function(){
		        	var index = $(this).parent().index();
		        	var str = '';
		        	var liste = that.parent().find('.valeurs').val().split(',');

					for(var i = 0; i < liste.length; i++){
						if(index != i && index != '') {
							if(str == '')
								str += liste[i];
							else
								str += ','+ liste[i];
						}
					}
		        	that.parent().find('.valeurs').val(str);
		        	$(this).parent().remove();

		        });
		        verif_require();
			}
		});
    };

    var isNumeric = function(){
    	$('.numeric').blur(function(){
    		if($( this ).val().match(/[0-9]/g))
				$( this ).css('border', '2px solid #5CB85C');
			else
				$( this ).css('border', '2px solid #d9534f');
    	});
    };

    var verif_require = function(){
		var btn_save = $('.boutons-actions .btn-save');
		 console.log(input_require_vide(), !listeSelect_require_vide(), select_require_vide());
		if(input_require_vide() && !listeSelect_require_vide() && select_require_vide()) {
			if(btn_save.hasClass('disable'))
				btn_save.removeClass('disable');
		}
		else if(!btn_save.hasClass('disable'))
			btn_save.addClass('disable');
	};

	var input_require_vide = function(){
		var retour = true;
		if($('input.require').length > 0) {
			$('input.require').each( function(){
				if($(this).val() == ''){
					retour = false;
					return;
				}
			});
			return retour;
		}
		else {
			return true;
		}
	};

	var listeSelect_require_vide = function(){
		var retour = true;
		if($('.listeSelect.require').length > 0) {
			$('.listeSelect.require').each( function(){
				$(this).find('.select').each( function(){
					if($(this).hasClass('actif')) {
						retour = false;
						return;
					}
				});
				if(!retour)
					return false;
			});
			return retour;
		}
		else {
			return false;
		}
	};

	var select_require_vide = function(){
		var retour = true;
		if($('select.require').length > 0) {
			$('select.require').each( function(){
				if($(this).val() == '-') {
					retour = false;
					return;
				}
			});
			return retour;
		}
		else {
			return true;
		}
	};

	var getParameterByName = function (name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
});