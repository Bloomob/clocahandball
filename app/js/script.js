$(function(){
    
	function connexion() {
        $('#btnConnexion').click(function(e){
            e.preventDefault();
            let login = $('#login').val();
            let password = $('#password').val();
            console.log(login, password);
            $.post(
                // '../../inc/api/connexion.php',
                '/',
                {
                    'login': login,
                    'password': password
                },
                function (data) {
                    console.log(data);
                }
            );
        });
    }
    
	// Globals events
    connexion();
});