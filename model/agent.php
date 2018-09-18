<?php
namespace SGR\model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use SGR\model\ConnexionBDD;
class Agent {

    private $id;
    private $mdp;
    private $nom;
    private $prenom;
    private $email;

    function __construct() {
        
    }

    private function creerAgent($i, $m, $n, $p, $e, $a) {
        $this->id = $i;
        $this->mdp = $m;
        $this->nom = $n;
        $this->prenom = $p;
        $this->email = $e;
        $this->actif = $a;
    }

    public function creerUnAgent($i, $m, $n, $p, $e, $a) {
        $agent = new Agent();
        $agent->creerAgent($i, $m, $n, $p, $e, $a);
        return $agent;
    }

    public function rechercheParId($user) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM agent WHERE Id='$user'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        while ($row = mysqli_fetch_array($result)) {
            $this->creerAgent($row["Id"], $row["Password"], $row["Nom"], $row["Prenom"], $row["Email"], $row["Actif"]);
        }
        $bdd->fermerConnexion();
        return($this);
    }

    public function rechercheExistenceUser($user) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT count(*) FROM agent WHERE Id='$user'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $row = mysqli_fetch_array($result);
        $verif = false;
        if ($row[0] == 1) {
            $verif = true;
        }
        $bdd->fermerConnexion();
        return($verif);
    }

    function getId() {
        return $this->id;
    }

    function getMdp() {
        return $this->mdp;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

}
