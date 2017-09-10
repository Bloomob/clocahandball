$(function(){
    /* Connexion */
    $('#btnConnexion').click(function(e){
        e.preventDefault();
        $('#connexionModal .alert-danger').addClass('hidden');
        var mail = $('#mail').val();
        var password = $('#password').val();
        // console.log(login, password);
        if(mail != "" && password != "") {
            $.post(
                './inc/api/connexion.php',
                {
                    'mail': mail,
                    'mot_de_passe': password
                },
                function (data) {
                    if(!data)
                        $('#connexionModal .alert-danger').removeClass('hidden');
                    else
                        window.location.href = 'index.php';
                }
            );
        }
    });
    
    /* Inscription */
    var inscriptionModal = $('#inscriptionModal');
    if(inscriptionModal.length > 0) {
        var formValid = false;
        
        inscriptionModal.find('#nom, #prenom, #mail').on('keyup blur', function(){
            if($(this).val().length > 0) {
                $(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				formValid = true;
			} else {
                $(this).popover('show');
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				formValid = false;
			}
        });
        
        inscriptionModal.find('#mot_de_passe').on('keyup', function(){
            if($(this).val().length > 5) {
                $(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				formValid = true;
			} else {
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				formValid = false;
			}
        }).on('blur', function(){
            if($(this).val().length > 5) {
                $(this).popover('hide');
			} else {
                $(this).popover('show');
			}
        });
        
        inscriptionModal.find('#confirm_mot_de_passe').on('keyup', function(){
            if($(this).val() === $('#mot_de_passe').val()) {
                $(this).popover('hide');
				$(this).closest('.form-group').removeClass('has-error').addClass('has-success');
				formValid = true;
			} else {
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
				formValid = false;
			}
        }).on('blur', function(){
            if($(this).val() === $('#mot_de_passe').val()) {
                $(this).popover('hide');
			} else {
                $(this).popover('show');
			}
        });
        
        inscriptionModal.find('#btnInscription').click(function(e){
            e.preventDefault();
            $('#connexionModal .alert-danger').addClass('hidden');

            var data = {
                nom: $('#nom').val(),
                prenom: $('#prenom').val(),
                mail: $('#mail').val(),
                num_licence: $('#num_licence').val(),
                password: $('#mot_de_passe').val()
            };

            console.log(data);
            if(formValid) {
                $.post(
                    './inc/api/inscription.php',
                    {
                        'data': data
                    },
                    function (data) {
                        console.log(data);
                        /*if(!data)
                            $('#connexionModal .alert-danger').removeClass('hidden');
                        else
                            window.location.href = 'index.php';*/
                    }
                );
            }
        });
    }

    /* Calendrier dynamique */

	var maDate = new Date();
    $('.month').hide();
	var currentYear = maDate.getFullYear();
	var activeYear = currentYear;
	var currentMonth = parseInt(maDate.getMonth(), 10) + 1;
	if(currentMonth < 7) {
		currentYear--;
	}
	
	$('#month'+currentMonth).show();
	$('.year a#linkYear'+activeYear).addClass('active');
	$('.months a#linkMonth'+currentMonth).addClass('active');
	
	$('.months a').click(function() {
		var month = $(this).attr('id').replace('linkMonth','');
		if(month != currentMonth) {
			if(month < 7) var year = parseInt(currentYear, 10) + 1; else var year = currentYear;
			$('#month'+currentMonth).slideUp();
			$('#month'+month).slideDown();
			$('.year a').removeClass('active');
			$('.year a#linkYear'+year).addClass('active');
			$('.months a').removeClass('active');
			$('.months a#linkMonth'+month).addClass('active');
			currentMonth = month;
		}
		return false;
	});
	
	$('.year a').click(function() {
		return false;
	});

    /*$( ".periods td" ).click(function( event ) {
        if($( event.target ).is( '.events span' )) {
            location.href = "evenements.php?date="+$( this ).find('.laDate').text();
        }
    });*/
});