<?php
// session_start();


require_once("./inc/fonctions.php");
include("./inc/header.php");
$order = "titre";
if (!empty($_GET['order'])) {
    $order = $_GET['order'];
}

$destination = selectAllDestination($order);
?>

<div id="subMenu">
    <label for="order">Trier les destinations</label>
    <select name="order" id="order">
        <option value="titre" <?php if ($order === "titre") echo "selected"; ?>>Titre</option>
        <option value="ville" <?php if ($order === "ville") echo "selected"; ?>>Ville</option>
        <option value="pays" <?php if ($order === "pays") echo "selected"; ?>>Pays</option>
    </select>
</div>

<section id="location_voyage">

    <?php
    for ($i = 0; $i < sizeof($destination); $i++) {
    ?>

        <div class="card card-centrer" style="width: 18rem;">
            <img class="card-img-top" src="./assets/photo/<?php echo $destination[$i]["photo"]; ?>" alt="<?php echo $destination[$i]["titre"] . " - " . $destination[$i]["ville"] . " - " . $destination[$i]["pays"]; ?>">
            <div class="card-body">
                <h5 class="card-titre"><?php echo $destination[$i]["titre"]; ?></h5>
                <p class="card-text"><?php echo $destination[$i]["ville"]; ?></p>
                <p class="card-text"><?php echo $destination[$i]["pays"]; ?></p>
                <p class="card-text">Description: <br>
                <?php
                // troncage de la description à 30 caractère
                echo substr($destination[$i]["description"], 0, 30);
                ?> ...
                </p>
                
                <a href="destination.php?id=<?php echo $destination[$i]["id"]; ?>" class="btn btn-primary">Plus d'info...</a> <!-- ?correcpond à un get pour récupéré l'id des -->
                <!--  // peut être aussi écris comme cela  pour ce passer de l'echo et du php:  -->

            </div>
        </div>
    <?php
    }
    ?>


</section>




<?php
include("./inc/footer.php");
?>