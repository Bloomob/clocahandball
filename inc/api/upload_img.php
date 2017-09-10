<?php
    session_start();
    // On enregistre notre autoload.
    function chargerClasse($classname)
    {
        require_once('../../classes/'.$classname.'.class.php');
    }
    spl_autoload_register('chargerClasse');

    // On inclue la page de connexion à la BDD
    include_once("../connexion_bdd_pdo.php");
    include_once("../date.php");

    if(isset($_FILES["image"]["type"])):
        $retour = array('success' => false);
        $pathFile = "../../images/albums/". $annee_actuelle ."_". $annee_suiv;
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["image"]["name"]);
        $file_extension = end($temporary);
        if ((($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/jpeg")
        ) && ($_FILES["image"]["size"] < 1000000) && in_array($file_extension, $validextensions)):
            if ($_FILES["image"]["error"] > 0):
                $retour['message'] = "Code retour : ". $_FILES["file"]["error"];
            else:
                if (file_exists($pathFile ."/". $_FILES["image"]["name"])):
                    $retour['message'] = "Le fichier existe déja";
                else:
                    $sourcePath = $_FILES['image']['tmp_name']; // Storing source path of the file in a variable
                    $targetPath = $pathFile ."/".$_FILES['image']['name']; // Target path where file is to be stored
                    if(!is_dir($pathFile))
                        mkdir($pathFile, 0777);
                    move_uploaded_file($sourcePath, $targetPath) ; // Moving Uploaded file

                    $retour['success'] = true;
                    $retour['path'] = "images/albums/". $annee_actuelle ."_". $annee_suiv. "/".$_FILES['image']['name'];
                    $retour['message'] = "Image uploadée";
                    /*echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                    echo "<br/><b>File Name:</b> " . $_FILES["image"]["name"] . "<br>";
                    echo "<b>Type:</b> " . $_FILES["image"]["type"] . "<br>";
                    echo "<b>Size:</b> " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
                    echo "<b>Temp file:</b> " . $_FILES["image"]["tmp_name"] . "<br>";*/
                endif;
            endif;
        else:
            $retour['message'] = "Taille ou type invalide";
        endif;

        echo json_encode($retour);
        exit;
    endif;
?>