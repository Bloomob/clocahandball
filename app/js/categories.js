$(function(){

    /**************************
	******* Categories ********
	**************************/

	var categories = $('.admin .categories');
	if(categories.length > 0) {
        /*
        * VARIABLES
        */
        var categoryModal = $('#categoryModal');
        var categoryData = {
            categorie: {
                value: '',
                valid: false
            },
            genre: {
                value: '',
                valid: false
            },
            numero: {
                value: '',
                valid: false
            },
            ordre: {
                value: '',
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
            if($(categoryModal).find('input[name="'+ ch +'"]:checked').val() != undefined) {
                categoryData[ch]['value'] = $(categoryModal).find('input[name="'+ ch +'"]:checked').val();
                categoryData[ch]['valid'] = true;
            } else {
                categoryData[ch]['value'] = '';
                categoryData[ch]['valid'] = false;
            }
            if(!categoryData[ch]['valid']) {
                $(categoryModal).find('input[name="'+ ch +'"]').closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(categoryModal).find('input[name="'+ ch +'"]').closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }

        function formSelect(ch) {
            if($(categoryModal).find('#'+ ch).val() != '' && $(categoryModal).find('#'+ ch).val() != null) {
                categoryData[ch]['value'] = $(categoryModal).find('#'+ ch).val();
                categoryData[ch]['valid'] = true;
            } else {
                categoryData[ch]['value'] = '';
                categoryData[ch]['valid'] = false;
            }
            if(!categoryData[ch]['valid']) {
                $(categoryModal).find('#'+ ch).closest('.form-group').addClass('has-error').removeClass('has-success');
            } else {
                $(categoryModal).find('#'+ ch).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        }
        
        /* OnChange */
        /*$(priceModal).find('input[name="lieu"]').on('change', function(){
            formInputRadio('lieu');
        });*/
        
        /* Ajout de categories */
        categoryModal.find('.add-categorie').on('click', function(e){
            e.preventDefault();
            var formValid = true;
            
            for(ch in categoryData) {
                if(ch == 'actif') {
                    formInputRadio(ch);
                } else {
                    formSelect(ch)
                }
            }

            console.log(categoryData);

            if (formValid) {
                $.post(
                    './inc/api/admin/category/add-category.php',
                    {
                      'data': categoryData
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