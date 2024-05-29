<?php

namespace Oeuvres;

class Role{
    private $personnage;
    private $acteur;
    
    public function __construct($personnage, $acteur)
    {
        $this->personnage = $personnage;
        $this->acteur = $acteur;
    }
}