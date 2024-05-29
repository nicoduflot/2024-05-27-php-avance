<?php
require './vendor/autoload.php';
require './src/Classes/Utrain.interface.php';
require './src/Classes/PublicUser.class.php';
require './src/Classes/InternUser.class.php';
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
        <section class="row">
            <article>
                <header>
                    <h2>Les interfaces</h2>
                </header>
                <p>
                    Les interfaces répondent au problème suivants : une classe mère radio ayant tous les attributs et les méthodes communes à une radio FM, une radio cassette, une radio cd et une radio cassette et cd.
                </p>
                <p>
                    Quatre classes filles : radio FM, Radio cassette, radio cd et radio cassette cd.
                </p>
                <p>
                    Plutôt que de créer toutes les options dans la classe mère, les classe filles vont implémenter des interfaces différentes correspondant à la fm, la cassette, et le cd.
                </p>
                <ul>
                    <li>une classe mère Radio.</li>
                    <li>une classe fille radio FM qui étends radio et qui implémente l'interface FM</li>
                    <li>une classe fille radio cassette qui étends radio et qui implémente l'interface FM et l'interface cassette</li>
                    <li>une classe fille radio cd qui étends radio et qui implémente l'interface FM et l'interface cd</li>
                    <li>une classe fille radio cassette cd qui étends radio et qui implémente l'interface FM , linterface casset et l'interface cd</li>
                </ul>
                <p>
                    Attention, les interfaces ne peuvent que définir que la signature d'une méthode, pas sont implémentation.
                </p>
                <p>
                    Donc les méthodes déclarées dans l'interface devront être publiques (elles sont implémentées en dehors de l'interface) et les constantes de l'interface ne pourront pas être écrasées par la classe qui en hérite.
                </p>
            </article>
            <article>
                <header>
                    <h2>Créer l'interface</h2>
                </header>
                <p>
                    On utilise le mot <code>interface</code> à la place du mot <code>class</code>
                </p>
                <p>
                    <code>
                        &lt;?php<br />
                        interface Utrain{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public const PRIXABO = 15;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getNomUtilisateur();<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function setPrixAbo();<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getPrixAbo();<br />
                        }
                    </code>
                </p>
                <p>
                    Dans les personnes qui prennent des abonnements, il y a des personne qui travaillent à U-train. Certains seront Cadre et paieront moins chers que les non cadres.
                    Les personnes du public, si elles font parties de la police elle paieront moins chers que le public.
                </p>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Le public</h2>
                </header>
                <p>
                    Les personnes ne travaillant pas pour UTrain
                </p>
                <p>
                    <code>
                        &lt;?php<br />
                        class PublicUser implements Utrain{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;protected $nomUtilisateur;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;protected $statut;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;protected $prixAbo;<br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function __construct($nom, $statut = ''){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->nomUtilisateur = $nom;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->statut = $statut;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getNomUtilisateur(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $this->nomUtilisateur;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getPrixAbo(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $this->prixAbo;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;public function setPrixAbo(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if($this->statut === 'Police'){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return $this->prixAbo = Utrain::PRIXABO / 2;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}else{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return $this->prixAbo = Utrain::PRIXABO;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        }<br />
                    </code>
                </p>
                <?php
                $karl = new PublicUser('Karl Odenmayer');
                $karl->setPrixAbo();
                Tools::prePrint($karl);
                $sarko = new PublicUser('Nicolas Sarkosy', 'Police');
                $sarko->setPrixAbo();
                Tools::prePrint($sarko);
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les salariés de Utrain</h2>
                </header>
                <p>
                    Les gens qui travaillent à Utrain.
                </p>
                <p>
                    <code>
                        &lt;?php<br />
                        class InternUser implements Utrain{<br />
                        &nbsp;&nbsp;&nbsp;protected $nomUtilisateur;<br />
                        &nbsp;&nbsp;&nbsp;protected $statut;<br />
                        &nbsp;&nbsp;&nbsp;protected $prixAbo;<br />
                        <br />
                        &nbsp;&nbsp;&nbsp;public function __construct($nom, $statut = ''){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->nomUtilisateur = $nom;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->statut = $statut;<br />
                        &nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getNomUtilisateur(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $this->nomUtilisateur;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getPrixAbo(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $this->prixAbo;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />

                        &nbsp;&nbsp;&nbsp;&nbsp;public function setPrixAbo(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if($this->statut === 'Cadre'){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return $this->prixAbo = Utrain::PRIXABO / 6;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}else{<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return $this->prixAbo = Utrain::PRIXABO / 3;<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;public function getWifi(){<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo 'L\'utilisateur du transport a le wifi sans pub';<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;}<br />
                        }
                    </code>
                </p>
                <?php
                $michelmanager = new InternUser('Michel Marc', 'Cadre');
                $michelmanager->setPrixAbo();
                Tools::prePrint($michelmanager);
                $jcdelacompta = new InternUser('Jean Christophe Ballain');
                $jcdelacompta->setPrixAbo();
                Tools::prePrint($jcdelacompta);
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>