<?php

namespace SGR\model;

/*
 * Représente la table Departement
 */

use SGR\model\ConnexionBDD;

class Departement {

    private $num;
    private $nom;
    private $secteur;

    function __construct() {
        
    }

    /*
     * Conmstructeur
     * 
     * 
     * @param $num : Numéro du departement
     * @param $nom : Nom du departement
     * @param $secteur : Secteur associé au Departement
     */

    function creerDepartement($num, $nom, $secteur) {
        $projet = new Departement();
        $projet->num = $num;
        $projet->nom = $nom;
        $projet->secteur = $secteur;
        return ($projet);
    }

    /*
     * Liste de tout les departements trié par leur code
     */

    function allDepartementTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM departement ORDER BY NumDepartement ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allDepartement = array();
        while ($row = mysqli_fetch_array($result)) {
            $dep = $this->creerDepartement($row["NumDepartement"], $row["NomDepartement"], $row["NomSecteur_id"]);
            array_push($allDepartement, $dep);
        }
        $bdd->fermerConnexion();
        return($allDepartement );
    }

    //getter

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
