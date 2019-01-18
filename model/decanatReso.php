<?php

namespace SGR\model;

/*
 * Représente la table decanatreso (résolutions Décanat)
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

    /*
     * Constructeur
     * 
     * @param $i : identifiant de la résolution Décanat
     * @param $n : Numero de résolution
     * @param $ni : Numéro unique d'instance
     * @param $s : Seance associe a la resolution
     * @param $np : Projet associé a la résolution
     * @param $r : Résumé de la résolution
     * @param $dr : Date de création de la résolution
     * @param $desc : Description de la résolution
     * @param $de : Date d entérinnement de la résolution
     * @param $c : Campus lié a la résolution
     * @param $not : Note (facultatif) de la résolution
     * @param $suiv : Suivi fait de la résolution
     */

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

    /*
     * Ajoute une nouvelle résolution Décanat dans la table
     * 
     * 
     * @param $n : Numero de résolution
     * @param $ni : Numéro unique d'instance
     * @param $s : Seance associe a la resolution
     * @param $np : Projet associé a la résolution
     * @param $r : Résumé de la résolution
     * @param $desc : Description de la résolution
     * @param $c : Campus lié a la résolution
     * @param $not : Note (facultatif) de la résolution
     */

    function nouvelleResoDecanat($n, $ni, $s, $np, $r, $desc, $c, $not) {
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

    /*
     * Liste de toutes les résolution décanat trié par identifiant
     */

    function allResolutionTrie() {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM decanatreso ORDER BY Id ASC";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["count"] ++;
            $reso = $this->creerDecanatReso($row["Id"], $row["NumReso"], $row["NumUniqueInstance"], $row["seance_id"], $row["projet_id"], $row["ResumeReso"], $row["DateReso"], $row["DescriptionReso"], $row["DateEffective"], $row["Campus"], $row["Note"], $row["VariaSuivi"]);
            array_push($allReso, $reso);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    /*
     * Association d une résolution reçues a une résolution Décanat dans la table  receptionreso_decanatreso
     * 
     * @param $idrecu : Identifiant de la résolution reçue
     * @param $idDecanat : Identifiant de la résolution décanat
     */

    function assocDecanatRecu($idRecu, $idDecanat) {
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

    /*
     * Association d une résolution Décanat a un type dans la table  typeresolution_decanatreso
     * 
     * @param $type : Type de la résolution
     * @param $id : Identifiant de la résolution décanat
     */

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

    /*
     * Association d une résolution Décanat a un UGP dans la table ugp_decanatreso
     * 
     * @param $ugp : ugp a associé a la résolution
     * @param $id : Identifiant de la résolution décanat
     */

    function associationUgp($id, $ugp) {
        $bdd = new ConnexionBDD();
        $sql = "INSERT INTO ugp_decanatreso(ugp_id, decanat_id) VALUES ('$ugp',$id)";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution créé";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
    }

    /*
     * Recherche les résolution décanat associé a une résolution reçue en particuliere
     * 
     *
     * @param $idRecu : Identifiant de la résolution reçue
     */

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
    
     function rechercheAssociationResoRecu($idDecanat) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM  receptionreso_decanatreso WHERE decanatReso_id=$idDecanat";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $allReso = array();
        while ($row = mysqli_fetch_array($result)) {

            array_push($allReso, $row["receptionReso_id"]);
        }
        $bdd->fermerConnexion();
        return($allReso);
    }

    /*
     * Recherche une résolution Décanat par son identifiant
     * 
     * 
     * @param $id : Identifiant de la résolution décanat
     */

    function rechercheResoParId($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM decanatReso WHERE Id=$id";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
            $reso = $this->creerDecanatReso($row["Id"], $row["NumReso"], $row["NumUniqueInstance"], $row["seance_id"], $row["projet_id"], $row["ResumeReso"], $row["DateReso"], $row["DescriptionReso"], $row["DateEffective"], $row["Campus"], $row["Note"], $row["VariaSuivi"]);
        }
        $bdd->fermerConnexion();
        return($reso);
    }

    /*
     * Recherche une résolution Décanat par son Numéro de résolution
     * 
     * 
     * @param $id : Numéro de la résolution décanat
     */

    function rechercheResoParNumReception($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM decanatReso WHERE NumReso='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
            $reso = $this->creerDecanatReso($row["Id"], $row["NumReso"], $row["NumUniqueInstance"], $row["seance_id"], $row["projet_id"], $row["ResumeReso"], $row["DateReso"], $row["DescriptionReso"], $row["DateEffective"], $row["Campus"], $row["Note"], $row["VariaSuivi"]);
        }
        $bdd->fermerConnexion();
        return($reso);
    }
    
     function enterinerResoSansNote($id,$traitement){
         $bdd = new ConnexionBDD();
          $date = date("Y-m-d");
        $sql = "UPDATE decanatreso SET VariaSuivi='$traitement', DateEffective='$date'  WHERE id=$id";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
        
    }
     function enterinerResoAvecNote($id,$traitement,$note){
         $bdd = new ConnexionBDD();
          $date = date("Y-m-d");
        $sql = "UPDATE decanatreso SET VariaSuivi='$traitement', DateEffective='$date', Note='$note'  WHERE id=$id";
        $msg = '';
        if (mysqli_query($bdd->getConnexionBDD(), $sql)) {
            $msg = "Résolution modifiée";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($bdd->getConnexionBDD());
        }
        $bdd->fermerConnexion();
        return $msg;
        
    }
    //getter
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
