
$(function(){

	/***************************
	******* Utilisateurs *******
	***************************/

	var utilisateurs = $('.admin .utilisateurs');
	if(utilisateurs.length > 0) {
		var addUserModal = $('.admin .utilisateurs #addUserModal');
		var addUserData = {
	    nom: {
	    	value: '',
	    	valid: false
	    },
	    prenom: {
	    	value: '',
	    	valid: false
	    },
	    mail: {
	    	value: '',
	    	valid: false
	    },
	    num_licence: {
	    	value: 0,
	    	valid: false
	    },
	    mot_de_passe: {
	    	value: '',
	    	valid: false
	    },
	    confirm_mot_de_passe: {
	    	value: '',
	    	valid: false
	    },
	    rang: {
	    	value: 0,
	    	valid: false
	    },
	    actif: {
	    	value: 0,
	    	valid: false
	    }
	  };

  	$(addUserModal).find('#nom').keyup(function(){
  		addUserData['nom']['value'] = $(this).val();

			if(addUserData['nom']['value'].length < 1) {
				$(this).popover('show');
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserData['nom']['valid'] = false;
			} else {
				$(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserData['nom']['valid'] = true;
			}
  	});

  	$(addUserModal).find('#prenom').keyup(function(){
  		addUserData['prenom']['value'] = $(this).val();

			if(addUserData['prenom']['value'].length < 1) {
				$(this).popover('show');
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserData['prenom']['valid'] = false;
			} else {
				$(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserData['prenom']['valid'] = true;
			}
  	});

  	$(addUserModal).find('#mot_de_passe').keyup(function(){
  		addUserData['mot_de_passe']['value'] = $(this).val();

			if(addUserData['mot_de_passe']['value'].length < 5) {
				$(this).popover('show');
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserData['mot_de_passe']['valid'] = false;
			} else {
				$(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserData['mot_de_passe']['valid'] = true;
			}
  	});

		$(addUserModal).find('#confirm_mot_de_passe').keyup(function(){
  		addUserData['confirm_mot_de_passe']['value'] = $(this).val();

  		if (addUserData['mot_de_passe']['value'] !== addUserData['confirm_mot_de_passe']['value']) {
  			$(this).popover('show');
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserData['confirm_mot_de_passe']['valid'] = false;
			} else {
				$(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserData['confirm_mot_de_passe']['valid'] = true;
  		}
  	});
		
		addUserModal.find('.add-user').click(function(e){
	    e.preventDefault();
	    var formValid = true;

	    addUserModal.find('.form-errors').addClass('hidden');
	    
			for(ch in addUserData) {
				if(ch.value == 'actif') {
					addUserData[ch]['value'] = ($(addUserModal).find('#actif_oui').prop('checked'))?1:0;
				} else {
					addUserData[ch]['value'] = $(addUserModal).find('#'+ ch).val();
				}
				if(!addUserData[ch]['valid']) {
					if(formValid) {
						formValid = false;
					}
					$('#'+ ch).popover('show');
					$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				}
			}
	    console.log(addUserData);
	    if (formValid) {
	      $.post(
	          './inc/api/admin/add-user.php',
	          {
	              'data': addUserData
	          },
	          function (data) {
	              console.log(data);
	              /*if(!data)
	                  $('#connexionModal .alert-danger').removeClass('hidden');
	              else
	                  window.location.href = 'index.php';
	*/          }
			      );
			    } else {
			    	addUserModal.find('.form-errors').removeClass('hidden');
			    }
			});
		}

  /********************
	******* Menus *******
	********************/

	var admin_menu = $('.admin-panel .menu');

	if(admin_menu.length > 0) {

		/**** Sauvegarde menu ****/
		admin_menu.on('click', '.save-all', saveMenu(event));
		function saveMenu(e) {
			e.preventDefault();
			
			/* Variables */
			var MonMenu = new Array();
			var i = 1;


			tabs.find('.liste-tabs ul li').each(function (index) {
				var tab = $($(this).find('a').attr('href'));
				consol
				e.log(tab);

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
		}
	}

	/***************************
	******* Utilisateurs *******
	***************************/

	var equipes = $('.admin .equipes');
	if(equipes.length > 0) {

		/* Ajout d'une équipe */
		var addTeamModal = $('.admin .equipes #addTeamModal');
		var addTeamData = {
	    	'categorie': '',
	    	'niveau': '',
	    	'championnat': '',
	    	'annee': 0,
	    	'entraineurs': [],
	    	'entrainements': [{
			    	'jour_1': 0,
			    	'heure_debut_1': 0,
			    	'heure_fin_1': 0,
			    	'gymnase_1': 0
			    }, {
			    	'jour_2': 0,
			    	'heure_debut_2': 0,
			    	'heure_fin_2': 0,
			    	'gymnase_2': 0
			    }, {
			    	'heure_debut_3': 0,
			    	'jour_3': 0,
			    	'heure_fin_3': 0,
			    	'gymnase_3': 0
			    }
		    ]
        }
        var notValid = false;
        
        addTeamModal.find('.add-training').on('click', function(e){
            e.preventDefault();
            
            if($(this).hasClass('add-training')) {
                var select = $(this).closest('.row').find('.selectpicker');
                select.prop('disabled', false);
                select.selectpicker('refresh');
                $(this).toggleClass('add-training remove-training btn-success btn-danger');
            } else {
                var select = $(this).closest('.row').find('.selectpicker');
                select.prop('disabled', true);
                select.selectpicker('refresh');
                $(this).toggleClass('add-training remove-training btn-success btn-danger');
            }
        });

        addTeamModal.find('.add-team').click(function(e){
            e.preventDefault();
	    
			for(ch in addTeamData) {
				if(ch == 'entrainements') {
					for(i in addTeamData[ch]) {
						for(ent in addTeamData[ch][i]) {
							addTeamData[ch][i][ent] = $(addTeamModal).find('#'+ ent).val();
						}
					}
				} else {
					addTeamData[ch] = $(addTeamModal).find('#'+ ch).val();
					if(addTeamData[ch] == '') {
						notValid = true;
					}
				}
			}
	       // console.log(addTeamData);
            
	       if (!notValid) {
              $.post(
                  './inc/api/admin/add-team.php',
                  {
                      'data': addTeamData
                  },
                  function (data) {
                    console.log(data);
                  }
		      );
            }
		});

		/* Suppression d'une équipe */
		equipes.find('.delete-team').click(function(e){
			e.preventDefault();
			var supprId = $(this).data('id');

			$.post(
                './inc/api/admin/delete-team.php',
                {
                    'id': supprId
                },
                function (data) {
                    console.log(data);
                    if(data) {
                        window.location.href = location.href;
                    }
                }
	       );
		});
	}
});