<?php

namespace SGR\model;

/*
 * Représente la table programme
 */

use SGR\model\ConnexionBDD;

class Programme {

    private $code;
    private $nom;
    private $type;
    private $ugp;

    function __construct() {
        
    }

    /*
     * Constructeur
     * 
     * 
     * @param $c : Code du programme
     * @param $n : Nom du programme
     * @param $t : Type du programme
     * @param $u : UGP associé au programme
     */

    function creerProgramme($c, $n, $t, $u) {
        $prog = new Programme();
        $prog->code = $c;
        $prog->nom = $n;
        $prog->type = $t;
        $prog->ugp = $u;
        return ($prog);
    }

    /*
     * Ajoute un nouveau programme a la table rpogramme
     * 
     * 
     * @param $c : Code du programme
     * @param $n : Nom du programme
     * @param $t : Type du programme
     * @param $u : UGP associé au programme
     */

    function nouveauProgramme($c, $n, $t, $u) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO programmes (CodeProgramme, NomProgramme,TypeProgramme,codeUgp_id) VALUES ('$c','$n','$t','$u')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "programme créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }

        $bdd->fermerConnexion();
        return $msg;
    }
/*
     * Cherche UN programme selon son code programme
 * @param $id : Code du programme
     */
    function chercherUnProgramme($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programmes WHERE codeProgramme='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $prog = null;
        while ($row = mysqli_fetch_array($result)) {
            $prog = $this->creerProgramme($row["CodeProgramme"], $row["NomProgramme"], $row["TypeProgramme"], $row["codeUgp_id"]);
        }
        $bdd->fermerConnexion();
        return($prog);
    }
/*
     * Liste de tout les programmes trié par leur code
     */
    function allProgrammeTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programmes ORDER BY CodeProgramme ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allProg = array();
        while ($row = mysqli_fetch_array($result)) {
            $prog = $this->creerProgramme($row["CodeProgramme"], $row["NomProgramme"], $row["TypeProgramme"], $row["codeUgp_id"]);
            array_push($allProg, $prog);
        }
        $bdd->fermerConnexion();
        return($allProg);
    }

    /*
     * cherche les programmes associéa une résolution reçues dans la table programme_receptionreso
     * 
     * 
     * @param $id : Identifiant de la résolution reçue
     */
    function programmeAssocier($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programme_receptionreso WHERE receptionReso_id = $id";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allProg = array();
        while ($row = mysqli_fetch_array($result)) {
            $prog = $this->chercherUnProgramme($row["programme_id"]);
            array_push($allProg, $prog);
        }
        $bdd->fermerConnexion();
        return($allProg);
    }

    //getter
    function getCode() {
        return $this->code;
    }

    function getNom() {
        return $this->nom;
    }

    function getType() {
        return $this->type;
    }

    function getUgp() {
        return $this->ugp;
    }

}
