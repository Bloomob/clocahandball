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
            id: {
                value: 0,
                valid: true
            },
            prenom: {
                value: '',
                valid: false
            },
            nom: {
                value: '',
                valid: false
            },
            mail: {
                value: '',
                valid: false
            },
            mot_de_passe: {
                value: '',
                valid: false
            },
            tel_port: {
                value: '',
                valid: false
            },
            num_licence: {
                value: '',
                valid: false
            },
            liste_equipes_favorites: {
                value: '',
                valid: false
            }
        };
        
        
        /*
        * INIT
        */
        
        /*
        * FONCTIONS
        */
        
        function formSelect(modal, data, ch, val) {
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
        profil.find('.edit-profil').on('click', function(e){
            for(ch in data) {
                data[ch]
                if(profil.find('#'+ val).val() != '') {
                    data[ch]['value'] = profil.find('#'+ val).val();
                    data[ch]['valid'] = true;
                } else {
                    data[ch]['value'] = '';
                    data[ch]['valid'] = false;
                }
            }
            $.post(
                './inc/api/profil/edit-profil.php',
                {
                    'data': data,
                    'btn': $(this).data('profil')
                },
                function (data) {
                    if(data)
                        window.location.href = location.href;
                    else
                        console.log(data);
                 }
            );
        });
        
        /* Changer le mot de passe */
        profil.find('.edit-password').on('click', function(e){
            $.post(
                './inc/api/profil/edit-password.php',
                {
                  'data': data
                },
                function (data) {
                    if(data)
                        window.location.href = location.href;
                    else
                        console.log(data);
                 }
            );
        });
        
        /* Modifier mes équipes favorites */
        profil.find('.edit-fav-team').on('click', function(e){
            $.post(
                './inc/api/profil/edit-fav-team.php',
                {
                  'data': data
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