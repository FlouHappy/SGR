<?php

namespace SGR\model;

/*
 * Gere la table suivi
 */

use SGR\model\ConnexionBDD;

class Suivi {

    private $suivi;
    private $processus;

    function __construct() {
        
    }

    function creerSuivi($s, $p) {
        $cour = new Suivi();
        $cour->suivi = $s;
        $cour->processus = $p;
        return ($cour);
    }
    
    //getter
    function getSuivi() {
        return $this->suivi;
    }

    function getProcessus() {
        return $this->processus;
    }


}
    