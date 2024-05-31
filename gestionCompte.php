<?php
require './vendor/autoload.php';
session_start();

use App\Compte;
use App\CompteCheque;
use App\Carte;
use App\CompteInteret;
use Utils\Tools;

//Tools::prePrint($_SESSION);

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
            <article class="col-lg-8 offset-lg-2">
                <header>
                    <h2>Gestion d'un compte d'un compte</h2>
                </header>
                <?php
                    if(isset($_SESSION['alertmodif'])){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Succès !</strong> Le compte a bien été modifié.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    unset($_SESSION['alertmodif']);
                    }
                ?>
                <?php
                if( isset($_POST['action']) && $_POST['action'] !== ''){
                    switch($_POST['action']){
                        case 'edit':
                            $compte = unserialize($_SESSION['compte']);
                            $compte->setNom($_POST['nom']);
                            $compte->setPrenom($_POST['prenom']);
                            $compte->setNumagence($_POST['numagence']);
                            $compte->setNumcompte($_POST['numcompte']);
                            $compte->setRib($_POST['rib']);
                            $compte->setIban($_POST['iban']);
                            $compte->setSolde(floatVal($_POST['solde']));
                            $compte->setDevise($_POST['devise']);
                            if($compte->typeCompte() === 'CompteInteret'){
                                $compte->setTaux($_POST['taux']);
                            }
                            $_SESSION['compte'] = serialize($compte);
                            $_SESSION['alertmodif'] = true;
                            $compte->modCompte();
                            header('location:./gestionCompte.php?action=show&uniqueid='.$compte->getUniqueid());
                            break;
                        case 'supp':
                            echo 'tata';
                            $compte = unserialize($_SESSION['compte']);
                            if($compte->typeCompte() === 'CompteCheque'){
                                $compte->getCarte()->removeSelf();
                            }
                            $compte->removeSelf();
                            unset($_SESSION['compte']);
                            $compte = null;
                            header('location:./classesetpdo.php');
                            break;
                    }
                }
                if (isset($_GET['action']) && isset($_GET['uniqueid']) && $_GET['uniqueid'] !== '') {
                    switch ($_GET['action']) {
                        case 'show':
                            /* on récupère le compte en objet et on met l'objet en session */
                            $idcompte = $_GET['uniqueid'];
                            $sql = '
                            SELECT 
                                `cp`.*, `ct`.`id` as `idcarte`, `ct`.`cardnumber`, `ct`.`codepin` 
                            FROM 
                                `compte` as `cp` LEFT JOIN 
                                `carte` as `ct` on `cp`.`cardid` = `ct`.`id` 
                            WHERE `cp`.`uniqueid` = :idcompte ;';
                            //echo $sql;
                            $params = ['idcompte' => $idcompte];
                            $request = Tools::querySelect($bdd, $sql, $params);
                            //Tools::prePrint($request);
                ?>
                            <table class="table">
                                <?php
                                while ($data = $request->fetch(PDO::FETCH_ASSOC)) {
                                    switch ($data['typecompte']) {
                                        case 'Compte':
                                            $compte = new Compte($data['nom'], $data['prenom'], $data['numcompte'], $data['numagence'], $data['rib'], $data['iban'], $data['solde'], $data['devise'], $data['uniqueid']);
                                            $_SESSION['compte'] = serialize($compte);
                                ?>
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th colspan="2">Numéro de compte</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $compte->getNom() ?></td>
                                                    <td><?php echo $compte->getPrenom() ?></td>
                                                    <td colspan="2"><?php echo $compte->getNumcompte() ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Numéro d'agence</th>
                                                    <th>RIB</th>
                                                    <th>IBAN</th>
                                                    <th>Solde</th>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $compte->getNumagence() ?></td>
                                                    <td><?php echo $compte->getRib() ?></td>
                                                    <td><?php echo $compte->getIban() ?></td>
                                                    <td><?php echo $compte->getSolde() . ' ' . $compte->getDevise() ?></td>
                                                </tr>
                                            </tbody>
                                        <?php
                                            break;

                                        case 'CompteCheque':
                                            $compte = new CompteCheque($data['nom'], $data['prenom'], $data['numcompte'], $data['numagence'], $data['rib'], $data['iban'], $data['cardnumber'], $data['codepin'], $data['solde'], $data['devise'], $data['uniqueid']);
                                            $_SESSION['compte'] = serialize($compte);
                                        ?>
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th colspan="2">Numéro de compte</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $compte->getNom() ?></td>
                                                    <td><?php echo $compte->getPrenom() ?></td>
                                                    <td colspan="2"><?php echo $compte->getNumcompte() ?></td>
                                                </tr>
                                                <tr>

                                                    <th>Numéro d'agence</th>
                                                    <th>RIB</th>
                                                    <th>IBAN</th>
                                                    <th>Solde</th>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $compte->getNumagence() ?></td>
                                                    <td><?php echo $compte->getRib() ?></td>
                                                    <td><?php echo $compte->getIban() ?></td>
                                                    <td><?php echo $compte->getSolde() . ' ' . $compte->getDevise() ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Numéro de carte</th>
                                                    <th colspan="2">Code Pin</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><?php echo $compte->getCarte()->getNumcarte() ?></td>
                                                    <td colspan="2"><?php echo $compte->getCarte()->getCodepin() ?></td>
                                                </tr>
                                            </tbody>
                                        <?php
                                            break;

                                        case 'CompteInteret':
                                            $compte = new CompteInteret($data['nom'], $data['prenom'], $data['numcompte'], $data['numagence'], $data['rib'], $data['iban'], $data['solde'], $data['devise'], $data['taux'], $data['uniqueid']);
                                            $_SESSION['compte'] = serialize($compte);
                                        ?>
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Numéro de compte</th>
                                                    <th>Numéro d'agence</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $compte->getNom() ?></td>
                                                    <td><?php echo $compte->getPrenom() ?></td>
                                                    <td><?php echo $compte->getNumcompte() ?></td>
                                                    <td><?php echo $compte->getNumagence() ?></td>
                                                </tr>
                                                <tr>

                                                    <th>RIB</th>
                                                    <th>IBAN</th>
                                                    <th>Solde</th>
                                                    <th>Taux d'intérêt</th>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $compte->getRib() ?></td>
                                                    <td><?php echo $compte->getIban() ?></td>
                                                    <td><?php echo $compte->getSolde() . ' ' . $compte->getDevise() ?></td>
                                                    <td><?php echo $compte->getTaux() ?></td>
                                                </tr>
                                            </tbody>
                                <?php

                                            break;
                                    }
                                }
                                $request->closeCursor();
                                ?>
                            </table>

                        <?php
                            break;
                        case 'edit':
                            $compte = unserialize($_SESSION['compte']);
                            //tools::prePrint($compte);
                        ?>
                            <form method="post" action="./gestionCompte.php">
                                <input type="hidden" name="uniqueid" id="uniqueid" value="<?php echo $compte->getUniqueid() ?>" />
                                <input type="hidden" name="action" id="action" value="edit" />
                                <input type="hidden" name="devise" id="devise" value="<?php echo $compte->getDevise() ?>" />
                                <fieldset class="form-control my-2">
                                    <legend>
                                        Détenteur du compte
                                    </legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $compte->getNom() ?>" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="prenom">Prénom</label>
                                            <input type="text" class="form-control" name="prenom" id="nom" value="<?php echo $compte->getPrenom() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-control my-2">
                                    <legend>Agence</legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numagence">Numéro d'agence</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="numagence" id="numagence"  value="<?php echo $compte->getNumagence() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-control my-2">
                                    <legend>
                                        Détails du compte
                                    </legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="type">Type de compte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="type" id="type" value="<?php echo $compte->typeCompte() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcompte">Numéro de compte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="numcompte" id="numcompte" value="<?php echo $compte->getNumcompte() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="rib">RIB</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="rib" id="rib" value="<?php echo $compte->getRib() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="iban">IBAN</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="iban" name="iban" id="type" value="<?php echo $compte->getIban() ?>" readonly />
                                        </div>
                                    </div>
                                    <?php
                                    switch ($compte->typeCompte()) {
                                        case 'Compte':
                                            break;
                                        case 'CompteCheque':
                                           
                                    ?>
                                            <div class="row my-2">
                                                <div class="col-lg-6">
                                                    <label for="numcarte">Numéro de carte</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control" name="numcarte" id="numcarte"  value="<?php echo $compte->getCarte()->getNumcarte() ?>" />
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-lg-6">
                                                    <label for="codepin">Code secret</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control" name="codepin" id="codepin" value="<?php echo $compte->getCarte()->getCodepin() ?>" />
                                                </div>
                                            </div>
                                        <?php
                                            break;
                                        case 'CompteInteret':
                                        ?>
                                            <div class="row my-2">
                                                <div class="col-lg-6">
                                                    <label for="taux">Taux d'intérêts</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-select" name="taux" id="taux">
                                                        <option>Choisir le taux d'intéret</option>
                                                        <option <?php echo ($compte->getTaux() === 0.015)? 'selected' : '' ?> value="0.015">1.5%</option>
                                                        <option <?php echo ($compte->getTaux() === 0.03)? 'selected' : '' ?> value="0.03">3%</option>
                                                        <option <?php echo ($compte->getTaux() === 0.05)? 'selected' : '' ?> value="0.05">5%</option>
                                                    </select>
                                                </div>
                                            </div>
                                    <?php
                                            break;
                                        default:
                                            header("location: ./classesetpdo.php");
                                            exit();
                                    }
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="solde">Solde</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="solde" id="solde"   value="<?php echo $compte->getSolde() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <p>
                                    <button class="btn btn-outline-success btn-small" type="submit">
                                        Valider les modifications
                                    </button>
                                    <button class="btn btn-outline-warning btn-small" type="reset">
                                        Valeurs par défaut
                                    </button>
                                    <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte->getUniqueid() ?>"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
                                </p>
                            </form>
                    <?php
                            break;
                        case 'supp':
                            $compte = unserialize($_SESSION['compte']);
                            //tools::prePrint($compte);
                            ?>
                            <form method="post" action="./gestionCompte.php">
                                <input type="hidden" name="uniqueid" id="uniqueid" value="<?php echo $compte->getUniqueid() ?>" />
                                <input type="hidden" name="action" id="action" value="supp" />
                                <p>
                                <button class="btn btn-outline-success btn-small" type="submit">
                                        Valider la suppression
                                    </button>
                                    <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte->getUniqueid() ?>"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
                                </p>
                            </form>
                            <?php
                            break;
                        default:
                    }
                    ?>
                    <p>
                        <a href="./classesetpdo.php" title="Retour à la liste des compte"><button class="btn btn-secondary btn-small"><i class="bi bi-list"></i></button></a>
                        <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte->getUniqueid() ?>" title="Voir le compte"><button class="btn btn-success btn-small"><i class="bi bi-card-text"></i></button></a>
                        <a href="./gestionCompte.php?action=edit&uniqueid=<?php echo $compte->getUniqueid() ?>" title="Éditer le compte"><button class="btn btn-secondary btn-small"><i class="bi bi-pencil-fill"></i></button></a>
                        <a href="./gestionCompte.php?action=supp&uniqueid=<?php echo $compte->getUniqueid() ?>" title="Supprimer le compte"><button class="btn btn-danger btn-small"><i class="bi bi-trash-fill"></i></button></a>
                    </p>
                <?php
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