<?php
require './vendor/autoload.php';

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
                    <h2>Exceptions</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Intégrer dans les classes Compte (et les enfants) des méthodes pour enregistrer ou modifier voir supprimer des comptes.
                </p>
                <ul>
                    <li><a href="./creaCompte.php?typecompte=Compte">Un compte</li>
                    <li><a href="./creaCompte.php?typecompte=CompteCheque">Un compte chèque</li>
                    <li><a href="./creaCompte.php?typecompte=CompteInteret">Un compte intérêt</li>
                </ul>
            </article>

        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>

</html>