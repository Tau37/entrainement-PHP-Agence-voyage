
<?php

require_once("./pdo.php");



if(!empty($_POST['recherche']) && isset($_POST['recherche']))
{
    $recherche = $_POST['recherche'];
    $limite = 5;
    $rechercheBy = "title";
    $rq = "SELECT * FROM vinyles WHERE $rechercheBy LIKE :recherche LIMIT 0,$limite";
    $query = $pdo->prepare($rq);
    $query->bindValue(':recherche', $recherche."%",PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll();
    if (count($result)>0) {
        $result = json_encode($result);
        echo $result;
    } else {
        echo "{}"; // json vide pour retirer l'erreur js
    }
    /* $result = json_encode($result);
    echo $result; */

} else {
    echo "{}"; // json vide pour retirer l'erreur js
}