$(function(){
    /* Connexion */
    $('#btnConnexion').click(function(e){
        e.preventDefault();
        $('#connexionModal .alert-danger').addClass('hidden');
        var login = $('#login').val();
        var password = $('#password').val();
        // console.log(login, password);
        $.post(
            './inc/api/connexion.php',
            {
                'pseudo': login,
                'mot_de_passe': password
            },
            function (data) {
                console.log(data);
                if(!data)
                    $('#connexionModal .alert-danger').removeClass('hidden');
                else
                    window.location.href = 'index.php';
            }
        );
    });
});