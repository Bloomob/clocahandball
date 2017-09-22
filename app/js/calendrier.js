

$(function(){

    /*************************
	******* Calendrier *******
	*************************/

	var calendrier = $('.admin .calendrier');
    
	if(calendrier.length > 0) {
        /*
        * VARIABLES
        */
        var filtreModal = $('#filterModal');
        var matchModal = $('#matchModal');
        var leagueModal = $('#leagueModal');
        var filtreData = {
            categorie: {
                value: '',
                valid: true
            },
            competition: {
                value: '',
                valid: true
            },
            date_debut: {
                value: 0,
                valid: true
            },
            date_fin: {
                value: 0,
                valid: true
            },
            joue: {
                value: 0,
                valid: true
            }
        };
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
        var leagueData = {
            categorie: {
                value: '',
                valid: false
            },
            competition: {
                value: '',
                valid: false
            },
            niveau: {
                value: '',
                valid: false
            },
            aller_retour: {
                value: 0,
                valid: true
            },
            rencontres: [
                {
                    journee: {
                        value: 1,
                        valid: true
                    },
                    adversaires: {
                        value: [],
                        valid: false
                    },
                    scores_dom: {
                        value: '',
                        valid: false
                    },
                    scores_ext: {
                        value: '',
                        valid: false
                    },
                    lieu: {
                        value: 0,
                        valid: true
                    },
                    date: {
                        value: '',
                        valid: false
                    },
                    heure: {
                        value: '',
                        valid: false
                    },
                    joue: {
                        value: '',
                        valid: false
                    }
                }
            ]
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

        $('.date-aller .date, .date-retour .date').datetimepicker({
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
        
        function formMatchInputRadio(ch) {
            if(matchModal.find('input[name="'+ ch +'"]:checked').val() != undefined) {
                matchData[ch]['value'] = matchModal.find('input[name="'+ ch +'"]:checked').val();
                matchData[ch]['valid'] = true;
            } else {
                matchData[ch]['value'] = '';
                matchData[ch]['valid'] = false;
            }
            if(!matchData[ch]['valid']) {
                matchModal.find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                matchModal.find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        function formMatchSelect(ch) {
            if(matchModal.find('#'+ ch).val() != '' && matchModal.find('#'+ ch).val() != null) {
                matchData[ch]['value'] = matchModal.find('#'+ ch).val();
                matchData[ch]['valid'] = true;
            } else {
                matchData[ch]['value'] = '';
                matchData[ch]['valid'] = false;
            }
            if(!matchData[ch]['valid']) {
                matchModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                matchModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }

        function formLeagueInputRadio(el, data, ch, val = '') {
            if(val == '') {
                val = ch;
            }
            if(el.find('input[name="'+ val +'"]:checked').val() != undefined) {
                data[ch]['value'] = el.find('input[name="'+ val +'"]:checked').val();
                data[ch]['valid'] = true;
            } else {
                data[ch]['value'] = '';
                data[ch]['valid'] = false;
            }
            if(!data[ch]['valid']) {
                el.find('input[name="'+ val +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                el.find('input[name="'+ val +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        function formLeagueSelect(el, data, ch, val = '') {
            if(val == '') {
                val = ch;
            }
            if(el.find('#'+ val).val() != '' && el.find('#'+ val).val() != null) {
                data[ch]['value'] = el.find('#'+ val).val();
                data[ch]['valid'] = true;
            } else {
                data[ch]['value'] = '';
                data[ch]['valid'] = false;
            }
            if(!data[ch]['valid']) {
                el.find('#'+ val).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                el.find('#'+ val).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        /* OnChange */
        matchModal.find('input[name="lieu"]').on('change', function(){
            var oldVal = matchData['lieu']['value'];
            formMatchInputRadio('lieu');
            var newVal = matchData['lieu']['value'];
            
            
            if( !(newVal == 1 && oldVal == 2) && !(newVal == 2 && oldVal == 1)) {
                var adversaires = matchModal.find('#adversaires').val();
                matchModal.find('.rencontres .rencontre .selectpicker').val(0).selectpicker('refresh');
                for(i in adversaires) {
                    var rencontre = matchModal.find('.rencontres .rencontre').eq(i);
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
        
        matchModal.find('input[name="joue"]').on('change', function(){
            formMatchInputRadio('joue');
        });
        
        matchModal.find('#categorie').on('change', function(){
            formMatchSelect('categorie');
        });
         
        matchModal.find('#competition').on('change', function(){
            formMatchSelect('competition');
            if($(this).val() == 2 || $(this).val() == 3) {
                matchModal.find('.form-group.journee').addClass('hidden');
                matchModal.find('.form-group.tour').removeClass('hidden');
            } else {
                matchModal.find('.form-group.tour').addClass('hidden');
                matchModal.find('.form-group.journee').removeClass('hidden');
            }
        });
        
        matchModal.find('#niveau').on('change', function(){
            formMatchSelect('niveau');
        });
        
        matchModal.find('#date').on("dp.change", function () {
            var DateTimePicker = matchModal.find('#date').data("DateTimePicker").date();
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
                matchModal.find('#date').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                matchModal.find('#date').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        });
        
        matchModal.find('#journee').on('change', function(){
            formMatchSelect('journee');
        });
        
        matchModal.find('#adversaires').on('change', function(){
            formMatchSelect('adversaires');
            
            var adversaires = $(this).val();
            var selectedOptions = $('#adversaires option:selected');
            
            matchModal.find('.rencontres .rencontre').addClass('hidden');
            matchModal.find('.rencontres .rencontre .selectpicker').val(0).selectpicker('refresh');
            matchModal.find('.rencontres .rencontre .lieu .btn').removeClass('active').find('input').prop('checked', false);
            matchModal.find('.rencontres .rencontre:first-child .lieu .btn').addClass('active').find('input').prop('checked', true);
            
            for(i in adversaires) {
                var rencontre = matchModal.find('.rencontres .rencontre').eq(i);
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

        /*matchModal.find('.lieu .btn').on('click', function(){

            matchModal.find('.lieu .btn').removeClass('active').find('input').prop('checked', false);
            $(this).addClass('active').find('input').prop('checked', true);
        });*/
        
        /* Filtrer */
        filtreModal.find('.filter-match').on('click', function(e) {
            e.preventDefault();
            var formValid = true;

            for(ch in filtreData) {
                if(ch == "categorie" || ch == "competition") {
                    if(filtreModal.find('#'+ ch).val() != '' && filtreModal.find('#'+ ch).val() != null) {
                        filtreData[ch]['value'] = filtreModal.find('#'+ ch).val();
                    }
                    if(!filtreData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        filtreModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        filtreModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == "joue") {
                    if(filtreModal.find('input[name="'+ ch +'"]:checked').val() != undefined) {
                        filtreData[ch]['value'] = filtreModal.find('input[name="'+ ch +'"]:checked').val();
                    }
                    if(!filtreData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        filtreModal.find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        filtreModal.find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else {
                    var DateTimePicker = filtreModal.find('#' + ch).data("DateTimePicker").date();
                    
                    if(DateTimePicker != '' && DateTimePicker != null) {
                        filtreData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
                    }
                    if(!filtreData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        filtreModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        filtreModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                }
            }
            
            // console.log(filtreData);
            $('#formFilter').submit();
        });
        
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
                                matchModal.find('.lieu .btn').removeClass('active').find('input').prop('checked', false);
                                if(data[ch] == 0)
                                    $('#lieu_dom').parent().addClass('active').find('input').prop('checked', true);
                                else if(data[ch] == 1)
                                    $('#lieu_ext').parent().addClass('active').find('input').prop('checked', true);
                                else
                                    $('#lieu_neu').parent().addClass('active').find('input').prop('checked', true);
                            } else if(ch == 'joue') {
                                matchModal.find('.joue .btn').removeClass('active').find('input').prop('checked', false);
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
                                matchModal.find('#date-val').val(jour +'/'+ mois +'/'+ annee +' '+ heure +':'+ minute);
                                matchData['date'] = { value: annee + mois + jour, valid: true };
                                matchData['heure'] = { value: heure + minute, valid: true };
                            } else if(ch == 'adversaires') {
                                var tabAdv = data[ch].split(',');
                                var tabScoresDom = data['scores_dom'].split(',');
                                var tabScoresExt = data['scores_ext'].split(',');
                                if(tabAdv.length > 0) {
                                    for(i in tabAdv) {
                                        matchModal.find('#'+ ch).selectpicker('val', tabAdv[i]);
                                        var selectedOptions = matchModal.find('#'+ ch +' option:selected');
                                        var rencontre = matchModal.find('.rencontres .rencontre').eq(i);
                                        rencontre.removeClass('hidden');

                                        if(data['lieu']['value'] == 0) {
                                            rencontre.find('.lieu .btn-group').addClass('hidden');
                                            rencontre.find('.equipe1 p').text('Achères');
                                            rencontre.find('.equipe2 p').text($(selectedOptions[i]).data('nom'));
                                        } else {
                                            rencontre.find('.lieu .btn-group').removeClass('hidden');
                                            rencontre.find('.equipe1 p').text($(selectedOptions[i]).data('nom'));
                                            rencontre.find('.equipe2 p').text('Achères');
                                        }
                                        rencontre.find('#score_dom_' + parseInt(i + 1)).selectpicker('val', tabScoresDom[i]);
                                        rencontre.find('#score_ext_' + parseInt(i + 1)).selectpicker('val', tabScoresExt[i]);
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
            var DateTimePicker = matchModal.find('#date').data("DateTimePicker").date();
            
            for(ch in matchData) {
                if(ch == 'lieu' || ch == 'joue') {
                    if(matchModal.find('input[name="'+ ch +'"]:checked').val() != undefined) {
                        matchData[ch]['value'] = matchModal.find('input[name="'+ ch +'"]:checked').val();
                        matchData[ch]['valid'] = true;
                    } else {
                        matchData[ch]['value'] = '';
                        matchData[ch]['valid'] = false;
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        matchModal.find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        matchModal.find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'date') {
                    if(matchData['id']['value'] != 0) {
                        if(DateTimePicker != '' && DateTimePicker != null) {
                            matchData[ch]['value'] = moment(DateTimePicker).format('YYYYMMDD');
                            matchData[ch]['valid'] = true;
                        }
                    } else {
                        matchData[ch]['value'] = '';
                        matchData[ch]['valid'] = false;
                    }
                    if(!matchData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        matchModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        matchModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else if(ch == 'heure') {
                    if(matchData['id']['value'] != 0) {
                        if(DateTimePicker != '' && DateTimePicker != null) {
                            matchData[ch]['value'] = moment(DateTimePicker).format('HHmm');
                            matchData[ch]['valid'] = true;
                        }
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
                    matchModal.find('.rencontre:not(.hidden) select.'+ ch).each(function(){
                        tabScores.push($(this).val())
                    });
                    if(matchData['lieu']['value'] != 0 && tabScores.length > 1) {
                        var index = matchModal.find('.lieu .btn').index(matchModal.find('.lieu .btn.active'));
                        var el = tabScores.splice(index, 1);
                        tabScores.splice(0, 0, el[0]);
                    }
                    matchData[ch]['value'] = tabScores.join();
                } else if(ch != 'id') {
                    if(matchModal.find('#'+ ch).val() != '' && matchModal.find('#'+ ch).val() != null) {
                        if(ch == 'adversaires') {
                            var tabAdv = matchModal.find('#'+ ch).val();
                            if(matchData['lieu']['value'] != 0 && tabAdv.length > 1) {
                                var index = matchModal.find('.lieu .btn').index(matchModal.find('.lieu .btn.active'));
                                var el = tabAdv.splice(index, 1);
                                tabAdv.splice(0, 0, el[0]);
                            }
                            matchData[ch]['value'] = tabAdv.join();
                        } else {
                            matchData[ch]['value'] = matchModal.find('#'+ ch).val();
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
                        matchModal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        matchModal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
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

        leagueModal.find('input[name="aller_retour"]').on('change', function(){
            formLeagueInputRadio(leagueModal, leagueData, 'aller_retour');
            
            var rencontre = leagueModal.find('.rencontres .rencontre');
            rencontre.each(function(index) {
                if(leagueData['aller_retour']['value'] == 1) {
                    $(this).find('.journee-retour, .scores-retour, .date-retour, .joue-retour').removeClass('hidden');
                    var num_journee_retour = index + 1 + rencontre.length;
                    $(this).find('.journee-retour .form-control').text(num_journee_retour);
                } else {
                    $(this).find('.journee-retour, .scores-retour, .date-retour, .joue-retour').addClass('hidden');
                }
            });
        });

        leagueModal.find('.ajout .add-journee').on('click', function(e) {
            e.preventDefault();

            leagueModal.find('.rm-journee').removeClass('hidden');
            var rencontre = leagueModal.find('.rencontres .rencontre');
            var clone = rencontre.eq(0).clone();
            var nbr = rencontre.length;

            clone.find('.bootstrap-select').replaceWith(function() {
                return $('select', this);
            });
            clone.find('.lieu input').each( function() {
                var name_lieu = $(this).attr('name');
                var id_lieu = $(this).attr('id');
                $(this).attr('name', name_lieu.substr(0, name_lieu.length-1) + nbr);
                $(this).attr('id', id_lieu.substr(0, id_lieu.length-1) + nbr);
            });
            
            clone.find('.joue-aller input').each( function() {
                var name_joue_aller = $(this).attr('name');
                var id_joue_aller = $(this).attr('id');
                $(this).attr('name', name_joue_aller.substr(0, name_joue_aller.length-1) + nbr);
                $(this).attr('id', id_joue_aller.substr(0, id_joue_aller.length-1) + nbr);
            });
            
            clone.find('.joue-retour input').each( function() {
                var name_joue_retour = $(this).attr('name');
                var id_joue_retour = $(this).attr('id');
                $(this).attr('name', name_joue_retour.substr(0, name_joue_retour.length-1) + nbr);
                $(this).attr('id', id_joue_retour.substr(0, id_joue_retour.length-1) + nbr);
            });

            clone.find('.selectpicker').selectpicker();
            clone.find('.lieu .btn, .joue-aller .btn, .joue-retour .btn').removeClass('active').find('input').prop('checked', false);
            clone.find('#lieu_dom_'+ nbr +', #joue_aller_non_'+ nbr +', #joue_retour_non_'+ nbr).parent().addClass('active').find('input').prop('checked', true);
            clone.find('#date-aller-val, #date-retour-val').val('');
            clone.find('.date-aller .date, .date-retour .date').datetimepicker({
                icons: {
                  time: "fa fa-clock-o",
                  date: "fa fa-calendar",
                  up: "fa fa-arrow-up",
                  down: "fa fa-arrow-down"
                }
            });
            leagueModal.find('.rencontres').append(clone);

            rencontre = leagueModal.find('.rencontres .rencontre');
            rencontre.each(function(index) {
                $(this).find('.journee-aller .form-control').text(index + 1);
                $(this).find('.journee-retour .form-control').text(index + 1 + rencontre.length);
            });
        });

        leagueModal.find('.ajout .rm-journee').on('click', function(e) {
            e.preventDefault();
            leagueModal.find('.rencontres .rencontre').last().remove();

            var rencontre = leagueModal.find('.rencontres .rencontre');
            rencontre.each(function(index) {
                $(this).find('.journee-aller .form-control').text(index + 1);
                $(this).find('.journee-retour .form-control').text(index + 1 + rencontre.length);
            });
            if(rencontre.length == 1) {
                leagueModal.find('.rm-journee').addClass('hidden');
            }

        });
        
        /* Ajout de championnat */
        leagueModal.find('.add-league').on('click', function(e) {
            e.preventDefault();
            var formValid = true;

            for(ch in leagueData) {
                if(ch == 'rencontres') {
                    var rencontreData = leagueData.rencontres[0];
                    leagueData.rencontres = [];
                    leagueModal.find('.rencontres .rencontre').each(function(index) {
                        var num = index + 1;
                        var dataAller = jQuery.extend(true, {}, rencontreData);
                        dataAller.journee.value = num;
                            
                        for(i in dataAller) {
                            if(i == 'adversaires') {
                                formLeagueSelect($(this), dataAller, i);
                            } else if(i == 'lieu') {
                                formLeagueInputRadio($(this), dataAller, i, 'lieu_'+ index);
                            }  else if(i == 'joue') {
                                formLeagueInputRadio($(this), dataAller, i, 'joue_aller_'+ index);
                            } else if(i == 'scores_dom') {
                                formLeagueSelect($(this), dataAller, i, 'score_dom_aller');
                            } else if(i == 'scores_ext') {
                                formLeagueSelect($(this), dataAller, i, 'score_ext_aller');
                            } else if(i == 'date') {
                                var dateAller = $(this).find('#date_aller').data("DateTimePicker").date();
                                
                                if(dateAller != '' && dateAller != null) {
                                    dataAller.date = { value: moment(dateAller).format('YYYYMMDD'), valid: true };
                                    dataAller.heure = { value: moment(dateAller).format('HHmm'), valid: true };
                                } else {
                                    dataAller.date = { value: '', valid: false };
                                    dataAller.heure = { value: '', valid: false };
                                }
                                if(!dataAller.date.valid) {
                                    if(formValid) {
                                        formValid = false;
                                    }
                                    $(this).find('#date_aller').closest('.form-group').addClass('has-error').removeClass('has-success');
                                } else {
                                    $(this).find('#date_aller').closest('.form-group').removeClass('has-error').addClass('has-success');
                                }
                            }
                        }
                        leagueData.rencontres.push(dataAller);

                        if(leagueData.aller_retour.value) {
                            var nbrRencontre = leagueModal.find('.rencontres .rencontre').length;
                            var dataRetour = jQuery.extend(true, {}, rencontreData);
                            dataRetour.journee.value = index + 1 + nbrRencontre;
                            dataRetour.adversaires.value = dataAller.adversaires.value;
                            dataRetour.lieu.value = (dataAller.lieu.value == "1") ? "0" : "1";
                            
                            for(i in dataRetour) {
                                if(i == 'joue') {
                                    formLeagueInputRadio($(this), dataRetour, i, 'joue_retour_'+ index);
                                } else if(i == 'scores_dom') {
                                    formLeagueSelect($(this), dataRetour, i, 'score_dom_retour');
                                } else if(i == 'scores_ext') {
                                    formLeagueSelect($(this), dataRetour, i, 'score_ext_retour');
                                } else if(i == 'date') {
                                    var dateRetour = $(this).find('#date_retour').data("DateTimePicker").date();
                            
                                    if(dateRetour != '' && dateAller != null) {
                                        dataRetour.date = { value: moment(dateRetour).format('YYYYMMDD'), valid: true };
                                        dataRetour.heure = { value: moment(dateRetour).format('HHmm'), valid: true };
                                    } else {
                                        dataRetour.date = { value: '', valid: false };
                                        dataRetour.heure = { value: '', valid: false };
                                    }
                                    if(!dataRetour.date.valid) {
                                        if(formValid) {
                                            formValid = false;
                                        }
                                        $(this).find('#date_retour').closest('.form-group').addClass('has-error').removeClass('has-success');
                                    } else {
                                        $(this).find('#date_retour').closest('.form-group').removeClass('has-error').addClass('has-success');
                                    }
                                }
                            }
                            leagueData.rencontres.push(dataRetour);
                        }
                    });

                    /*for(var i = 0; i < nbr; i++) {
                        var lieu = 
                        var adversaires = rencontre.get(i).find('#adversaires').val();
                        
                        for(ch2 in leagueData[ch]) {
                            if(ch2 == 'lieu') {

                            }
                        }
                        if(leagueData['aller_retour']['value'] == 1) {

                        }
                    }*/
                } else if(ch == 'aller_retour') {
                    formLeagueInputRadio(leagueModal, leagueData, ch);
                } else {
                    formLeagueSelect(leagueModal, leagueData, ch);
                }
            }
            console.log(leagueData, formValid);
            
            if (formValid) {
                if($(this).hasClass('add-league')) {
                    $.post(
                        './inc/api/admin/calendar/add-league.php',
                        {
                          'data': leagueData
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
                        './inc/api/admin/calendar/edit-league.php',
                        {
                          'data': matchData
                        },
                        function (data) {
                            /*if(data)
                                window.location.href = location.href;
                            else*/
                                console.log(data);
                         }
                    );
                }
            }
        });

        // Suppression d'un match
        calendrier.find('.delete-match').on('click', function(e){
            e.preventDefault();
            var supprId = $(this).data('id');

            $.post(
                './inc/api/admin/calendar/delete-match.php',
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