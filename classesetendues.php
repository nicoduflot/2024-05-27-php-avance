<?php
require './vendor/autoload.php';
use Utils\Tools;
use App\CompteCheque;
use App\CompteInteret;

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
                    <h2>Classes étendues</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Une classe est étendue quand elle possède une classe fille. La classe fille
                    hérite automatiquement des attributs et des méthodes de la classe mère. L'avantage
                    est que la classe fille peut posséder ses propres méthodes et attributs, mais elle peut aussi
                    surcharger les méthodes de la classe mère en les redéfinissants. Mais si on veut pouvoir redéfinir,
                    par exemple, les getters ou setters de la classe mère, les attributs concernés dans la classe
                    mère doivent être alors déclarés en protected et plus en private.
                </p>
            </article>
        </section>
        <section class="row">
            <article>
                <header>
                    <h2>Création des comptes qui héritent de la classe compte</h2>
                </header>
                <p>
                    On crée un compte chèque et un compte à intérêt.
                </p>
                <h3>Le compte chèque</h3>
                <ul>
                    <li>Possède une carte de paiement</li>
                    <li>Possède une méthode payerparcarte</li>
                </ul>
                <h4>La carte de paiement</h4>
                <ul>
                    <li>Un numéro de carte</li>
                    <li>Un PIN</li>
                </ul>
                <h3>Le compte intérêts</h3>
                <ul>
                    <li>Possède un taux d'intérêt</li>
                    <li>Possède une méthode crediterinterets</li>
                    <li>Le virement ne permet pas de rendre débiteur le compteinteret</li>
                </ul>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Compte Chèque</h2>
                </header>
                <?php
                $comptecheque = new CompteCheque('Duflot', 'Nicolas', 'CCP 6543231', 'AG 9874', 'RIB 456987', 'IBAN 987321', '2111 1098 765 4321', '3210', 1500);
                Tools::prePrint($comptecheque);
                $comptechequeACME = new CompteCheque('ACME', '', 'CCP 987654', 'AG 01234', 'RIB 789456', 'IBAN 456123', '0123 4567 8910 1112', '0123', 1500);
                Tools::prePrint($comptechequeACME);
                echo $comptecheque->payerparcarte('2111 1098 765 4321', '3210', 25, $comptechequeACME);
                Tools::prePrint($comptecheque->getSolde());
                Tools::prePrint($comptechequeACME->getSolde());
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Compte Intéret</h2>
                </header>
                <?php
                $compteinteret = new CompteInteret('Duflot', 'Nicolas', 'CCP 6543231', 'AG 9874', 'RIB 456987', 'IBAN 987321', 1500);
                Tools::prePrint($compteinteret);
                echo $compteinteret->virement(12.5, $comptecheque);
                echo $compteinteret->getSolde().'<br />';
                echo $comptecheque->getSolde().'<br />';
                echo $compteinteret->crediterinterets().'<br />';
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>