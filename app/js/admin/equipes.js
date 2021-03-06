$(function(){

	/**********************
	******* Equipes *******
	**********************/

	var equipes = $('.admin .equipes');
	if(equipes.length > 0) {
		var teamModal = equipes.find('#teamModal');
		var teamData = {
            id: 0,
	    	categorie: '',
	    	niveau: '',
	    	championnat: '',
	    	annee: 0,
	    	entraineurs: [],
	    	entrainements: [{
                    id_1: 0,
			    	jour_1: 0,
			    	heure_debut_1: 0,
			    	heure_fin_1: 0,
			    	gymnase_1: 0
			    }, {
                    id_2: 0,
			    	jour_2: 0,
			    	heure_debut_2: 0,
			        heure_fin_2: 0,
			    	gymnase_2: 0
			    }, {
                    id_3: 0,
			    	heure_debut_3: 0,
			    	jour_3: 0,
			    	heure_fin_3: 0,
			    	gymnase_3: 0
			    }
		    ]
        }
        var notValid = false;
        
        // Appel à la modal
        teamModal.on('shown.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            teamModal.find('.modal-title, .edit-team, .add-team').addClass('hidden');
                        
            for(ch in teamData) {
				if(ch == 'entrainements') {
                    for(i in teamData[ch]) {
                        if(i > 0) {
                            for(ent in teamData[ch][i]) {
                                $(teamModal).find('#'+ ent).selectpicker('val', '');
                                var select = $(teamModal).find('#'+ ent).closest('.row').find('.selectpicker');
                                select.prop('disabled', true);
                                select.selectpicker('refresh');
                                $(teamModal).find('#'+ ent).closest('.row').find('.add-training, .remove-training').addClass('add-training btn-success');
                                $(teamModal).find('#'+ ent).closest('.row').find('.add-training').removeClass('remove-training btn-danger');
                            }
                        }
                    }
                } else {
                    teamModal.find('#'+ ch).selectpicker('val', '');
                }
			}
            
            if(id > 0) {
                teamModal.find('#editTeamLabel, .edit-team').removeClass('hidden');
                $.getJSON(
                    './inc/api/admin/team/get-team.php',
                    {
                        id: id
                    },
                    function (data) {
                        // console.log(data);
                        for(ch in data) {
                            if(ch == 'id') {
                                teamData[ch] = data[ch];
                            } else if(ch == 'entrainements') {
                                if(data[ch].length > 0) {
                                    for(i in data[ch]) {
                                        for(ent in data[ch][i]) {
                                            var j = parseInt(i) + 1;
                                            if(ent != 'id_' + j) {
                                                $(teamModal).find('#'+ ent).selectpicker('val', data[ch][i][ent]);

                                                if(data[ch][i][ent] != 0) {
                                                    var select = $(teamModal).find('#'+ ent).closest('.row').find('.selectpicker');
                                                    select.prop('disabled', false);
                                                    select.selectpicker('refresh');
                                                    $(teamModal).find('#'+ ent).closest('.row').find('.add-training').addClass('remove-training btn-danger');
                                                    $(teamModal).find('#'+ ent).closest('.row').find('.add-training').removeClass('add-training btn-success');
                                                }
                                            } else {
                                                teamData[ch][i][ent] = data[ch][i][ent];
                                            }
                                        }
                                    }
                                }
                            } else {
                                teamModal.find('#'+ ch).selectpicker('val', data[ch]);
                            }
                        }
                    }
                );
            } else {
                teamModal.find('#addTeamLabel, .add-team').removeClass('hidden');
            }
        });
        
        // Gestion des entrainements
        teamModal.find('.add-training').on('click', function(e){
            e.preventDefault();
            
            if($(this).hasClass('add-training')) {
                var select = $(this).closest('.row').find('.selectpicker');
                select.prop('disabled', false);
                select.selectpicker('refresh');
                $(this).toggleClass('add-training remove-training btn-success btn-danger');
            } else {
                var select = $(this).closest('.row').find('.selectpicker');
                select.prop('disabled', true);
                select.selectpicker('val', '');
                select.selectpicker('refresh');
                $(this).toggleClass('add-training remove-training btn-success btn-danger');
            }
        });
        
        // Ajout d'une équipe
        teamModal.find('.add-team').on('click', function(e){
            e.preventDefault();
            
            for(ch in teamData) {
                if(ch == 'entrainements') {
                    for(i in teamData[ch]) {
                        for(ent in teamData[ch][i]) {
                            teamData[ch][i][ent] = $(teamModal).find('#'+ ent).val();
                        }
                    }
                } else {
                    teamData[ch] = $(teamModal).find('#'+ ch).val();
                    if(teamData[ch] == '') {
                        notValid = true;
                    }
                }
            }
           if (!notValid) {
                $.post(
                        './inc/api/admin/team/add-team.php',
                    {
                        'data': teamData
                    },
                    function (data) {
                        console.log(data);
                        if(!data)
                            addUserModal.find('.form-errors').removeClass('hidden');
                        else
                            window.location.href = location.href;
                    }
                );
            }
        });
        
        // Modification d'une équipe
        teamModal.find('.edit-team').on('click', function(e){
            e.preventDefault();
            
            for(ch in teamData) {
                if(ch == 'entrainements') {
                    for(i in teamData[ch]) {
                        for(ent in teamData[ch][i]) {
                            var j = parseInt(i) + 1;
                            if(ent != 'id_' + j) {
                                teamData[ch][i][ent] = $(teamModal).find('#'+ ent).val();
                            }
                        }
                    }
                } else if (ch != 'id') {
                    teamData[ch] = $(teamModal).find('#'+ ch).val();
                    if(teamData[ch] == '') {
                        notValid = true;
                    }
                }
            }
           // console.log(teamData);

           if (!notValid) {               
              $.post(
                  './inc/api/admin/team/edit-team.php',
                  {
                      'data': teamData
                  },
                  function (data) {
                    console.log(data);
                    if(!data)
                        addUserModal.find('.form-errors').removeClass('hidden');
                    else
                        window.location.href = location.href;
                  }
              );
            }
        });

		// Suppression d'une équipe
		equipes.find('.delete-team').on('click', function(e){
            e.preventDefault();
			var supprId = $(this).data('id');

			$.post(
                './inc/api/admin/team/delete-team.php',
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