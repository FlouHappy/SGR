<?php

namespace SGR\model;

/*
 * Représente la table Agent
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

    /*
     * Constructeur
     * 
     * @param $i : identifiant de l agent
     * @param $m : mot de passe (crypté) de l agent
     * @param $n : Nom de l agent
     * @param $p : Prénom de l agent
     * @param $e : email de l agent
     * @param $a : actif (1: agent actif, 0:agent inactif)
     */

    private function creerAgent($i, $m, $n, $p, $e, $a) {
        $this->id = $i;
        $this->mdp = $m;
        $this->nom = $n;
        $this->prenom = $p;
        $this->email = $e;
        $this->actif = $a;
    }

    /*
     * Constructeur alternatif
     * 
     * @param $i : identifiant de l agent
     * @param $m : mot de passe (crypté) de l agent
     * @param $n : Nom de l agent
     * @param $p : Prénom de l agent
     * @param $e : email de l agent
     * @param $a : actif (1: agent actif, 0:agent inactif)
     */

    public function creerUnAgent($i, $m, $n, $p, $e, $a) {
        $agent = new Agent();
        $agent->creerAgent($i, $m, $n, $p, $e, $a);
        return $agent;
    }

    /*
     *  Liste des agents trié par nom
     */

    function allAgentTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM agent ORDER BY Nom ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allAgent = array();
        while ($row = mysqli_fetch_array($result)) {
            $agent = $this->creerUnAgent($row["Id"], $row["Password"], $row["Nom"], $row["Prenom"], $row["Email"], $row["Actif"]);
            array_push($allAgent, $agent);
        }
        $bdd->fermerConnexion();
        return($allAgent);
    }

    /*
     * Recherche les agents par leur Id
     * 
     * @param $user : identifiant de l agent
     */

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

    /*
     * Vérifie l existence d un agent
     * 
     * @param $user : identifiant de l agent
     */

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

    //getter


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
