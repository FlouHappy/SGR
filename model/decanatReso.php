<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class DecanatReso {

    private $id;
    private $num;
    private $numInstance;
    private $numSeance_id;
    private $numProjet_id;
    private $resumeReso;
    private $dateReso;
    private $description;
    private $dateEffective;
    private $campus;
    private $note;
    private $suivi;

    function __construct() {
        
    }

    function creerDecanatReso($i, $n, $ni, $s, $np, $r, $dr, $desc, $de, $c, $not, $suiv) {
        $reso = new DecanatReso();
        $reso->id = $i;
        $reso->campusnum = $n;
        $reso->numInstance + $ni;
        $reso->numSeance_id = $s;
        $reso->numProjet_id = $np;
        $reso->resumeReso = $r;
        $reso->dateReso = $dr;
        $reso->description = $desc;
        $reso->dateEffective = $de;
        $reso->campus = $c;
        $reso->note = $not;
        $reso->suivi = $suiv;
        return ($reso);
    }
    
    
    
    
    function getId() {
        return $this->id;
    }

    function getNum() {
        return $this->num;
    }

    function getNumInstance() {
        return $this->numInstance;
    }

    function getNumSeance_id() {
        return $this->numSeance_id;
    }

    function getNumProjet_id() {
        return $this->numProjet_id;
    }

    function getResumeReso() {
        return $this->resumeReso;
    }

    function getDateReso() {
        return $this->dateReso;
    }

    function getDescription() {
        return $this->description;
    }

    function getDateEffective() {
        return $this->dateEffective;
    }

    function getCampus() {
        return $this->campus;
    }

    function getNote() {
        return $this->note;
    }

    function getSuivi() {
        return $this->suivi;
    }


}
