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
    
     function nouvelleSeance($date,$instance) {
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
    
    function allSeanceTrie(){
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