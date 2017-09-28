$(function(){

	/***************************
	******* Utilisateurs *******
	***************************/

	var fonctions = $('.admin .fonctions');
	if(fonctions.length > 0) {
        
        // Ajout d'un utilisateur
		var functionModal = $('.admin .fonctions #functionModal');
		var functionData = {
            id: {
                value: 0,
                valid: true
            },
            type: {
                value: '',
                valid: false
            },
            role: {
                value: '',
                valid: false
            },
            id_utilisateur: {
                value: '',
                valid: false
            },
            annee_debut: {
                value: '',
                valid: false
            },
            annee_fin: {
                value: '',
                valid: false
            }
        };
        
        /* Fonctions */
        
        functionModal.find('select').on('show.bs.select', function(e){
            e.preventDefault();
            $(this).popover('hide');
        });
        
        functionModal.find('select').on('hide.bs.select', function(e){
            e.preventDefault();
            
            if($(this).val() == '') {
                $(this).popover('show');
                $(this).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(this).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        });
        
        functionModal.find('#type').on('change', function(e){
            e.preventDefault();
            functionModal.find('.form-group.bureau, .form-group.entraineur, .form-group.arbitre').addClass('hidden');
            
            if($(this).val() == 1) {
                functionModal.find('.form-group.bureau').removeClass('hidden');
            } else if($(this).val() == 4) {
                functionModal.find('.form-group.entraineur').removeClass('hidden');
            } else {
                functionModal.find('.form-group.arbitre').removeClass('hidden');
            }
        });

        functionModal.on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            functionModal.find('.modal-title, .edit-fonction, .add-fonction').addClass('hidden');
            
            for(ch in functionData) {
				functionModal.find('#'+ ch).selectpicker('val', '');
			}
            
            if(id > 0) {
                functionModal.find('#addFunctionLabel, .edit-fonction').removeClass('hidden');
                functionModal.find('.modal-body').addClass('hidden');
                functionModal.find('.modal-loader').removeClass('hidden');
                
                $.getJSON(
                    './inc/api/admin/function/get-function.php',
                    {
                        id: id
                    },
                    function (data) {
                        for(ch in data) {
                            if(ch == 'id') {
                                functionData[ch]['value'] = data[ch];
                            } else {
                                if(ch == 'type') {
                                    functionModal.find('.form-group.bureau, .form-group.entraineur, .form-group.arbitre').addClass('hidden');
            
                                    if(data[ch] == 1) {
                                        functionModal.find('.form-group.bureau').removeClass('hidden');
                                    } else if(data[ch] == 4) {
                                        functionModal.find('.form-group.entraineur').removeClass('hidden');
                                    } else {
                                        functionModal.find('.form-group.arbitre').removeClass('hidden');
                                    }
                                }
                                if(ch == 'role') {
                                    functionModal.find('.role_' + functionModal.find('#type').val()).selectpicker('val', data[ch]);
                                } else {
                                    functionModal.find('#'+ ch).selectpicker('val', data[ch]);
                                }
                            }
                        }
                        functionModal.find('.modal-loader').addClass('hidden');
                        functionModal.find('.modal-body').removeClass('hidden');
                    }
                );
            } else {
                functionModal.find('#editFunctionLabel, .add-fonction').removeClass('hidden');
            }
        });
		
        /* Ajout/Modification de rôle */
		functionModal.find('.add-fonction, .edit-fonction').click(function(e){
            e.preventDefault();
            var formValid = true;
            functionModal.find('select').popover('hide');
	    
			for(ch in functionData) {
                if(ch == 'type') {                    
                    if(functionModal.find('#'+ ch).val() != 0) {
                        functionData[ch] = { value: functionModal.find('#'+ ch).val(), valid: true};
                    } else {
                        functionData[ch] = { value: '', valid: false};
                    }
                    if(!functionData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        functionModal.find('#'+ ch).popover('show');
                        functionModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        functionModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'role') {                    
                    if(functionModal.find('#type').val() != 0 && functionModal.find('.role_'+ functionModal.find('#type').val() +' option:selected').val() != 0) {
                        functionData[ch] = { value: functionModal.find('.role_'+ functionModal.find('#type').val() +' option:selected').val(), valid: true};
                    } else {
                        functionData[ch] = { value: '', valid: false};
                    }
                    if(!functionData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        functionModal.find('.role_'+ functionModal.find('#type').val()).popover('show');
                        functionModal.find('.role_'+ functionModal.find('#type').val()).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        functionModal.find('.role_'+ functionModal.find('#type').val()).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'annee_debut' || ch == 'annee_fin') {
                    if(functionModal.find('#' + ch).val() != 0) {
                        functionData[ch] = { value: functionModal.find('#'+ch).val(), valid: true};
                    } else {
                        functionData[ch] = { value: 0, valid: true};
                    }
                } else if(ch != 'id') {
                    if(functionModal.find('#'+ ch).val() != 0) {
                        functionData[ch] = { value: functionModal.find('#'+ ch).val(), valid: true};
                    } else {
                        functionData[ch] = { value: '', valid: false};
                    }
                    if(!functionData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        functionModal.find('#'+ ch).popover('show');
                        functionModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        functionModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                }
            }
            
            /*console.log(functionData, formValid);
            formValid = false;*/
            
            if (formValid) {
                if($(this).hasClass('add-fonction')) {
                    $.post(
                        './inc/api/admin/function/add-function.php',
                        {
                          'data': functionData
                        },
                        function (data) {
                            if(!data)
                                functionModal.find('.form-errors').removeClass('hidden');
                            else
                                window.location.href = location.href;
                         }
                    );
                } else {
                    $.post(
                        './inc/api/admin/function/edit-function.php',
                        {
                          'data': functionData
                        },
                        function (data) {
                            if(!data)
                                functionModal.find('.form-errors').removeClass('hidden');
                            else
                                window.location.href = location.href;
                         }
                    );
                }
            }
            else {
                functionModal.find('.form-errors').removeClass('hidden');
            }
        });
        
        // Suppression d'un utilisateur
        fonctions.find('.delete-function').click(function(e){
			e.preventDefault();
			var supprId = $(this).data('id');

			$.post(
                './inc/api/admin/function/delete-function.php',
                {
                    'id': supprId
                },
                function (data) {
                    if(data) {
                        window.location.href = location.href;
                    }
                }
	       );
		});
    }
});