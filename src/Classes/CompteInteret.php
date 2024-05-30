<?php

namespace App;

class CompteInteret extends Compte{

    /* Attributs */
    private $taux;

    /**
     * Compte constructor
     * @param string    nom
     * @param string    prenom
     * @param string    numcompte
     * @param string    numagence
     * @param string    rib
     * @param string    iban
     * @param float     taux
     * @param float     solde
     * @param string    devise
     */
    public function __construct(
        $nom, $prenom, $numcompte,
        $numagence, $rib, $iban, $solde = 0, $devise = '€', $taux = 0.03)
    {
        parent::__construct($nom,$prenom,$numcompte,$numagence,$rib,$iban,$solde,$devise);
        $this->taux = $taux;
    }

    /**
     * Get the value of taux
     */ 
    public function getTaux()
    {
        return $this->taux;
    }
    
    /**
     * Set the value of taux
     *
     * @return  self
     */ 
    public function setTaux($taux)
    {
        if( !is_float($taux) && $taux <= 0 ){
            trigger_error('Le taux doit être un nombre strictement supérieur à 0', E_USER_WARNING);
        }
        $this->taux = $taux;
        return true;
    }

    /* Méthode(s) de CompteInteret */
    /* surcharge de la méthode virement : il est impossible d'être débiteur sur un compte à intérêts */

    public function virement($montant, $destinataire) : string{
        $message = '';
        if( (!is_float($montant) && !is_int($montant)) || $montant <= 0 || ($this->getSolde() - $montant) < 0 ){
            if(!is_float($montant) && !is_int($montant) ){
                $message .= 'Le montant doit être un nombre<br />';
            }
            $message .= ($montant < 0)? 'Le montant doit être strictement supérieur à 0<br />':'';
            $message .= (($this->getSolde() - $montant) < 0)?'Le montant est supérieur au crédit compte, le compte ne peut pas être débiteur<br />' : '';
            return $message;
        }
        $this->modifierSolde(-$montant);
        $destinataire->modifierSolde($montant);
        return $message;
    }

    public function crediterinterets(){
        $message = '';
        $interets = 0;
        if($this->getSolde() > 0){
            $interets = $this->getSolde()*$this->getTaux();
            $this->modifierSolde($interets);
            $message .= 'Le compte inétrêt à taux '. $this->getTaux() . ' a été crédité de '. $interets .' ' . $this->getDevise();
        }

        return $message;
    }

    public function enregCompte()
    {
        $params = [
            'uniqueid' => 'CIT-'. time(),
            'typecompte' => $this->typeCompte(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'numcompte' => $this->getNumcompte(),
            'numagence' => $this->getNumagence(),
            'rib' => $this->getRib(),
            'iban' => $this->getIban(),
            'solde' => $this->getSolde(),
            'devise' => $this->getDevise(),
            'taux' => $this->getTaux()
            ];
    
            $sql = 'INSERT INTO compte (
                `uniqueid` , `typecompte` , `nom` , `prenom` , `numcompte` ,
                `numagence` , `rib` , `iban` , `solde` , `devise`, `taux`
            ) VALUES (
                :uniqueid, :typecompte, :nom, :prenom, :numcompte,
                :numagence, :rib, :iban, :solde, :devise, :taux);';
            
            $this->enreg($sql, $params);

    }


}