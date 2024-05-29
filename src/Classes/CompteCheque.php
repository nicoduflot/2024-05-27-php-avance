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
     */
    public function __construct(
        $nom, $prenom, $numcompte,
        $numagence, $rib, $iban, $numcarte, $codepin, $solde = 0, $devise = '€')
    {
        parent::__construct($nom,$prenom,$numcompte,$numagence,$rib,$iban,$solde,$devise);
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

}