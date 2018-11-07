<?php

namespace SGR\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\view\VuePublique;
use SGR\model\Cour;
use SGR\model\Programme;
use SGR\model\Ugp;
use SGR\model\Agent;
use SGR\model\Projet;
use SGR\model\ReceptionReso;
use SGR\model\Departement;

class controlPublique {

    private $vue;
    private $modelCour;
    private $modelProg;
    private $modelUgp;
    private $modelProjet;
    private $modelReceptionReso;
    private $modelDepartement;
    private $modelAgent;

    function __construct() {
        $this->vue = new VuePublique();
        $this->modelCour = new Cour();
        $this->modelProg = new Programme();
        $this->modelUgp = new Ugp();
        $this->modelAgent = new Agent();
        $this->modelProjet = new Projet();
        $this->modelReceptionReso = new ReceptionReso();
        $this->modelDepartement = new Departement();
    }

    public function accueil() {
        $this->vue->afficherAccueil();
    }

    public function preFormulaireReso() {
        $this->vue->afficherPreFormulaireRésolution(10, 10);
    }

    public function formulaireReso() {
        echo ('<form action="index.php?action=traitementReso" class="formReso" id="formReso" method="POST">');
        if ($_POST["projet"] == "non") {
            $_SESSION['projet'] = "oui";
            $this->vue->afficherFormulaireProjet();
        } else {
            $_SESSION['projet'] = "non";
        }

        $_SESSION['nbCour'] = $_POST['cour'];
        $_SESSION['nbProgramme'] = $_POST['programme'];
        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $projet = $this->modelProjet->allProjetTrie();
        $departement = $this->modelDepartement->allDepartementTrie();
        $this->vue->afficherFormulaireResolution($cour, $prog, $ugp, $projet, $departement);
    }

    public function traitementReso() {
        $idProjet = null;
        if ($_SESSION['projet'] == "oui") {
            $descrip = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
            $noteProjet = filter_var($_POST["noteProjet"], FILTER_SANITIZE_STRING);
            $lien = filter_var($_POST["lien"], FILTER_SANITIZE_STRING);
            $idProjet = $this->modelProjet->nouveauProjet($descrip, $_POST["etat"], $noteProjet, $lien);
        }
        $numReso = filter_var($_POST["num"], FILTER_SANITIZE_STRING);
        $sujetReso = filter_var($_POST["sujet"], FILTER_SANITIZE_STRING);
        $ugp = filter_var($_POST["ugp"], FILTER_SANITIZE_STRING);
        $noteReso = filter_var($_POST["noteReso"], FILTER_SANITIZE_STRING);
        $departement = filter_var($_POST["departement"], FILTER_SANITIZE_STRING);
        if ($idProjet == null) {
            $idProjet = $_POST["projet"];
        }
        $this->modelReceptionReso->nouvelleReso($numReso, $sujetReso, $idProjet, $noteReso, $departement, $ugp);
        $id= $this->modelReceptionReso->rechercheResoParNumReception($numReso);
        if ($_SESSION['nbCour'] != "none") {
            for ($i = 1; $i <= $_SESSION['nbCour']; $i++) {
                $this->modelReceptionReso->associationCour($id->getId(), $_POST["cour" . $i]);
            }
        }
        if ($_SESSION['nbProgramme'] != "none") {
            for ($i = 1; $i <= $_SESSION['nbCour']; $i++) {
                $this->modelReceptionReso->associationProgramme($id->getId(), $_POST["programme" . $i]);
            }
        }
    }

    public function rechercheReso() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->allResolutionTrie();
        $this->vue->rechercheResolution($reso);
    }

    public function resolutionComplete() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelReceptionReso->rechercheResoParId($id);
        $programme = $this->modelProg->programmeAssocier($id);
        $cour = $this->modelCour->courAssocier($id);
        $this->vue->afficherUneResolution($reso, $programme, $cour);
    }

    function rechercheParType() {
        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $agent = $this->modelAgent->allAgentTrie();
        $departement = $this->modelDepartement->allDepartementTrie();
        $this->vue->rechercheParType($cour, $prog, $ugp, $departement, $agent);
    }

    function resultatRechercheParType() {
        $_SESSION["count"] = 0;
        if (isset($_GET["type"])) {
            switch ($_GET["type"]) {
                case "ugp":
                    $_SESSION['recherche'] = 'affiliées a l' . "'" . 'UGP ' . $_POST["element"];
                    $reso = $this->modelReceptionReso->rechercheParUgp($_POST["element"]);
                    $this->vue->rechercheResolutionParType($reso);
                    break;
                case "programme":
                    $programme = $this->modelProg->chercherUnProgramme($_POST["element"]);
                    $_SESSION['recherche'] = 'affiliées au programme ' . $_POST["element"] . ' (' . $programme->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParProgramme($_POST["element"]);
                    $this->vue->rechercheResolutionParType($reso);
                    break;
                case "cour":
                    $cour = $this->modelCour->chercherUnCour($_POST["element"]);
                    $_SESSION['recherche'] = 'affiliées au cour ' . $_POST["element"] . ' (' . $cour->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParCour($_POST["element"]);
                    $this->vue->rechercheResolutionParType($reso);
                    break;
                case "agent":
                    $agent = $this->modelAgent->rechercheParId($_POST["element"]);
                    $_SESSION['recherche'] = 'Traitées par ' . $agent->getPrenom().' '.$agent->getNom();
                    $reso = $this->modelReceptionReso->rechercheParAgent($_POST["element"]);
                    $this->vue->rechercheResolutionParType($reso);
                    break;
                default:
                    header('Location: index.php?action=voirReso');
            }
        }
    }

    public function projetComplet() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
        $projet = $this->modelProjet->rechercheProjetParId($id);

        $this->vue->afficherUnProjet($projet);
    }

}
