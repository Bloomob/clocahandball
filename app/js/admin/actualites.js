
$(function(){

	/*************************
	******* Actualites *******
	*************************/

	var actualites = $('.admin .actualites');
	
	if(actualites.length > 0) {
		/*
		* VARIABLES
		*/
		var actuModal = $('#actuModal');
		var actuData = {
			id: {
				value: 0,
				valid: true
			},
			titre: {
				value: '',
				valid: false
			},
			sous_titre: {
				value: '',
				valid: false
			},
			contenu: {
				value: '',
				valid: false
			},
			image: {
				value: '',
				valid: true
			},
			theme: {
				value: '',
				valid: false
			},
			tags: {
				value: '',
				valid: true
			},
			publication: {
				value: '0',
				valid: true
			},
			date: {
				value: 0,
				valid: false
			},
			heure: {
				value: 0,
				valid: false
			},
			slider: {
				value: '0',
				valid: true
			},
			importance: {
				value: '3',
				valid: true
			},
			publie: {
				value: '0',
				valid: true
			}
		}
		
		/*
		* INIT
		*/
		$('#date').datetimepicker({
			icons: {
			  time: "fa fa-clock-o",
			  date: "fa fa-calendar",
			  up: "fa fa-arrow-up",
			  down: "fa fa-arrow-down"
			}
			, minDate: moment()
		});
        
        tinymce.init({ selector:'textarea' });
		
		/*
		* FONCTIONS
		*/
		
		function formInputRadio(ch) {
			if($(actuModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
				actuData[ch]['value'] = $(actuModal).find('input[name="'+ ch +'"]:checked').val();
				actuData[ch]['valid'] = true;
			} else {
				actuData[ch]['value'] = '';
				actuData[ch]['valid'] = false;
			}
			if(!actuData[ch]['valid']) {
				$(actuModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
			} else {
				$(actuModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
			}
		}
		
		function formSelect(ch) {
			if($(actuModal).find('#'+ ch).val() != '' && $(actuModal).find('#'+ ch).val() != null) {
				actuData[ch]['value'] = $(actuModal).find('#'+ ch).val();
				actuData[ch]['valid'] = true;
			} else {
				actuData[ch]['value'] = '';
				actuData[ch]['valid'] = false;
			}
			if(!actuData[ch]['valid']) {
				$(actuModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
			} else {
				$(actuModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
			}
		}

		actuModal.find('input[type="text"]').keypress(function(e){
		  if(event.keyCode == 13){
		    e.preventDefault();
		  }
		});
		
		/* OnChange */

		$(actuModal).find('#image').on('change', function(e){
			e.preventDefault();
			
			$(actuModal).find('.image .img_loader').removeClass('hidden');
			$(actuModal).find('.image .img_errors').addClass('hidden').text('');
			var formData = new FormData();
			formData.append('image', $(this)[0].files[0]);
			
			// On lance l'upload
			$.ajax({
				type: 'POST',
				url: './inc/api/upload_img.php',
				data: formData,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				success: function (data) {
					$(actuModal).find('.image .img_loader').addClass('hidden');
					
					if(data.success) {
						$(actuModal).find('.image label.btn').addClass('btn-warning').removeClass('btn-success').text("Changer d'image");
						$(actuModal).find('.image .img_details').removeClass('hidden').find('img').attr('src', data.path).attr('alt', data.path);
						$(actuModal).find('.image .img_remove').removeClass('hidden');
						actuData['image']['value'] = data.path;
						actuData['image']['valid'] = true;
					} else {
						$(actuModal).find('.image .img_errors').removeClass('hidden').text(data.message);
						actuData['image']['value'] = "";
						actuData['image']['valid'] = false;
						
						setTimeout(function() {
							$(actuModal).find('.image .img_errors').addClass('hidden').text('');
						}, 3000);
					}
				}
			});
		});
		
		$(actuModal).find('.btn.nav_album').on('click', function(e){
			e.preventDefault();
			var chemin = $(this).data('chemin');
			$.ajax( {
				type: "POST",
				url: "inc/api/nav_img.php",
				data: { 
					dossier: chemin,
					format: 'min'
				},
				success: function(data) {
					$(actuModal).find('.image .img_details').addClass('hidden');
					$(actuModal).find( ".navigation_albums" ).removeClass("hidden").html( data );
				}
			});
		});
		$(actuModal).find('.navigation_albums').on('click', '.liste a.nav', function(e){
			e.preventDefault();
			var chemin = $(this).data('chemin');
			$.ajax( {
				type: "POST",
				url: "inc/api/nav_img.php",
				data: { 
					dossier: chemin,
					format: 'min'
				},
				success: function(data) {
					$(actuModal).find( ".navigation_albums" ).html( data );
				}
			});
		}).on('click', '.liste a.file_img', function(e){
			e.preventDefault();
			$( ".navigation_albums" ).addClass("hidden");
			var path = 'images/albums' + $(this).data('chemin');
			$(actuModal).find('.image .img_details').removeClass('hidden').find('img').attr('src', path).attr('alt', path);
			$(actuModal).find('.image .img_remove').removeClass('hidden');
			actuData['image']['value'] = path;
			actuData['image']['valid'] = true;
		});

		$(actuModal).find('.img_remove').on('click', function(e){
			e.preventDefault();
			$(actuModal).find('.image label.btn').removeClass('btn-warning').addClass('btn-success').text("Uploader une nouvelle image");
			$(actuModal).find('.image .img_details').addClass('hidden').find('img').attr('src', '').attr('alt', '');
			$(actuModal).find('.image .img_remove').addClass('hidden');
			actuData['image']['value'] = '';
			actuData['image']['valid'] = false;
		});

		$(actuModal).find('input[name="publication"]').on('change', function(){
			formInputRadio('publication');
			if(actuData['publication']['value'] == 1)
				$(actuModal).find('.date').removeClass('hidden');
			else
				$(actuModal).find('.date').addClass('hidden');
		});

		$(actuModal).find('input[name="slider"]').on('change', function(){
			formInputRadio('slider');
		});

		$(actuModal).find('input[name="importance"]').on('change', function(){
			formInputRadio('importance');
		});

		$(actuModal).find('input[name="publie"]').on('change', function(){
			formInputRadio('publie');
		});
		
		/* Appel à la modal */
		actuModal.on('show.bs.modal', function (e) {
			var button = $(e.relatedTarget);
			var id = button.data('id');
			actuModal.find('.modal-title, .edit-actu, .add-actu').addClass('hidden');
						
			/*for(ch in actuData) {
				actuModal.find('#'+ ch).selectpicker('val', '');
			}*/
			
			if(id > 0) {
				actuModal.find('#editActuLabel, .edit-actu').removeClass('hidden');
				actuModal.find('.modal-body').addClass('hidden');
				actuModal.find('.modal-loader').removeClass('hidden');
				
				$.getJSON(
					'./inc/api/admin/actuality/get-actu.php',
					{
						id: id
					},
					function (data) {					
						for(ch in data) {
							if(ch == 'id') {
								actuData[ch]['value'] = data[ch];
							} else if(ch == 'theme') {
								actuModal.find('#'+ ch).selectpicker('val', data[ch]);
							} else if(ch == 'date_publication') {
								var annee = data[ch].toString().substr(0,4);
								var mois = data[ch].toString().substr(4,2);
								var jour = data[ch].toString().substr(6,2);
								
								if(data['heure_publication'].toString().length == 3) {
									var heure = '0' + data['heure_publication'].toString().substr(0,1);
									var minute = data['heure_publication'].toString().substr(-2,2);
								} else if(data['heure_publication'].toString().length == 4) {
									var heure = data['heure_publication'].toString().substr(0,2);
									var minute = data['heure_publication'].toString().substr(-2,2);
								} else if(data['heure_publication'].toString().length == 2) {
									var heure = '00';
									var minute = data['heure_publication'];
								} else {
									var heure = '00';
									var minute = '0' + data['heure_publication'];
								}
								actuModal.find('.publication').addClass('hidden');
								actuModal.find('.date').removeClass('hidden');
								
                                if(data['date_publication'] != 0) {
                                    if(data['heure_publication'] != 0) {
                                        actuModal.find('#date-val').val(jour +'/'+ mois +'/'+ annee +' '+ heure +':'+ minute);
                                    } else {
                                        actuModal.find('#date-val').val(jour +'/'+ mois +'/'+ annee);
                                    }
                                }
                                
								actuData['date'] = { value: annee + mois + jour, valid: true };
								actuData['heure'] = { value: heure + minute, valid: true };
							} else if(ch == 'slider') {
								actuModal.find('.slider .btn').removeClass('active').find('input').prop('checked', false);
								
								if(data[ch] == 1)
									$('#slider_oui').parent().addClass('active').find('input').prop('checked', true);
								else
									$('#importance_non').parent().addClass('active').find('input').prop('checked', true);
							} else if(ch == 'importance') {
								actuModal.find('.importance .btn').removeClass('active').find('input').prop('checked', false);
								
								if(data[ch] == 3)
									$('#importance_basse').parent().addClass('active').find('input').prop('checked', true);
								else if(data[ch] == 2)
									$('#importance_moyenne').parent().addClass('active').find('input').prop('checked', true);
								else
									$('#importance_haute').parent().addClass('active').find('input').prop('checked', true);
							} else if(ch == 'publie') {
								actuModal.find('.publie .btn').removeClass('active').find('input').prop('checked', false);
								
								if(data[ch] == 0)
									$('#publie_non').parent().addClass('active').find('input').prop('checked', true);
								else
									$('#publie_oui').parent().addClass('active').find('input').prop('checked', true);
							} else if(ch == 'image') {
								actuData[ch]['value'] = data[ch];
								actuModal.find('.'+ ch +' .img_details').removeClass('hidden').find('img').attr('src', data[ch]).attr('alt', data[ch]);
								actuModal.find('.'+ ch +' .img_remove').removeClass('hidden');
							} else if(ch == 'tags') {
								actuModal.find('#'+ ch).tagsinput('add', data[ch]);
							} else {
								actuModal.find('#'+ ch).val(data[ch]);
							}
						}
						actuModal.find('.modal-loader').addClass('hidden');
						actuModal.find('.modal-body').removeClass('hidden');
                        tinymce.activeEditor.setContent(data.contenu);
					}
				);
			} else {
				actuModal.find('#addActuLabel, .add-actu').removeClass('hidden');
			}
		});
		
		/* Ajout/édition de match */
		actuModal.find('.add-actu, .edit-actu').on('click', function(e){
			e.preventDefault();
			var formValid = true;
			var DateTimePicker = $(actuModal).find('#date').data("DateTimePicker").date();

			for(ch in actuData) {
				if(ch == 'slider' || ch == 'publication' || ch == 'importance' || ch == 'publie') {
					if($(actuModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
						actuData[ch]['value'] = $(actuModal).find('input[name="'+ ch +'"]:checked').val();
						actuData[ch]['valid'] = true;
					} else {
						actuData[ch]['value'] = '';
						actuData[ch]['valid'] = false;
					}
					if(!actuData[ch]['valid']) {
						if(formValid) {
							formValid = false;
						}
						$(actuModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
					} else {
						$(actuModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				} else if(ch == 'date') {
					// On teste si c'est une programmation programmée
					if(actuData['publication']['value'] == 1) {
						if(DateTimePicker != '' && DateTimePicker != null) {
							actuData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
							actuData[ch]['valid'] = true;
						} else {
							actuData[ch]['value'] = '';
							actuData[ch]['valid'] = false;
						}
					} else {
						if(actuData['id']['value'] != 0) {
							if(DateTimePicker != '' && DateTimePicker != null) {
								actuData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
								actuData[ch]['valid'] = true;
							}
						} else {
                            if(DateTimePicker != '' && DateTimePicker != null) {
								actuData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
								actuData[ch]['valid'] = true;
							} else {
                                actuData[ch]['value'] = '';
                                actuData[ch]['valid'] = true;
                            }
						}
					}
					if(!actuData[ch]['valid']) {
						if(formValid) {
							formValid = false;
						}
						$(actuModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
					} else {
						$(actuModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				} else if(ch == 'heure') {
					// On teste si c'est une programmation programmée
					if(actuData['publication']['value'] == 1) {
						if(DateTimePicker != '' && DateTimePicker != null) {
							actuData[ch]['value'] = moment(DateTimePicker).format('HHmm');
							actuData[ch]['valid'] = true;
						} else {
							actuData[ch]['value'] = '';
							actuData[ch]['valid'] = false;
						}
					} else {
						if(actuData['id']['value'] != 0) {
							if(DateTimePicker != '' && DateTimePicker != null) {
								actuData[ch]['value'] = moment(DateTimePicker).format('HHmm');
								actuData[ch]['valid'] = true;
							}
						} else {
                            if(DateTimePicker != '' && DateTimePicker != null) {
								actuData[ch]['value'] = moment(DateTimePicker).format('HHmm');
								actuData[ch]['valid'] = true;
							} else {
                                actuData[ch]['value'] = '';
                                actuData[ch]['valid'] = true;
                            }
						}
					}
					if(!actuData[ch]['valid']) {
						if(formValid) {
							formValid = false;
						}
					}
				} else if(ch == 'image') {
					if(!actuData[ch]['valid']) {
						if(formValid) {
							formValid = false;
						}
					}
				} else if(ch == 'contenu') {
					if(tinymce.activeEditor.getContent() !== '') {
                        actuData[ch] = { value: tinymce.activeEditor.getContent(), valid: true };
                    } else {
                        actuData[ch] = { value: '', valid: false };
                    }
				} else if(ch != 'id') {
					if($(actuModal).find('#'+ ch).val() != '' && $(actuModal).find('#'+ ch).val() != null) {
						actuData[ch]['value'] = $(actuModal).find('#'+ ch).val();
						actuData[ch]['valid'] = true;
					} else {
						if(ch != 'tags') {
							actuData[ch]['value'] = '';
							actuData[ch]['valid'] = false;
						}
					}
					if(!actuData[ch]['valid']) {
						if(formValid) {
							formValid = false;
						}
						$(actuModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
					} else {
						$(actuModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				}
			}

			console.log("=================");
			console.log(actuData);
			console.log('formValid', formValid);
			console.log("=================");

			if (formValid) {
				if($(this).hasClass('add-actu')) {
					$.post(
						'./inc/api/admin/actuality/add-actu.php',
						{
						  'data': actuData
						},
						function (data) {
							if(data)
								window.location.href = location.href;
							else
								console.log(data);
						 }
					);
				} else {
					$.post(
						'./inc/api/admin/actuality/edit-actu.php',
						{
						  'data': actuData
						},
						function (data) {
							if(data)
								window.location.href = location.href;
							else
								console.log(data);
						 }
					);
				}
			}
		});

		// Suppression d'un utilisateur
		actualites.find('.delete-actu').on('click', function(e){
			e.preventDefault();
			var supprId = $(this).data('id');

			$.post(
				'./inc/api/admin/actuality/delete-actu.php',
				{
					'id': supprId
				},
				function (data) {
					if(data)
						window.location.href = location.href;
					else
						console.log(data);
				}
		   );
		});
	}
});