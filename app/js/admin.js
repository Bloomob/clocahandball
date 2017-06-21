$(function(){

	/***************************
	******* Utilisateurs *******
	***************************/

	var utilisateurs = $('.admin .utilisateurs');
	if(utilisateurs.length > 0) {
		var addUserModal = $('.admin .utilisateurs #addUserModal');
		var addUserData = {
	    	'nom': '',
	    	'prenom': '',
	    	'email': '',
	    	'num_licence': 0,
	    	'mot_de_passe': '',
	    	'confirm_mot_de_passe': '',
	    	'rang': 0
	  }
	  var notValid = true;

  	$(addUserModal).find('#nom').keyup(function(){
  		addUserData['nom'] = $(this).val();

			if(addUserData['nom'].length < 1) {
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				notValid = true;
			} else {
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				notValid = false;
			}
  	});

  	$(addUserModal).find('#prenom').keyup(function(){
  		addUserData['prenom'] = $(this).val();

			if(addUserData['prenom'].length < 1) {
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				notValid = true;
			} else {
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				notValid = false;
			}
  	});

  	$(addUserModal).find('#mot_de_passe').keyup(function(){
  		addUserData['mot_de_passe'] = $(this).val();

			if(addUserData['mot_de_passe'].length < 5) {
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserModal.find('.alert-danger.taille-mot-de-passe').removeClass('hidden');
				notValid = true;
			} else {
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserModal.find('.alert-danger.taille-mot-de-passe').addClass('hidden');
				notValid = false;
			}
  	});

		$(addUserModal).find('#confirm_mot_de_passe').keyup(function(){
  		addUserData['confirm_mot_de_passe'] = $(this).val();

  		if (addUserData['mot_de_passe'] !== addUserData['confirm_mot_de_passe']) {
  			$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				addUserModal.find('.alert-danger.diff-mot-de-passe').removeClass('hidden');
				notValid = true;
			} else {
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				addUserModal.find('.alert-danger.diff-mot-de-passe').addClass('hidden');
				notValid = false;
  		}
  	});
		
		addUserModal.find('.add-user').click(function(e){
	    e.preventDefault();
	    
			for(ch in addUserData) {
				addUserData[ch] = $(addUserModal).find('#'+ ch).val();
			}
	    console.log(addUserData);
	    if (!notValid) {
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
	    console.log(addTeamData);
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