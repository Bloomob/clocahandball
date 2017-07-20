$(function(){

    /**********************
	******* Tarifs ********
	**********************/

	var tarifs = $('.admin .tarifs');
	if(tarifs.length > 0) {
        /*
        * VARIABLES
        */
        var priceModal = $('#priceModal');
        var priceData = {
            date_naissance: {
                value: 0,
                valid: false
            },
            categorie: {
                value: [],
                valid: false
            },
            prix_old: {
                value: 0,
                valid: false
            },
            condition_old: {
                value: 0,
                valid: false
            },
            annee: {
                value: 0,
                valid: false
            },
            actif: {
                value: 0,
                valid: false
            }

        }
        
        /*
        * INIT
        */
        
        
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
        /*$(priceModal).find('input[name="lieu"]').on('change', function(){
            formInputRadio('lieu');
        });*/
        
        /* Ajout de tarif */
        priceModal.find('.add-tarif').on('click', function(e){
            e.preventDefault();
            var formValid = true;
            
            for(ch in priceData) {
                if(ch == 'actif') {
                    if($(priceModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
                        priceData[ch]['value'] = $(priceModal).find('input[name="'+ ch +'"]:checked').val();
                        priceData[ch]['valid'] = true;
                    } else {
                        priceData[ch]['value'] = '';
                        priceData[ch]['valid'] = false;
                    }
                    if(!priceData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        $(priceModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        $(priceModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                } else {
                    if($(priceModal).find('#'+ ch).val() != '' && $(priceModal).find('#'+ ch).val() != null) {
                        priceData[ch]['value'] = $(priceModal).find('#'+ ch).val();
                        priceData[ch]['valid'] = true;
                    } else {
                        priceData[ch]['value'] = '';
                        priceData[ch]['valid'] = false;
                    }
                    if(!priceData[ch]['valid']) {
                        if(formValid) {
                            formValid = false;
                        }
                        $(priceModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
                    } else {
                        $(priceModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                }
            }

            if (formValid) {
                $.post(
                    './inc/api/admin/price/add-price.php',
                    {
                      'data': priceData
                    },
                    function (data) {
                        if(data)
                            window.location.href = location.href;
                        else
                            console.log(data);
                     }
                );
            }
        });
    }
});