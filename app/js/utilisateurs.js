$(function(){

	/***************************
	******* Utilisateurs *******
	***************************/

	var utilisateurs = $('.admin .utilisateurs');
	if(utilisateurs.length > 0) {
        
        // Ajout d'un utilisateur
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
                valid: true
            },
            num_licence: {
                value: 0,
                valid: true
            },
            mot_de_passe: {
                value: '',
                valid: true
            },
            confirm_mot_de_passe: {
                value: '',
                valid: true
            },
            rang: {
                value: 0,
                valid: true
            }
        };

        $(addUserModal).find('#nom, #prenom').keyup(function(){
            var champ = $(this).attr('id');
            if($(this).val().length < 1) {
                $(this).popover('show');
                $(this).closest('.form-group').addClass('has-error').removeClass('has-success');
                addUserData[champ]['valid'] = false;
            } else {
                $(this).popover('hide');
                $(this).closest('.form-group').removeClass('has-error').addClass('has-success');
                addUserData[champ]['valid'] = true;
            }
        });

        $(addUserModal).find('#mot_de_passe').keyup(function(){
            if($(this).val().length < 5 && $(this).val().length > 0) {
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
            if ($(addUserModal).find('#mot_de_passe').val() !== $(this).val()) {
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
				addUserData[ch]['value'] = $(addUserModal).find('#'+ ch).val();
				if(!addUserData[ch]['valid']) {
					if(formValid) {
						formValid = false;
					}
                    $(addUserModal).find('#'+ ch).popover('show');
                    $(addUserModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                }
            }
            // console.log(addUserData, formValid);
            
            if (formValid) {
                $.post(
                    './inc/api/admin/user/add-user.php',
                    {
                      'data': addUserData
                    },
                    function (data) {
                        console.log(data);
                        if(!data)
                            addUserModal.find('.form-errors').removeClass('hidden');
                        else
                            window.location.href = location.href;
                     }
                );
            } else {
                addUserModal.find('.form-errors').removeClass('hidden');
            }
        });
        
        // Suppression d'un utilisateur
        utilisateurs.find('.delete-user').click(function(e){
			e.preventDefault();
			var supprId = $(this).data('id');

			$.post(
                './inc/api/admin/user/delete-user.php',
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