<?php

namespace SGR\model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\model\ConnexionBDD;

class typeResolution {

    private $type;
    private $priorite;
    private $lien;
    private $idReso;

    function __construct() {
        
    }

    private function creerTypeReso($t, $p, $l) {
        $typeReso = new typeResolution();
        $typeReso->type = $t;
        $typeReso->priorite = $p;
        $typeReso->lien = $l;
        return ($typeReso);
    }
    
    private function creerTypeResoAssoc($t, $id) {
        $typeReso = new typeResolution();
        $typeReso->type = $t;
        $typeReso->idReso=$id;
        return ($typeReso);
    }

    function allTypeResoTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM typeresolution ORDER BY TypeReso ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allTypeReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $typeReso = $this->creerTypeReso($row["TypeReso"], $row["Priorite"], $row["LienProcedure"]);
            array_push($allTypeReso, $typeReso);
        }
        $bdd->fermerConnexion();
        return($allTypeReso);
    }
    
    function rechercheTypeParReso($idReso){
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM typeresolution_receptionreso WHERE NumReception_id=$idReso";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $type= new typeResolution();
        while ($row = mysqli_fetch_array($result)) {
            $type = $this->creerTypeResoAssoc($row["TypeReso_id"], $row["NumReception_id"]);
        }
        
        $bdd->fermerConnexion();
        return($type);
        
        
    }
    
    
    function getIdReso() {
        return $this->idReso;
    }

        function getType() {
        return $this->type;
    }

    function getPriorite() {
        return $this->priorite;
    }

    function getLien() {
        return $this->lien;
    }


}
