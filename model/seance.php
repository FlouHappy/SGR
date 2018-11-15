<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Seance {

    private $numSeance;
    private $date;
    private $instance;

    function __construct() {
        
    }

    function creerSeance($n, $d, $i) {
        $seance = new Seance();
        $seance->numSeance = $n;
        $seance->date = $d;
        $seance->instance = $i;
        return ($seance);
    }
    function getNumSeance() {
        return $this->numSeance;
    }

    function getDate() {
        return $this->date;
    }

    function getInstance() {
        return $this->instance;
    }


}