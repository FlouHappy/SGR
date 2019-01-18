<?php

namespace SGR\model;

/*
 * Gere la table seance
 */

use SGR\model\ConnexionBDD;

class Seance {

    private $numSeance;
    private $date;
    private $instance;

    /*
     * Constructeur par défaut
     * 
     * 
     */

    function __construct() {
        
    }

    /*
     * Constructeur alternatif
     * 
     * @param $n : Numéro de seance
     * @param $d : Date de la seance
     * @param $i : instance présente a la séance
     */

    function creerSeance($n, $d, $i) {
        $seance = new Seance();
        $seance->numSeance = $n;
        $seance->date = $d;
        $seance->instance = $i;
        return ($seance);
    }

    /*
     * Ajoute une nouvelle Seance dans la table
     * 
     * 
     * @param $date : Date de la seance
     * @param $ni : Instance prsente a la seance
     */

    function nouvelleSeance($date, $instance) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO seance (DateSeance, Instance) VALUES ('$date','$instance')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Séance créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    /*
     * Liste de toute les seances de la table trié par date en decroissant
     * 
     * 
     */

    function allSeanceTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM seance ORDER BY DateSeance DESC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allSeance = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $seance = $this->creerSeance($row["NumSeance"], $row["DateSeance"], $row["Instance"]);
            array_push($allSeance, $seance);
        }
        $bdd->fermerConnexion();
        return($allSeance);
    }

    //getter
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
