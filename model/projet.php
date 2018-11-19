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
    private $agent;
    private $description;
    private $etat;
    private $note;
    private $lien;

    function __construct() {
        
    }

    function creerProjet($no,$a, $d, $e, $n, $l) {
        $projet = new Projet();
        $projet->num = $no;
        $projet->agent=$a;
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
            $projet = $this->creerProjet($row["NumProjet"],$row["agent_id"] ,$row["DescriptionProjet"], $row["EtatProjet"], $row["Notes"], $row["LienDossier"]);
            array_push($allProjet, $projet);
        }
        $bdd->fermerConnexion();
        return($allProjet);
    }
    function rechercheProjetParId($id){
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM projet WHERE NumProjet='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $projet=null;
        while ($row = mysqli_fetch_array($result)) {
            $projet= $this->creerProjet($row["NumProjet"], $row["agent_id"] ,$row["DescriptionProjet"], $row["EtatProjet"], $row["Notes"], $row["LienDossier"]);
        }
        $bdd->fermerConnexion();
        return($projet);
    }

    function chercherNumProjetParDescrip($descript) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM projet WHERE DescriptionProjet= '$descript' ";
        $projet = null;
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        while ($row = mysqli_fetch_array($result)) {
            $projet = $this->creerProjet($row["NumProjet"], $row["agent_id"] ,$row["DescriptionProjet"], $row["EtatProjet"], $row["Notes"], $row["LienDossier"]);
        }
        $bdd->fermerConnexion();
        if ($projet != null) {
            return($projet->num);
        } else {
            return ('none');
        }
    }

    function nouveauProjet($descrip, $etat, $note, $lien) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO projet (DescriptionProjet, EtatProjet, Notes, LienDossier) VALUES ('$descrip','$etat','$note','$lien')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Projet créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $sql = "SELECT NumProjet FROM projet WHERE DescriptionProjet='$descrip'AND Notes='$note'";
        $id = null;
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        while ($row = mysqli_fetch_array($result)) {
            $id = $row["NumProjet"];
        }
        $bdd->fermerConnexion();
        return $id;
    }

    function getNum() {
        return $this->num;
    }
    function getAgent(){
        return $this->agent;
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
