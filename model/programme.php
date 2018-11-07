<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class Programme {

    private $code;
    private $nom;
    private $type;
    private $ugp;

    function __construct() {
        
    }

    function creerProgramme($c, $n, $t,$u) {
        $prog = new Programme();
        $prog->code = $c;
        $prog->nom = $n;
        $prog->type = $t;
        $prog->ugp = $u;
        return ($prog);
    }
    
    function chercherUnProgramme($id){
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programmes WHERE codeProgramme='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $prog=null;
        while ($row = mysqli_fetch_array($result)) {
            $prog= $this->creerProgramme($row["CodeProgramme"], $row["NomProgramme"],$row["TypeProgramme"],$row["codeUgp_id"]);
        }
        $bdd->fermerConnexion();
        return($prog);
        
    }
    function allProgrammeTrie(){
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programmes ORDER BY CodeProgramme ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allProg= array();
        while ($row = mysqli_fetch_array($result)) {
            $prog= $this->creerProgramme($row["CodeProgramme"], $row["NomProgramme"],$row["TypeProgramme"],$row["codeUgp_id"]);
            array_push($allProg,$prog);
        }
        $bdd->fermerConnexion();
        return($allProg);
    }
    
    function programmeAssocier($id){
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM programme_receptionreso WHERE receptionReso_id = $id";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allProg=array();
        while ($row = mysqli_fetch_array($result)) {
            $prog=$this->chercherUnProgramme($row["programme_id"]);
            array_push($allProg,$prog);
        }
        $bdd->fermerConnexion();
        return($allProg);
    }
        
    
    
    
    
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