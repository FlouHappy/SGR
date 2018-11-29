<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    
    
    function getSuivi() {
        return $this->suivi;
    }

    function getProcessus() {
        return $this->processus;
    }


}
    