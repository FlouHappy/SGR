<?php

namespace SGR\model;

/*
 * Gere la table typeResolution
 */

use SGR\model\ConnexionBDD;

class typeResolution {

    private $type;
    private $priorite;
    private $lien;
    private $idReso;

    /*
     * Constructeur par défaut
     * 
     * 
     */

    function __construct() {
        
    }

    /*
     * Constructeur alternatif
     * * @param $t : Type de la résolution
     * @param $p : Priorité selon le type
     * @param $l : lien (URL/repertoire) vers les informations concernant ce type de résolution
     * 
     * 
     */

    private function creerTypeReso($t, $p, $l) {
        $typeReso = new typeResolution();
        $typeReso->type = $t;
        $typeReso->priorite = $p;
        $typeReso->lien = $l;
        return ($typeReso);
    }

    /*
     * Constructeur alternatif
     * * @param $t : Type de la résolution
     * @param $id :Id de la résolution(reçues ou decanat) associé a ce type de résolution
     * 
     * 
     */

    private function creerTypeResoAssoc($t, $id) {
        $typeReso = new typeResolution();
        $typeReso->type = $t;
        $typeReso->idReso = $id;
        return ($typeReso);
    }

     /*
     * Liste de tout les types de résolution de la table trié par type
     * 
     * 
     */
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
 /*
     * Crecherche le type d'une résolution dans la table typeresolution_receptionreso
  * 
     * @param $idReso : id de la résolution a cherché
     * 
     * 
     */
    function rechercheTypeParReso($idReso) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM typeresolution_receptionreso WHERE NumReception_id=$idReso";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $type = new typeResolution();
        while ($row = mysqli_fetch_array($result)) {
            $type = $this->creerTypeResoAssoc($row["TypeReso_id"], $row["NumReception_id"]);
        }

        $bdd->fermerConnexion();
        return($type);
    }

    //getter
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
