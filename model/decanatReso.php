<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class DecanatReso {

    private $id;
    private $num;
    private $numInstance;
    private $numSeance_id;
    private $numProjet_id;
    private $resumeReso;
    private $dateReso;
    private $description;
    private $dateEffective;
    private $campus;
    private $note;
    private $suivi;

    function __construct() {
        
    }

    function creerDecanatReso($i, $n, $ni, $s, $np, $r, $dr, $desc, $de, $c, $not, $suiv) {
        $reso = new DecanatReso();
        $reso->id = $i;
        $reso->num = $n;
        $reso->numInstance = $ni;
        $reso->numSeance_id = $s;
        $reso->numProjet_id = $np;
        $reso->resumeReso = $r;
        $reso->dateReso = $dr;
        $reso->description = $desc;
        $reso->dateEffective = $de;
        $reso->campus = $c;
        $reso->note = $not;
        $reso->suivi = $suiv;
        return ($reso);
    }
    
    function nouvelleResoDecanat( $n, $ni, $s, $np, $r, $desc, $c, $not) {
        $bdd = new ConnexionBDD();
        $date = date("Y-m-d");
        $sql = "INSERT INTO decanatreso( NumReso, NumUniqueInstance,seance_id,projet_id,ResumeReso,DateReso,DescriptionReso,Campus,Note) VALUES ('$n','$ni',$s,$np,'$r','$date','$desc','$c','$not')";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }
    
    function assocDecanatRecu($idRecu,$idDecanat){
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO receptionreso_decanatreso(receptionReso_id, decanatReso_id) VALUES ($idRecu,$idDecanat)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "association Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }
    
    function associationTypeReso($id, $type) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO typeresolution_decanatreso (TypeReso_id, NumReso_id) VALUES ('$type',$id)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }
    
     function rechercheAssociationTypeReso($idRecu) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM  receptionreso_decanatreso WHERE receptionReso_id=$idRecu";
       $result = mysqli_query($bdd->getConnexionBDD(), $sql);
       $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            
            array_push($allReso, $row["decanatReso_id"]);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }
    
    
     function rechercheResoParNumReception($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM decanatReso WHERE NumReso='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
            $reso = $this->creerDecanatReso($row["Id"], $row["NumReso"],$row["NumUniqueInstance"],$row["seance_id"], $row["projet_id"], $row["ResumeReso"], $row["DateReso"], $row["DescriptionReso"],$row["DateEffective"], $row["Campus"], $row["Note"], $row["VariaSuivi"]);
        }
        $bdd->fermerConnexion();
        return($reso);
    }
    
    
    function getId() {
        return $this->id;
    }

    function getNum() {
        return $this->num;
    }

    function getNumInstance() {
        return $this->numInstance;
    }

    function getNumSeance_id() {
        return $this->numSeance_id;
    }

    function getNumProjet_id() {
        return $this->numProjet_id;
    }

    function getResumeReso() {
        return $this->resumeReso;
    }

    function getDateReso() {
        return $this->dateReso;
    }

    function getDescription() {
        return $this->description;
    }

    function getDateEffective() {
        return $this->dateEffective;
    }

    function getCampus() {
        return $this->campus;
    }

    function getNote() {
        return $this->note;
    }

    function getSuivi() {
        return $this->suivi;
    }


}
