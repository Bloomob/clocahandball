$(function(){

    /**************************
	******* Categories ********
	**************************/

	var clubs = $('.admin .clubs');
	if(clubs.length > 0) {
        /*
        * VARIABLES
        */
        var clubModal = $('#clubModal');
        var clubData = {
            nom: {
                value: '',
                valid: false
            },
            raccourci: {
                value: '',
                valid: false
            },
            numero: {
                value: '',
                valid: false
            },
            ville: {
                value: '',
                valid: false
            },
            code_postal: {
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
        
        
        function formInputRadio(modal, data, ch) {
            if(modal.find('input[name="'+ ch +'"]:checked').val() != undefined) {
                data[ch] = { value: modal.find('input[name="'+ ch +'"]:checked').val(), valid: true };
            } else {
                data[ch] = { value: '', valid: false };
            }
            if(!data[ch]['valid']) {
                modal.find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                modal.find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }

        function formSelect(modal, data, ch) {
            if(modal.find('#'+ ch).val() != '' && modal.find('#'+ ch).val() != null) {
                data[ch] = { value: modal.find('#'+ ch).val(), valid: true };
            } else {
                data[ch] = { value: '', valid: false };
            }
            if(!data[ch]['valid']) {
                modal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                modal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        function formInput(modal, data, ch) {
            if(modal.find('#'+ ch).val() != '' && modal.find('#'+ ch).val() != null) {
                data[ch] = { value: modal.find('#'+ ch).val(), valid: true };
            } else {
                data[ch] = { value: '', valid: false };
            }
            if(!data[ch]['valid']) {
                modal.find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                modal.find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        
        /* Ajout de categories */
        clubModal.find('.add-club').on('click', function(e){
            e.preventDefault();
            var formValid = true;
            
            for(ch in clubData) {
                if(ch == 'actif') {
                    formInputRadio(clubModal, clubData, ch);
                    
                    if(formValid && !clubData[ch].valid) {
                        formValid = false;
                    }
                } else if(ch == 'numero') {
                    formSelect(clubModal, clubData, ch);
                    
                    if(formValid && !clubData[ch].valid) {
                        formValid = false;
                    }
                } else {
                    formInput(clubModal, clubData, ch);
                    
                    if(formValid && !clubData[ch].valid) {
                        formValid = false;
                    }
                }
            }

            // console.log(clubData, formValid);
            
            if (formValid) {
                $.post(
                    './inc/api/admin/club/add-club.php',
                    {
                      'data': clubData
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