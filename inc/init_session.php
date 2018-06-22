<?php
    session_start();

    // On enregistre notre autoload.
    function chargerClasse($classname)
    {
        require_once('classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');
?>