<?php
require './vendor/autoload.php';

use Utils\Tools;

$bdd = Tools::setBdd('localhost', '2024-05-27-php-avance');

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
        <section class="row">
            <article>
                <header>
                    <h2>Exceptions</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Intégrer dans les classes Compte (et les enfants) des méthodes pour enregistrer ou modifier voir supprimer des comptes.
                </p>
                <ul>
                    <li><a href="./creaCompte.php?typecompte=Compte">Un compte</a></li>
                    <li><a href="./creaCompte.php?typecompte=CompteCheque">Un compte chèque</a></li>
                    <li><a href="./creaCompte.php?typecompte=CompteInteret">Un compte intérêt</a></li>
                </ul>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les comptes enregistré</h2>
                </header>
                <?php
                $sqlCPT = 'SELECT * FROM `compte` WHERE `typecompte` = \'Compte\'';
                $request = Tools::querySelect($bdd, $sqlCPT);
                while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                    Tools::prePrint($compte);
                }
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les comptes chèques enregistré</h2>
                </header>
                <?php
                $sqlCCP = 'SELECT * FROM `compte` WHERE `typecompte` = \'CompteCheque\'';
                $request = Tools::querySelect($bdd, $sqlCCP);
                while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                    Tools::prePrint($compte);
                }
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les comptes intérêts enregistrés</h2>
                </header>
                <?php
                $sqlCIT = 'SELECT * FROM `compte` WHERE `typecompte` = \'CompteInteret\'';
                $request = Tools::querySelect($bdd, $sqlCIT);
                while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                    Tools::prePrint($compte);
                }
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>

</html>