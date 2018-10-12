<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Cour {

    private $sigle;
    private $nom;
    private $cycle;

    function __construct() {
        
    }

    function creerCour($s, $n, $c) {
        $cour = new Cour();
        $cour->sigle = $s;
        $cour->nom = $n;
        $cour->cycle = $c;
        return ($cour);
    }

    function allCourTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM cour ORDER BY Sigle ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allCour = array();
        while ($row = mysqli_fetch_array($result)) {
            $cour = $this->creerCour($row["Sigle"], $row["NomCours"], $row["Cycle"]);
            array_push($allCour, $cour);
        }
        $bdd->fermerConnexion();
        return($allCour);
    }

    function getSigle() {
        return $this->sigle;
    }

    function getNom() {
        return $this->nom;
    }

    function getCycle() {
        return $this->cycle;
    }

}
