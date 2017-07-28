
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
            theme: {
                value: '',
                valid: false
            },
            tags: {
                value: '',
                valid: false
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
        
        /* OnChange */
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
                        
            for(ch in actuData) {
				actuModal.find('#'+ ch).selectpicker('val', '');
			}
            
            if(id > 0) {
                actuModal.find('#editMatchLabel, .edit-match').removeClass('hidden');
                actuModal.find('.modal-body').addClass('hidden');
                actuModal.find('.modal-loader').removeClass('hidden');
                
                $.getJSON(
                    './inc/api/admin/calendar/get-match.php',
                    {
                        id: id
                    },
                    function (data) {                        
                        for(ch in data) {
                            
                        }
                        actuModal.find('.modal-loader').addClass('hidden');
                        actuModal.find('.modal-body').removeClass('hidden');
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
                        actuData[ch]['value'] = '';
                        actuData[ch]['valid'] = true;
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
                        actuData[ch]['value'] = '';
                        actuData[ch]['valid'] = true;
                    }
                    if(!actuData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
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
                    /*if(data)
                        window.location.href = location.href;
                    else*/
                        console.log(data);
                }
           );
        });
    }
});