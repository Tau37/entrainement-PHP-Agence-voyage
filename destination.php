<?php
session_start();
require_once("./inc/fonctions.php");


if (!empty($_GET)) {
    $id = intval($_GET["id"]);
    $destination = selectAllDestinationByID($id);
    //var_dump($destination); // table 1 dimension
} else {
    header("Location:index.php");
}


include("./inc/header.php");
?>
<section id="single">
    <div class="jumbotron">
        <h1 class="display-4"><?php echo $destination["titre"]; ?></h1>
        <img class="card-img-top" src="./assets/photo/<?php echo $destination["photo"]; ?>" alt="<?php echo $destination["titre"]; ?>">
        <p class="lead"><?php echo $destination["ville"]; ?></p>
        <p class="lead"><?= $destination["pays"]; ?></p>
        <p class="lead"><?= $destination["prix_par_personne"]; ?> €</p>

        <hr class="my-4">
        <p><?php echo $destination["description"]; ?> </p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Réserve !</a>
        </p>
    </div>
</section>









<?php
include("./inc/footer.php");
?>
