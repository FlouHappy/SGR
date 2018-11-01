<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Departement {

    private $num;
    private $nom;
    private $secteur;

    function __construct() {
        
    }

    function creerDepartement($num, $nom, $secteur) {
        $projet = new Departement();
        $projet->num = $num;
        $projet->nom = $nom;
        $projet->secteur = $secteur;
        return ($projet);
    }

    function allDepartementTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM departement ORDER BY NumDepartement ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allDepartement = array();
        while ($row = mysqli_fetch_array($result)) {
            $dep = $this->creerDepartement($row["NumDepartement"], $row["NomDepartement"], $row["NomSecteur_id"]);
            array_push($allDepartement , $dep);
        }
        $bdd->fermerConnexion();
        return($allDepartement );
    }
    function getNum() {
        return $this->num;
    }

    function getNom() {
        return $this->nom;
    }

    function getSecteur() {
        return $this->secteur;
    }
    


}
