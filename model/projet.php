<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Projet {

    private $num;
    private $description;
    private $etat;
    private $note;
    private $lien;

    function __construct() {
        
    }

    function creerProjet($no, $d, $e, $n, $l) {
        $projet = new Projet();
        $projet->num = $no;
        $projet->description = $d;
        $projet->etat = $e;
        $projet->note = $n;
        $projet->lien = $l;
        return ($projet);
    }

    function allProjetTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM projet ORDER BY NumProjet ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allProjet = array();
        while ($row = mysqli_fetch_array($result)) {
            $projet = $this->creerProjet($row["NumProjet"], $row["DescriptionProjet"], $row["EtatProjet"], $row["Notes"], $row["LienDossier"]);
            array_push($allProjet, $projet);
        }
        $bdd->fermerConnexion();
        return($allProjet);
    }

    function getNum() {
        return $this->num;
    }

    function getDescription() {
        return $this->description;
    }

    function getEtat() {
        return $this->etat;
    }

    function getNote() {
        return $this->note;
    }

    function getLien() {
        return $this->lien;
    }

}
