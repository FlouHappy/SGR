<?php

namespace SGR\model;

/*
 * Représente la table Cour
 */

use SGR\model\ConnexionBDD;

class Cour {

    private $sigle;
    private $nom;
    private $cycle;

    function __construct() {
        
    }

    /*
     * Constructeur
     * 
     * @param $s : sigle du cours
     * @param $n : Nom du cours
     * @param $c : cycle du cours
     */

    function creerCour($s, $n, $c) {
        $cour = new Cour();
        $cour->sigle = $s;
        $cour->nom = $n;
        $cour->cycle = $c;
        return ($cour);
    }

    /*
     * Ajoute un nouveau cours a la table cours
     * 
     * @param $sigle : sigle du cours
     * @param $nom : Nom du cours
     * @param $cycle : cycle du cours
     */

    function nouveauCour($sigle, $nom, $cycle) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO cour (Sigle, NomCours, Cycle) VALUES ('$sigle','$nom',$cycle)";
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
     * recherche UN cours par son cycle
     * 
     * @param $id : sigle du cours
     * 
     */

    function chercherUnCour($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM cour WHERE Sigle='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $cour = null;
        while ($row = mysqli_fetch_array($result)) {
            $cour = $this->creerCour($row["Sigle"], $row["NomCours"], $row["Cycle"]);
        }
        $bdd->fermerConnexion();
        return($cour);
    }

    /*
     * Liste de tout les cours trié par sigle
     */

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

    /*
     * Liste des association de cours pour une résolution reçue
     * 
     * @param $id : Id de la résolution reçue
     */

    function courAssocier($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM cour_receptionreso WHERE receptionReso_id = $id";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allCour = array();
        while ($row = mysqli_fetch_array($result)) {
            $cour = $this->chercherUnCour($row["cour_id"]);
            array_push($allCour, $cour);
        }
        $bdd->fermerConnexion();
        return($allCour);
    }

    //Getter

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
