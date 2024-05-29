<?php
require './vendor/autoload.php';
use Utils\Tools;
use Doctrine\Common\Collections\ArrayCollection;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation PHP Avancé - Accueil</title>
    <?php
    include './src/includes/headcalls.php';
    ?>
</head>
<body>
    <?php
    include './src/includes/header.php';
    ?>
    <?php
    include './src/includes/navigation.php';
    ?>
    <main class="container">
        <section>
            <article>
                <header>
                    <h2>Mediathèque</h2>
                </header>
                <h3>Définition d'une oeuvre</h3>
                <p>
                    Une oeuvre peut être définie par :
                </p>
                <ul>
                    <li>Un ou des créateurs</li>
                    <li>Un titre</li>
                    <li>Une description ou un résumé</li>
                </ul>
                <p>
                    Les différents types d'oeuvres seront des classe enfants étandants la classe oeuvre mais ayant chacunes leurs particularités.
                </p>
                <h3>La classe Oeuvre</h3>
                <?php
                
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>