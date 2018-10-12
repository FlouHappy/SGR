<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Ugp {

    private $code;
    private $nom;
    private $cycle;
    private $numDepart;

    function __construct() {
        
    }

    private function creerUgp($c, $n, $cy, $num) {
        $ugp = new Ugp();
        $ugp->code = $c;
        $ugp->nom = $n;
        $ugp->cycle = $cy;
        $ugp->numDepart = $num;
        return ($ugp);
    }

    function allUgpTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM ugp ORDER BY CodeUGP ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allUgp = array();
        while ($row = mysqli_fetch_array($result)) {
            $ugp = $this->creerUgp($row["CodeUGP"], $row["NomUGP"], $row["cycle"], $row["NumDepartement_id"]);
            array_push($allUgp, $ugp);
        }
        $bdd->fermerConnexion();
        return($allUgp);
    }

    function getCode() {
        return $this->code;
    }

    function getNom() {
        return $this->nom;
    }

    function getCycle() {
        return $this->cycle;
    }

    function getNumDepart() {
        return $this->numDepart;
    }

}
