
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
                var adversaires = $('#adversaires').val();
                $('.rencontres .rencontre .selectpicker').val(0).selectpicker('refresh');
                for(i in adversaires) {
                    var rencontre = $('.rencontres .rencontre').eq(i);
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
            for(i in adversaires) {
                var rencontre = $('.rencontres .rencontre').eq(i);
                rencontre.removeClass('hidden');
                if(matchData['lieu']['value'] === 0) {
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
        
        /* Ajout de match */
        matchModal.find('.add-match').on('click', function(e){
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
                    var tab = [];
                    $(matchModal).find('.rencontre:not(.hidden) select.'+ ch).each(function(){
                        tab.push($(this).val())
                    });
                    matchData[ch]['value'] = tab.join();
                } else {
                    if($(matchModal).find('#'+ ch).val() != '' && $(matchModal).find('#'+ ch).val() != null) {
                        matchData[ch]['value'] = $(matchModal).find('#'+ ch).val();
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
            console.log(matchData);
            console.log('formValid', formValid);
        });
        
        function btnGroup() {
            
        }
    }
});