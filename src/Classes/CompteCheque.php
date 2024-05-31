<?php

namespace App;

class CompteCheque extends Compte{

    /* Attributs */
    private $carte;

    /**
     * Compte constructor
     * @param string    nom
     * @param string    prenom
     * @param string    numcompte
     * @param string    numagence
     * @param string    rib
     * @param string    iban
     * @param string    numcarte
     * @param string    codepin
     * @param float     solde
     * @param string    devise
     * @param int       idcarte
     */
    public function __construct(
        $nom, $prenom, $numcompte,
        $numagence, $rib, $iban, $numcarte, $codepin, $solde = 0, $devise = '€', $uniqueid = null)
    {
        parent::__construct($nom,$prenom,$numcompte,$numagence,$rib,$iban,$solde,$devise, $uniqueid);
        $this->carte = new Carte($numcarte, $codepin);
    }

    /**
     * Get the value of carte
     */ 
    public function getCarte()
    {
        return $this->carte;
    }

    /* Méthode(s) de CompteCheque */
    public function payerparcarte($numcarte, $codepin, $montant, $destinataire){
        $message = '';
        if($this->getCarte()->getNumcarte() === $numcarte && $this->getCarte()->getCodepin() === $codepin){
            $this->virement($montant, $destinataire);
            $this->modifierSolde(-$montant);
            $etatSolde = ($this->getSolde() <= 0)? 'débiteur' : 'créditeur';
            $message .= 'Un paiement de '. $montant . $this->getDevise() .' a été effectué vers le receveur '. $destinataire->getNom() . '<br />'.
            'Compte '. $etatSolde . ' : <b>'.$this->getSolde(). ' ' .$this->getDevise() . '</b>';
        }else{
            $message .= 'Une erreur est survenue lors de la tentative de paiement de '.$montant. ' vers le destinataire '. $destinataire->getNom(). '.';
        }
        return $message;
    }

    public static function generatePin(){
        $pin = ''. rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return $pin;
    }

    public static function generateCardNumber(){
        $numcarte = ''. CompteCheque::generatePin() . ' ' . CompteCheque::generatePin() . ' ' . CompteCheque::generatePin() . ' ' . CompteCheque::generatePin();

        return $numcarte;
    }

    public function enregCompte()
    {
        $idcarte = $this->getCarte()->enreg();

        $params = [
            'uniqueid' => 'CCT-'. time(),
            'typecompte' => $this->typeCompte(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'numcompte' => $this->getNumcompte(),
            'numagence' => $this->getNumagence(),
            'rib' => $this->getRib(),
            'iban' => $this->getIban(),
            'solde' => $this->getSolde(),
            'devise' => $this->getDevise(),
            'cardid' => $idcarte
            ];
    
            $sql = 'INSERT INTO compte (
                `uniqueid` , `typecompte` , `nom` , `prenom` , `numcompte` ,
                `numagence` , `rib` , `iban` , `solde` , `devise`, `cardid`
            ) VALUES (
                :uniqueid, :typecompte, :nom, :prenom, :numcompte,
                :numagence, :rib, :iban, :solde, :devise, :cardid);';
            
            $this->enreg($sql, $params);

    }

}