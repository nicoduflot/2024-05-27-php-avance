<?php

namespace App;


class Carte{
    private $numcarte;
    private $codepin;

    /**
     * Carte constructor
     * @param string numcarte
     * @param string codepin
     */
    public function __construct($numcarte, $codepin)
    {
        $this->numcarte = $numcarte;
        $this->codepin = $codepin;
    }
 
    /**
     * Get the value of numcarte
     */ 
    public function getNumcarte()
    {
        return $this->numcarte;
    }

    /**
     * Get the value of codepin
     */ 
    public function getCodepin()
    {
        return $this->codepin;
    }
    
}