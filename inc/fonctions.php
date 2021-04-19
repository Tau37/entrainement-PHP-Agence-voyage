<?php

require_once("./inc/pdo.php");

// Function de requetes MySQL ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function selectAllDestination($order)
{
    global $pdo;
    //$order servira à laisser le chjoix du classement pour les utilisateurs
    //$rq = "SELECT * FROM vinyles ORDER BY :order ASC"; a revoir Lundi
    $rq = "SELECT * FROM location_voyage ORDER BY $order";
    $query = $pdo->prepare($rq);
    //$query->bindValue(":order",$order,PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}



function selectAllDestinationByID($id)
{
    global $pdo;
    //var_dump($id);
    $rq = "SELECT * FROM location_voyage WHERE id=:id";
    $query = $pdo->prepare($rq);
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(); // car on récupére que une valeur
    return $result;
}



// fonction courrante


function verifInput($input, $txtErreur)
{
    global $erreur; // ne pas oublier d'appeler en global erreur pour prendre en compte dans tout les cas de fonction
    //var_dump($input);
    // var_dump($_POST[$input]); à ne pas mettre en prod car il affiche les mdps
    if (strlen($_POST[$input]) > 0) { // vérification que le champs est vide avec un string de moins de 1 caractère
        return trim(strip_tags($_POST[$input]));
    } else {
        // j'ajoute une nouvelle erreur à mon tableau en cas de champs vide 
        $erreur[$input] = $txtErreur;
        // array_push($erreur, $txtErreur);
        // return false;
    }
}

function verifNum($input, $txtErreur, $nb = false)
{
    global $erreur;
    // mon patern en comprendra que des chiffes de 0 à 5 et nb cara
    $pattern = "#[0-9]#";
    //var_dump($input);
    //var_dump($_POST[$input]); // permet de voir les valeurs dans les inputs
    if (preg_match($pattern, $_POST[$input])) {
        return intval($_POST[$input]); // ici 023500000 devient 233500000
    } else {

        $erreur[$input] = $txtErreur;
    }
}


function verifInputRequireType($input, $obligatoire = false, $type = false)
{
    global $erreur;//je récupère le tableau d'erreur
    if (!empty($_POST[$input]) && isset($_POST[$input])) {
        $retour = trim(strip_tags($_POST[$input]));
    } else {
        // je gère ici le champ obligatoire si $obligatoire = true
        $retour="";
        if($obligatoire){
            $retour = "";
            $erreur[$input] = "Le champ $input n'est pas rempli.";
        }

    }
    // je gère ici le type de ma variable à envoyer dans la base
    if ($type && $retour !== "") {
        // Attention : $_POST renverra TOUJOURS des variables en type string
        switch ($type) {
            case 'integer':
                $patern = "@[0-9]@";
                if(!preg_match($patern,$retour)){
                    $erreur[$input] = "Le champ $input n'est pas au bon format.";
                } else {
                    $retour = intval($retour);
                }
                break;
            case 'string':
                $retour = strval($retour);
                break;
            // autres case possibles : array,object,boolean,NULL,...
            default:
                # code...
                $retour = "";
                break;
        }
    }
    return $retour;
}