<?php

namespace SGR\model;

/*
 * Représente la table receptionReso (résolution décanat)
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

    /*
     * Constructeur
     * 
     * 
     * @param $i : id de la résolution
     * @param $n : Numero de la résolution
     * @param $s : sujet de la résolution
     * @param $np :Numéro du projet associé (id)
     * @param $dd: Date de la demande
     * @param $dr : Date de reception par la décanat
     * @param $t : etat du traitement de la résolution
     * @param $nt : Note facultatif de la résolution
     * @param $d : departement associé a la résolution (numéro departement)
     * @param $c : ugp associé a la résolution (code)
     * @param $a: agent associé a la résolution (id)
     */

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

    /*
     * Ajoute une nouvelle résolution Décanat
     * 
     * 
     *
     * @param $num : Numero de la résolution
     * @param $note : Note facultatif de la résolution
     * @param $departement : departement associé a la résolution (numéro departement)
     * @param $ugp : ugp associé a la résolution (code)
     * @param $traitement: agent associé a la résolution (id)
     */

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

    /*
     * Ajoute une association entre un programe et une résolution décanat dans la table programme_receptionreso
     * 
     * 
     *
     * @param $idReso : Id de la résolution Décanat
     * @param $idProgramme : id du programme 
     */

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

    /*
     * Ajoute une association entre un cours et une résolution décanat dans la table cour_receptionreso
     * 
     * 
     *
     * @param $idReso : Id de la résolution Décanat
     * @param $idCour : id du cours (sigle) 
     */

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

    /*
     * Ajoute une association entre un type de résolution et une résolution décanat dans la table typeResolution_receptionreso
     * 
     * 
     *
     * @param $idReso : Id de la résolution Décanat
     * @param $type : Type de la résolution
     */

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

    /*
     * Met a jour une résolution décanat
     * 
     * 
     *
     * @param $sql : requete UPDATE souhaité
     */

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

    /*
     * Met a jour une association cours a résolution Décanat
     * 
     * 
     *
     * @param $idReso : Id de la résolution Décanat
     * @param $codeCour : id(sigle) du  nouveau cours a associé
     * @param $codeOldCour : id (sigle) du cours a modifié
     */

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

    /*
     * Met a jour une association programme a résolution Décanat
     * 
     * 
     *
     * @param $idReso : Id de la résolution Décanat
     * @param $codeProgramme : id(code) du  nouveau programme a associé
     * @param $codeOldProgramme : id (code) du programme a modifié
     */

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

    /*
     * Met a jour une résolution Décanat lors lors de la 1er actions prise par un agent
     * 
     * 
     *
     * @param $id : Id de la résolution Décanat
     * @param $traitement : nouvelle etat du traitement de la résolution
     * @param $DateReception : Date du jour
     *  @param $agent : id de l'agent
     */

    function updateAssociationResoDecanat($id, $traitement, $dateReception, $agent) {
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

    /*
     * Recherche une résolution par son id
     * 
     * 
     *
     * @param $id : Id de la résolution Décanat
     */

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

    /*
     * Recherche une résolution par son numéro de reception
     * 
     * 
     *
     * @param $id : Numéro de reception de la résolution Décanat
     */

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
    
    
    function verifierResoParNumReception($id) {
        $bdd = new ConnexionBDD();
        $sql = "SELECT * FROM receptionreso WHERE NumReception='$id'";
        $result = mysqli_query($bdd->getConnexionBDD(), $sql);
        $verif=false;
        $reso = new ReceptionReso();
        while ($row = mysqli_fetch_array($result)) {
             $verif=true;
            $reso = $this->creerReceptionReso($row["id"], $row["NumReception"], $row["Sujet"], $row["NumProjet_id"], $row["DateDemande"], $row["DateReception"], $row["Traitement"], $row["Notes"], $row["Departement_id"], $row["codeUgp_id"], $row["agent_id"]);
        }
        $bdd->fermerConnexion();
        return($verif);
    }

    /*
     * Regroupe toute les résolution de la table trié en ordre croissant par id
     * 
     * 
     *
     */

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

    /*
     * Recherche la liste des résolutions pour un etat de traitement donné
     * 
     * 
     *
     * @param $traitement : etat de traitement de la résolution
     */

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

    /*
     * Recherche une liste de résolution par leur ugp
     * 
     * 
     *
     * @param $ugp : UGP de la résolution Décanat
     */

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

    /*
     * Recherche la liste des résolution par rapport a l'agent associé
     * 
     * 
     *
     * @param $agent : Id de l'agent
     */

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

    /*
     * Recherche la liste des résolution par leur date de reception
     * 
     * 
     *
     * @param $date : Date de reception
     */

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

    /*
     * Recherche la liste des résolution qui contiennent un mot dans leur descrption
     * 
     * 
     *
     * @param $mot: Mot a rechercher
     */

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

    /*
     * Recherche la liste des résolution par leur code de programme associé
     * 
     * 
     *
     * @param $prog : Code programme recherché
     */

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

    /*
     * Recherche la liste des résolutions par leur cours associé
     * 
     * 
     *
     * @param $cour : Sigle du cours recherché
     */

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

    /*
     * Recherche la liste des résolutions par une requete sql donné
     * 
     * 
     *
     * @param $sql : requete SELECT voulu
     */

    function rechercheParSql($sql) {
        $bdd = new ConnexionBDD();
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
    
    
    function enterinerResoSansNote($id,$traitement){
         $bdd = new ConnexionBDD();
        $sql = "UPDATE receptionreso SET Traitement='$traitement'  WHERE id=$id";
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
        $sql = "UPDATE receptionreso SET Traitement='$traitement',  Notes='$note'  WHERE id=$id";
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
