<?php // partie sécurité du formulaire
//pour executer des requetes mysql j'ai besoin dans ce fichier d'appeler ma connexion à la base de donnée
//require_once("pdo.php"); //appele une fois le test de connection à la base de donnée 
//session_start();
require_once("./inc/fonctions.php");
//protectUrl("role_admin");

//resize  des imgages
require_once("./vendor/autoload.php");
use Gumlet\ImageResize;

$erreur = [];

var_dump($_FILES);
var_dump($_POST);

if (!empty($_POST)) {

    // Gestion des données POST

    // vérification de tout les champs du formulaires
    $titre = verifInputRequireType("titre",true,"string");
    $description = verifInputRequireType("description",true,"string"); 
    $ville = verifInputRequireType("ville",true,"string"); 
    $pays = verifInputRequireType("pays",true,"string"); 
    $prixParPersonne = verifInputRequireType("prixParPersonne",true,"string"); 
    $distanceDepuisParis = verifInputRequireType("distanceDepuisParis",false,"string"); 
    $typeDePension = verifInputRequireType("typeDePension",true,"string"); 
    $dateDeDepart = verifInputRequireType("dateDeDepart",false,""); 
    $dateDeRetour = verifInputRequireType("dateDeRetour",false,""); 
    $dateDeRetour = verifInputRequireType("dateDeRetour",false,""); 


    // Gestion des données FILES
    // Gestion de IMG // tmp_name c'est le fichier temporaire avant d'entré dans la base de donnée
    if ($_FILES['photo']['size'] > 0 && $_FILES['photo']['error'] === 0) {
        if ($_FILES['photo']['type'] === "image/png" || $_FILES['photo']['type'] === "image/jpeg" || $_FILES['photo']['type'] === "image/jpg" || $_FILES['photo']['type'] === "image/gif" || $_FILES['photo']['type'] === "image/webp") {
            $photo = $_FILES["photo"]["tmp_name"];
        } /*else if ($_FILES['photo']['type'] === 'image/jpeg') {
            $photo = $_FILES['photo']['tmp_name'];
        } */ else {
            $erreur["photo"] = "Le fichier image n'est pas au bon format.";
            //array_push($erreur, "Le fichier image n'est pas au bon format.");
        }
    } else {
        $erreur["photo"] = "Le champ photo est vide";
        //array_push($erreur, "Le champ photo est vide";
    }

    var_dump($erreur); // affiche le tableau d'erreur

    // je vérifie que mon tableau d'erreur soit vide
    if (count($erreur) === 0) {
        $photoName = $_FILES["photo"]["name"];
        // insertion en base
        $rq = "SELECT id FROM location_voyage WHERE photo = :photoName";
        $query = $pdo->prepare($rq); //pdo variable prédéfini
        $query->bindValue(':photoName', $photoName, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(); // vérifie que le fichier photo n'est pas deja dans la base de donnée fetch recrache un tableau lisible par php

        if (!$result) {

            // $rq = "INSERT INTO location_voyage(titre)
            // VALUES 
            // (:titre)";
            var_dump("");
            $rq = "INSERT INTO location_voyage(titre,description,ville,pays,prix_par_personne,distance_depuis_paris,type_de_pension,date_de_depart,date_de_retour,photo)
            VALUES 
            (:titre,:description,:ville,:pays,:prix_par_personne,:distance_depuis_paris,:type_de_pension,:date_de_depart,:date_de_retour,:photo)"; // rq = requete
            $query = $pdo->prepare($rq);
            $query->bindValue(':titre', $titre, PDO::PARAM_STR);
            $query->bindValue(':description', $description, PDO::PARAM_STR);
            $query->bindValue(':ville', $ville, PDO::PARAM_STR);
            $query->bindValue(':pays', $pays, PDO::PARAM_STR);
            $query->bindValue(':prix_par_personne', $prixParPersonne, PDO::PARAM_INT);
            $query->bindValue(':distance_depuis_paris', $distanceDepuisParis, PDO::PARAM_INT);
            $query->bindValue(':type_de_pension', $typeDePension, PDO::PARAM_STR);
            $query->bindValue(':date_de_depart', $dateDeDepart, PDO::PARAM_STR);
            $query->bindValue(':date_de_retour', $dateDeRetour, PDO::PARAM_STR);
            $query->bindValue(':photo', $photoName, PDO::PARAM_STR);
            $query->execute();
            // j'upload mes fichier dans leur fichier de destination
            move_uploaded_file($photo, "./assets/photo/" . $_FILES["photo"]["name"]);
            // resize
            $newImg = new ImageResize("./assets/photo/" . $_FILES["photo"]["name"]);
            $newImg->resizeToWidth(200);
            $newImg->save("./assets/photo/" . $_FILES["photo"]["name"]);
            $erreur["success"] = "Votre demande à bien été enregistré et votre photo est bien enregistré!";
            $erreur = json_encode($erreur); // renvoie les infos en json
            echo $erreur; // écris le jason en echo pour parler avec formulaireSend.js
            // messsage sympathiique
            header("Location:./formulaire.php");
        } else {
            $erreur["photo"] = "Cette photo existe déjà";
            //array_push($erreur, "Ce titre existe déjà");
            // erreur utilisateur
            //$erreur = json_encode($erreur); // pour discuter avec le js formulaire Send.js
            //echo $erreur;
            $erreur = serialize($erreur); // transforme un tableau en chaine de caratère
            var_dump($erreur);
            header("Location:./formulaire?er=$erreur");
        }
    } else {
        //$er ="il y a une erreur"; plus nécessaire c'est pour tester si on vois une erreur en remplaçant $erreur ici header("Location:../formulaire?er=$erreur");
        $erreur = serialize($erreur); // transforme un tableau en chaine de caratère
        //$erreur = unserialize($erreur);
        header("Location:./formulaire?er=$erreur");

    }
}

    // $_FILES toujours avec S permet de stocker les fichiers uploadé (input type file)
    // var_dump($_FILES); // super global permet de récupéré les fichiers envoyé  dans le formulaire 
    // print_r($_POST); // super global utilisé pour récupéré les valeurs de du formulaire tout autres données que fichier
    // echo $_POST["title"];


// si les int dans erreurs sont supérieur à 0 l'action à raté 

