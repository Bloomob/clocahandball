$(function(){

    /**************************
	******* Mon profil ********
	**************************/

    var monProfil = $('.profil');
    if(monProfil.length > 0) {
        /*
        * VARIABLES
        */

        var data = {
            infos: {
                infos_prenom: {
                    value: '',
                    valid: false
                },
                infos_nom: {
                    value: '',
                    valid: false
                },
                infos_email: {
                    value: '',
                    valid: false
                },
                infos_tel: {
                    value: '',
                    valid: true
                },
                infos_num_licence: {
                    value: '',
                    valid: true
                }
            },
            password: {
                infos_password_old: {
                    value: '',
                    valid: false
                },
                infos_password_new: {
                    value: '',
                    valid: false
                },
                infos_password_new_confirm: {
                    value: '',
                    valid: false
                }
            },
            infos_fav_equipe: {
                value: '',
                valid: true
            }
        };


        /*
        * INIT
        */

        /*
        * FONCTIONS
        */

        function formSelect(modal, data, ch, val = '') {
            if(val == '') {
                var val = ch;
            }
            if($(modal).find('#'+ val).val() != '' && $(modal).find('#'+ val).val() != null) {
                data[ch]['value'] = $(modal).find('#'+ val).val();
                data[ch]['valid'] = true;
            } else {
                data[ch]['value'] = '';
                data[ch]['valid'] = false;
            }
            if(!data[ch]['valid']) {
                $(modal).find('#'+ val).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(modal).find('#'+ val).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }

        /* Modifier les infos générales */
        monProfil.find('.edit-profil').on('click', function(e){
            e.preventDefault();
            var profilType = $(this).data('profil');
            
            if(profilType == 'fav-team') {
                formSelect(monProfil, data, 'infos_fav_equipe', 'infos_fav_equipe');
            } else {
                for(ch in data[profilType]) {
                    if(monProfil.find('#'+ ch).val() != '' || data[profilType][ch]['valid']) {
                        data[profilType][ch]['value'] = monProfil.find('#'+ ch).val();
                        data[profilType][ch]['valid'] = true;
                    } else {
                        data[profilType][ch]['value'] = '';
                        data[profilType][ch]['valid'] = false;
                    }
                }
            }
            console.log(data[profilType]);
            $.ajax({
                type: "POST",
                url: "inc/api/profil/edit-profil.php",
                data : {
                   data: data[profilType]
                },
                success: function (data) {
                    /*if(data)
                        window.location.href = location.href;
                    else*/
                    console.log(data);
                }
            });
        });
    }
});