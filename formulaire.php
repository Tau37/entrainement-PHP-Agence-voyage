<?php


$erreur = [];
if (!empty($_GET)) {
    //var_dump(unserialize($_GET['er']));
    $erreur = unserialize($_GET['er']);
}

// function detect($input) // fonction Jérémy il faut commenter la ligne 2 pour retirer le conflit de donnée
// {
//     global $erreur;
//     if (strlen($erreur[$input]) > 0 ) {
//         echo "<div class='inputError'>" . $erreur[$input] . "</div>";
//     }
// }

function detect($input)
{   
    global $erreur;
    //echo "<div class='inputError'>" . "Futur message d'erreur du champs $input" . "</div>";
    if (array_key_exists("$input", $erreur)) {
        echo "<div class='inputError'>" . $erreur[$input] . "</div>";
    }
}
            //detect('genre')
include("./inc/header.php");

?>





    <!-- form>(input*5+select>(option)) -->
    <div id="formVoyage">
        <h1>Enregistrer une destination de voyage</h1>
        <div id="success"></div>
        <?php
            detect('success');
            ?>
        <!-- On a 2 method post et get enctype sert à dire qu'on attend des fichiers   get envoi toute les valeurs en clair sur l'url ne sert qu'à débug ne pas utilisé en dehors du DEV-->
        <!-- Get ne doit jamais être utilisé en dehors du dev -->
        <!-- action="./inc/validator.inc.php" permet de créer la sécurité du formulaire  -->
        <form class="formulaire" action="./validator.php" method="POST" enctype="multipart/form-data" name="uploadMP3">

            <label for="titre">Titre de la destination*</label>
            <input type="text" name="titre" placeholder="Titre" id="titre">
            <?php
            detect('titre');
            ?>
            <label for="description">Description*</label>
            <textarea name="description" placeholder="Description" id="description"></textarea>
            <?php
            detect('description');
            ?>

            <label for="ville">ville*</label>
            <input type="text" name="ville" placeholder="Ville" id="ville">
            <?php
            detect('ville');
            ?>

            <label for="pays">pays*</label>
            <input type="text" name="pays" placeholder="pays" id="pays">
            <?php
            detect('pays');
            ?>

            <label for="prixParPersonne">prix par personne*</label>
            <input type="text" name="prixParPersonne" placeholder="prix par personne" id="prixParPersonne">
            <?php
            detect('prixParPersonne');
            ?>

            <label for="distanceDepuisParis">distance depuis paris</label>
            <input type="text" name="distanceDepuisParis" placeholder="distance depuis paris" id="distanceDepuisParis">


            <label for="typeDePension">Type de pension*</label>
            <select name="typeDePension" id="typeDePension">
                <option value="" disabled selected>Choisissez le type de pension</option>
                <option value="complete">complète</option>
                <option value="demi_pension">demi pension</option>
            </select>

            <?php
            detect('typeDePension');
            ?>

            <label for="dateDeDepart">Date de depart</label>
            <input type="text" name="dateDeDepart" placeholder="AA/MM/JJ" id="dateDeDepart">

            <label for="dateDeRetour">Date de retour</label>
            <input type="text" name="dateDeRetour" placeholder="AA/MM/JJ" id="dateDeRetour">

            <label for="photo">Photo de couverture de la destination</label>
            <input type="file" name="photo" id="photo">
           
            <input type="submit" value="Envoyer" name="submit">
            <small id="emailHelp" class="form-text text-muted">* champs obligatoire</small>
        </form>
    </div>

<!-- </body> -->

<!-- </html> -->



<?php
include("./inc/footer.php");