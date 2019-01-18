<?php

namespace SGR\model;

/*
 * Gere la table Ugp
 */

use SGR\model\ConnexionBDD;

class Ugp {

    private $code;
    private $nom;
    private $cycle;
    private $numDepart;

    /*
     * Constructeur par défaut
     * 
     */

    function __construct() {
        
    }

    /*
     * Constructeur alternatif
     * 
     * @param $c : Code de l'UGP
     * @param $n : Nom de l'UGP
     * @param $cy : cycle de l'ugp
     * @param num : numéro de departement associé a l ugp
     * 
     * 
     */

    private function creerUgp($c, $n, $cy, $num) {
        $ugp = new Ugp();
        $ugp->code = $c;
        $ugp->nom = $n;
        $ugp->cycle = $cy;
        $ugp->numDepart = $num;
        return ($ugp);
    }
    
    
    
     function nouveauUGP($code, $nom, $cycle,$depart ) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO ugp (CodeUGP, NomUGP, cycle,NumDepartement_id) VALUES ('$code','$nom',$cycle,'$depart')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Cour créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }

        $bdd->fermerConnexion();
        return $msg;
    }

    /*
     * Liste de tout les ugp de la table ugp trié par ordre alphabetique selon leur code
     * 

     * 
     */

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

    //getter
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
