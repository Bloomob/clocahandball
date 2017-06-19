$(function(){
	function connexion() {
        $('#btnConnexion').click(function(e){
            e.preventDefault();
            $('#connexionModal .alert-danger').addClass('hidden');
            let login = $('#login').val();
            let password = $('#password').val();
            console.log(login, password);
            $.post(
                './inc/api/connexion.php',
                {
                    'pseudo': login,
                    'mot_de_passe': password
                },
                function (data) {
                    console.log(data);
                    $('#connexionModal .alert-danger').removeClass('hidden');
                    // $('#connexionModal').modal('hide');
                }
            );
        });
    }
    
	// Globals events
    connexion();
});