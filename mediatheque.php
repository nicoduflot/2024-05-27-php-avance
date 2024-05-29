<?php
require './vendor/autoload.php';
use Utils\Tools;
use Doctrine\Common\Collections\ArrayCollection;
use Oeuvres\Oeuvre;
use Oeuvres\Livre;
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
                    Toutes les oeuvres auront les méthodes suivantes
                </p>
                <ul>
                    <li>ajoutcreateur</li>
                    <li>supprcreateur</li>
                </ul>
                <p>
                    Les différents types d'oeuvres seront des classe enfants étandants la classe oeuvre mais ayant chacunes leurs particularités.
                </p>
                <h3>La classe Oeuvre</h3>
                <?php
                $oeuvre = new Oeuvre('Les zinzins d\'Olive Oued');
                $oeuvre->ajoutcreateur('Pratchett', 'Terry');
                Tools::prePrint($oeuvre);
                ?>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-6">
                <header>
                    <h2>L'objet Livre, un type d'oeuvre</h2>
                </header>
                <p>
                    Livre est une classe enfant d'Oeuvre. Livre aura les attribut supplémentaires suivants
                </p>
                <ul>
                    <li>format</li>
                    <li>genre</li>
                    <li>isbn</li>
                </ul>
                <?php
                $livre = new Livre('Les zinzins d\'Olive Oued', 'Le médiéval-fantastique invente le cinéma', 'Les alchimiste d\'Ank Morpork inventent le celuloid et la guilde des artisans la machine pour projeter les images, les marchands inventent Olive Oued', 'Poche', 'Médieval-fantastique');
                $livre->ajoutcreateur('Pratchett', 'Terry');
                Tools::prePrint($livre);
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>L'objet Film, un type d'oeuvre</h2>
                </header>
                <p>
                    Film est une classe enfant d'Oeuvre. Livre aura les attribut supplémentaires suivants
                </p>
                <ul>
                    <li>Casting (tableau de Personne)</li>
                    <li>support</li>
                    <li>genre</li>
                </ul>
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