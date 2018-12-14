<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class ReceptionReso {

    private $id;
    private $num;
    private $sujet;
    private $numProjet_id;
    private $dateDemande;
    private $dateReception;
    private $traitement;
    private $notes;
    private $departement_id;
    private $codeUgp_id;
    private $agent_id;

    function __construct() {
        
    }

    function creerReceptionReso($i, $n, $s, $np, $dd, $dr, $t, $nt, $d, $c, $a) {
        $reso = new ReceptionReso();
        $reso->id = $i;
        $reso->num = $n;
        $reso->sujet = $s;
        $reso->numProjet_id = $np;
        $reso->dateDemande = $dd;
        $reso->dateReception = $dr;
        $reso->traitement = $t;
        $reso->notes = $nt;
        $reso->departement_id = $d;
        $reso->codeUgp_id = $c;
        $reso->agent_id = $a;
        return ($reso);
    }

    function nouvelleReso($num, $sujet, $projet, $note, $departement, $ugp, $traitement) {
        $bdd = new ConnexionBDD();
        $date = date("Y-m-d");
        $sql = "INSERT INTO receptionReso (NumReception, Sujet, NumProjet_id, DateReception,Traitement,Notes,Departement_id,codeUgp_id) VALUES ('$num','$sujet','$projet','$date','$traitement','$note','$departement','$ugp')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function associationProgramme($idReso, $idProg) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO programme_receptionreso (programme_id, receptionReso_id) VALUES ('$idProg',$idReso)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function associationCour($idReso, $idCour) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO cour_receptionreso (cour_id, receptionReso_id) VALUES ('$idCour',$idReso)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function associationTypeReso($id, $type) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO typeresolution_receptionreso (TypeReso_id, NumReception_id) VALUES ('$type',$id)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function updateReso($sql) {
        $bdd = new ConnexionBDD();
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function updateAssociationCour($idReso, $codeCour, $codeOldCour) {
        $bdd = new ConnexionBDD();
        $sql = "UPDATE cour_receptionreso SET cour_id='$codeCour' WHERE cour_id='$codeOldCour' AND receptionReso_id=$idReso";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function updateAssociationProgramme($idReso, $codeProgramme, $codeOldProgramme) {
        $bdd = new ConnexionBDD();
        $sql = "UPDATE programme_receptionreso SET programme_id='$codeProgramme' WHERE programme_id='$codeOldProgramme' AND receptionReso_id=$idReso";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function updateAssociationResoDecanat($id, $traitement, $dateReception,$agent) {
         $bdd = new ConnexionBDD();
        $sql = "UPDATE receptionreso SET Traitement='$traitement', DateDemande='$dateReception',agent_id='$agent' WHERE id=$id";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    function rechercheResoParId($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE id=$id";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
        }
        $bdd->fermerConnexion();
        return($reso);
    }

    function rechercheResoParNumReception($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE NumReception='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
        }
        $bdd->fermerConnexion();
        return($reso);
    }

    function allResolutionTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso ORDER BY Id ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function ResolutionParTraitement($traitement) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE Traitement='$traitement'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParUgp($ugp) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE CodeUgp_id= '$ugp'ORDER BY Id ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParAgent($agent) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE agent_id= '$agent'ORDER BY Id ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParDate($date) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE  DATE_format(DateReception,'%Y')='$date'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParMot($mot) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE  Sujet LIKE '%$mot%'  ";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParProgramme($prog) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT DISTINCT receptionReso_id FROM programme_receptionreso WHERE programme_id= '$prog'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->rechercheResoParId($row['receptionReso_id']);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    function rechercheParCour($cour) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT DISTINCT receptionReso_id FROM cour_receptionreso WHERE cour_id= '$cour'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->rechercheResoParId($row['receptionReso_id']);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }
    
    function rechercheParSql($sql){
         $bdd = new ConnexionBDD();
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso =  $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
        
    }

    function getId() {
        return $this->id;
    }

    function getNum() {
        return $this->num;
    }

    function getSujet() {
        return $this->sujet;
    }

    function getNumProjet_id() {
        return $this->numProjet_id;
    }

    function getDateDemande() {
        return $this->dateDemande;
    }

    function getDateReception() {
        return $this->dateReception;
    }

    function getTraitement() {
        return $this->traitement;
    }

    function getNotes() {
        return $this->notes;
    }

    function getDepartement_id() {
        return $this->departement_id;
    }

    function getCodeUgp_id() {
        return $this->codeUgp_id;
    }

    function getAgent_id() {
        return $this->agent_id;
    }

}
