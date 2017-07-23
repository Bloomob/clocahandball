
$(function(){

    /*************************
	******* Calendrier *******
	*************************/

	var calendrier = $('.admin .calendrier');
    
	if(calendrier.length > 0) {
        /*
        * VARIABLES
        */
        var matchModal = $('#matchModal');
        var matchData = {
            id: {
                value: 0,
                valid: true
            },
            categorie: {
                value: 0,
                valid: false
            },
            competition: {
                value: 0,
                valid: false
            },
            niveau: {
                value: 0,
                valid: false
            },
            date: {
                value: '',
                valid: false
            },
            heure: {
                value: '',
                valid: false
            },
            lieu: {
                value: 0,
                valid: false
            },
            journee: {
                value: 0,
                valid: false
            },
            tour: {
                value: '',
                valid: false
            },
            adversaires: {
                value: [],
                valid: false
            },
            scores_dom: {
                value: '',
                valid: true
            },
            scores_ext: {
                value: '',
                valid: true
            },
            joue: {
                value: '',
                valid: false
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
        });
        
        $('#date_debut').datetimepicker({
            icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-arrow-up",
              down: "fa fa-arrow-down"
            }
        });
        
        $('#date_fin').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-arrow-up",
              down: "fa fa-arrow-down"
            }
        });
        
        $("#date_debut").on("dp.change", function (e) {
            $('#date_fin').data("DateTimePicker").minDate(e.date);
        });
        $("#date_fin").on("dp.change", function (e) {
            $('#date_debut').data("DateTimePicker").maxDate(e.date);
        });
        
        /*
        * FONCTIONS
        */
        
        function formInputRadio(ch) {
            if($(matchModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
                matchData[ch]['value'] = $(matchModal).find('input[name="'+ ch +'"]:checked').val();
                matchData[ch]['valid'] = true;
            } else {
                matchData[ch]['value'] = '';
                matchData[ch]['valid'] = false;
            }
            if(!matchData[ch]['valid']) {
                $(matchModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(matchModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        function formSelect(ch) {
            if($(matchModal).find('#'+ ch).val() != '' && $(matchModal).find('#'+ ch).val() != null) {
                matchData[ch]['value'] = $(matchModal).find('#'+ ch).val();
                matchData[ch]['valid'] = true;
            } else {
                matchData[ch]['value'] = '';
                matchData[ch]['valid'] = false;
            }
            if(!matchData[ch]['valid']) {
                $(matchModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(matchModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        /* OnChange */
        $(matchModal).find('input[name="lieu"]').on('change', function(){
            var oldVal = matchData['lieu']['value'];
            formInputRadio('lieu');
            var newVal = matchData['lieu']['value'];
            
            
            if( !(newVal == 1 && oldVal == 2) && !(newVal == 2 && oldVal == 1)) {
                var adversaires = $(matchModal).find('#adversaires').val();
                $(matchModal).find('.rencontres .rencontre .selectpicker').val(0).selectpicker('refresh');
                for(i in adversaires) {
                    var rencontre = $(matchModal).find('.rencontres .rencontre').eq(i);
                    rencontre.find('.lieu .btn-group').toggleClass('hidden');
                    var equipe1 = rencontre.find('.equipe1 p').text();
                    var equipe2 = rencontre.find('.equipe2 p').text();
                    var score1 = rencontre.find('#score_dom_' + (i+1)).val();
                    var score2 = rencontre.find('#score_ext_' + (i+1)).val();
                    rencontre.find('.equipe1 p').text(equipe2);
                    rencontre.find('.equipe2 p').text(equipe1);
                    rencontre.find('#score_dom_' + (i+1)).val(score2).selectpicker('refresh');
                    rencontre.find('#score_ext_' + (i+1)).val(score1).selectpicker('refresh');
                }
            }
        });
        
        $(matchModal).find('input[name="joue"]').on('change', function(){
            formInputRadio('joue');
        });
        
        $(matchModal).find('#categorie').on('change', function(){
            formSelect('categorie');
        });
        
        $(matchModal).find('#competition').on('change', function(){
            formSelect('competition');
            if($(this).val() == 2 || $(this).val() == 3) {
                $(matchModal).find('.form-group.journee').addClass('hidden');
                $(matchModal).find('.form-group.tour').removeClass('hidden');
            } else {
                $(matchModal).find('.form-group.tour').addClass('hidden');
                $(matchModal).find('.form-group.journee').removeClass('hidden');
            }
        });
        
        $(matchModal).find('#niveau').on('change', function(){
            formSelect('niveau');
        });
        
        $(matchModal).find('#date').on("dp.change", function () {
            var DateTimePicker = $(matchModal).find('#date').data("DateTimePicker").date();
            if(DateTimePicker != '' && DateTimePicker != null) {
                matchData['date']['value'] = moment(DateTimePicker).format('YYYYMMDD');
                matchData['date']['valid'] = true;
                matchData['heure']['value'] = moment(DateTimePicker).format('HHmm');
                matchData['heure']['valid'] = true;
            } else {
                matchData['date']['value'] = '';
                matchData['date']['valid'] = false;
                matchData['heure']['value'] = '';
                matchData['heure']['valid'] = false;
            }
            if(!matchData['date']['valid']) {
                $(matchModal).find('#date').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(matchModal).find('#date').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        });
        
        $(matchModal).find('#journee').on('change', function(){
            formSelect('journee');
        });
        
        $(matchModal).find('#adversaires').on('change', function(){
            formSelect('adversaires');
            
            var adversaires = $(this).val();
            var selectedOptions = $('#adversaires option:selected');
            
            $('.rencontres .rencontre').addClass('hidden');
            $('.rencontres .rencontre .selectpicker').val(0).selectpicker('refresh');
            $('.rencontres .rencontre .lieu .btn').removeClass('active').find('input').prop('checked', false);
            $('.rencontres .rencontre:first-child .lieu .btn').addClass('active').find('input').prop('checked', true);
            
            for(i in adversaires) {
                var rencontre = $('.rencontres .rencontre').eq(i);
                rencontre.removeClass('hidden');
                if(matchData['lieu']['value'] == 0) {
                    rencontre.find('.lieu .btn-group').addClass('hidden');
                    rencontre.find('.equipe1 p').text('Achères');
                    rencontre.find('.equipe2 p').text($(selectedOptions[i]).data('nom'));
                } else {
                    rencontre.find('.lieu .btn-group').removeClass('hidden');
                    rencontre.find('.equipe1 p').text($(selectedOptions[i]).data('nom'));
                    rencontre.find('.equipe2 p').text('Achères');
                }
            }
        });

        /*$(matchModal).find('.lieu .btn').on('click', function(){
            $(matchModal).find('.lieu .btn').removeClass('active').find('input').prop('checked', false);
            $(this).addClass('active').find('input').prop('checked', true);
        });*/
        
        /* Appel à la modal */
        matchModal.on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            matchModal.find('.modal-title, .edit-match, .add-match').addClass('hidden');
                        
            for(ch in matchData) {
				matchModal.find('#'+ ch).selectpicker('val', '');
			}
            
            if(id > 0) {
                matchModal.find('#editMatchLabel, .edit-match').removeClass('hidden');
                matchModal.find('.modal-body').addClass('hidden');
                matchModal.find('.modal-loader').removeClass('hidden');
                
                $.getJSON(
                    './inc/api/admin/calendar/get-match.php',
                    {
                        id: id
                    },
                    function (data) {                        
                        for(ch in data) {
                            if(ch == 'id') {
                                matchData[ch]['value'] = data[ch];
                            } else if(ch == 'lieu') {
                                $(matchModal).find('.lieu .btn').removeClass('active').find('input').prop('checked', false);
                                if(data[ch] == 0)
                                    $('#lieu_dom').parent().addClass('active').find('input').prop('checked', true);
                                else if(data[ch] == 1)
                                    $('#lieu_ext').parent().addClass('active').find('input').prop('checked', true);
                                else
                                    $('#lieu_neu').parent().addClass('active').find('input').prop('checked', true);
                            } else if(ch == 'joue') {
                                $(matchModal).find('.joue .btn').removeClass('active').find('input').prop('checked', false);
                                if(data[ch] == 0)
                                    $('#joue_non').parent().addClass('active').find('input').prop('checked', true);
                                else
                                    $('#joue_oui').parent().addClass('active').find('input').prop('checked', true);
                            } else if(ch == 'date') {
                                var annee = data['date'].toString().substr(0,4);
                                var mois = data['date'].toString().substr(4,2);
                                var jour = data['date'].toString().substr(6,2);
                                
                                if(data['heure'].toString().length == 3) {
                                    var heure = data['heure'].toString().substr(-3,1);
                                    var minute = data['heure'].toString().substr(-2,2);
                                } else {
                                    var heure = data['heure'].toString().substr(-4,2);
                                    var minute = data['heure'].toString().substr(-2,2);
                                }
                                
                                $('#date-val').val(annee + '/' + mois + '/' + jour + ' ' + heure + ':' + minute);
                            } else if(ch == 'adversaires') {
                                if(data[ch].length > 0) {
                                    for(i in data[ch]) {
                                        $(matchModal).find('#'+ ch).selectpicker('val', data[ch][i]);

                                        /*if(data[ch][i][ent] != 0) {
                                            $(teamModal).find('#'+ ent).closest('.row').find('.selectpicker').selectpicker('refresh');
                                        }*/
                                    }
                                }
                            } else {
                                matchModal.find('#'+ ch).selectpicker('val', data[ch]);
                            }
                        }
                        
                        matchModal.find('.modal-loader').addClass('hidden');
                        matchModal.find('.modal-body').removeClass('hidden');
                    }
                );
            } else {
                matchModal.find('#addMatchLabel, .add-match').removeClass('hidden');
            }
        });
        
        /* Ajout/édition de match */
        matchModal.find('.add-match, .edit-match').on('click', function(e){
            e.preventDefault();
            var formValid = true;
            var DateTimePicker = $(matchModal).find('#date').data("DateTimePicker").date();
            
            for(ch in matchData) {
                if(ch == 'lieu' || ch == 'joue') {
                    if($(matchModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
                        matchData[ch]['value'] = $(matchModal).find('input[name="'+ ch +'"]:checked').val();
                        matchData[ch]['valid'] = true;
                    } else {
                        matchData[ch]['value'] = '';
                        matchData[ch]['valid'] = false;
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        $(matchModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        $(matchModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'date') {
                    if(DateTimePicker != '' && DateTimePicker != null) {
                        matchData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
                        matchData[ch]['valid'] = true;
                    } else {
                        matchData[ch]['value'] = '';
                        matchData[ch]['valid'] = false;
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        $(matchModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        $(matchModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'heure') {
                    if(DateTimePicker != '' && DateTimePicker != null) {
                        matchData[ch]['value'] = moment(DateTimePicker).format('HHmm');
                        matchData[ch]['valid'] = true;
                    } else {
                        matchData[ch]['value'] = '';
                        matchData[ch]['valid'] = false;
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                    }
                } else if(ch == 'scores_dom' || ch == 'scores_ext') {
                    var tabScores = [];
                    $(matchModal).find('.rencontre:not(.hidden) select.'+ ch).each(function(){
                        tabScores.push($(this).val())
                    });
                    if(matchData['lieu']['value'] != 0 && tabScores.length > 1) {
                        var index = $(matchModal).find('.lieu .btn').index($(matchModal).find('.lieu .btn.active'));
                        var el = tabScores.splice(index, 1);
                        tabScores.splice(0, 0, el[0]);
                    }
                    matchData[ch]['value'] = tabScores.join();
                } else if(ch != 'id') {
                    if($(matchModal).find('#'+ ch).val() != '' && $(matchModal).find('#'+ ch).val() != null) {
                        if(ch == 'adversaires') {
                            var tabAdv = $(matchModal).find('#'+ ch).val();
                            if(matchData['lieu']['value'] != 0 && tabAdv.length > 1) {
                                var index = $(matchModal).find('.lieu .btn').index($(matchModal).find('.lieu .btn.active'));
                                var el = tabAdv.splice(index, 1);
                                tabAdv.splice(0, 0, el[0]);
                            }
                            matchData[ch]['value'] = tabAdv.join();
                        } else {
                            matchData[ch]['value'] = $(matchModal).find('#'+ ch).val();
                        }
                        matchData[ch]['valid'] = true;
                    } else {
                        if((ch == 'tour' && !matchData['journee']['valid']) || (ch == 'journee' && !matchData['tour']['valid'])) {
                            matchData[ch]['value'] = '';
                            matchData[ch]['valid'] = false;
                        } else {
                            matchData[ch]['valid'] = true;
                        }
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        $(matchModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        $(matchModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                }
            }
            /*console.log(matchData);
            console.log('formValid', formValid);*/

            if (formValid) {
                if($(this).hasClass('add-match')) {
                    $.post(
                        './inc/api/admin/calendar/add-match.php',
                        {
                          'data': matchData
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
                        './inc/api/admin/calendar/edit-match.php',
                        {
                          'data': matchData
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
        calendrier.find('.delete-match').on('click', function(e){
            e.preventDefault();
            var supprId = $(this).data('id');

            $.post(
                './inc/api/admin/calendar/delete-match.php',
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