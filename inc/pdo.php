<?php //fichier de lien avec la base de donée

    try{ // essaie de conncetion avec la base de donnée sinon on affcihe une erreur avec catch on copie collera ceci sauf 
        //les mysql:host dbname "root"=username, ""=psw et on retire errmode uniquement en production et mais on l'utilise en dev pour débug
        // host= url de ma base de donnée
        //dbname= nom de ma base de donnée
        //"root" login mysql
        //"" mot de passe
        $pdo = new PDO("mysql:host=localhost;dbname=agence_voyage","root","",array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
    }

    catch(PDOException $e){
        echo "Erreur de connexion :".$e->getMessage();

    }