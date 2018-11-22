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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $traitement = "Enregistré";
        if ($idProjet == null) {
            $idProjet = $_POST["projet"];
        }
        $this->modelReceptionReso->nouvelleReso($numReso, $sujetReso, $idProjet, $noteReso, $departement, $ugp, $traitement);
        $id = $this->modelReceptionReso->rechercheResoParNumReception($numReso);
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
        $titre = 'allResolution';
        $this->telechargerExcel($titre, $reso);
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
            $reso;
            switch ($_GET["type"]) {
                case "ugp":
                    $_SESSION['recherche'] = 'affiliées a l' . "'" . 'UGP ' . $_POST["element"];
                    $reso = $this->modelReceptionReso->rechercheParUgp($_POST["element"]);

                    break;
                case "programme":
                    $programme = $this->modelProg->chercherUnProgramme($_POST["element"]);
                    $_SESSION['recherche'] = 'affiliées au programme ' . $_POST["element"] . ' (' . $programme->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParProgramme($_POST["element"]);

                    break;
                case "cour":
                    $cour = $this->modelCour->chercherUnCour($_POST["element"]);
                    $_SESSION['recherche'] = 'affiliées au cour ' . $_POST["element"] . ' (' . $cour->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParCour($_POST["element"]);

                    break;
                case "agent":
                    $agent = $this->modelAgent->rechercheParId($_POST["element"]);
                    $_SESSION['recherche'] = 'Traitées par ' . $agent->getPrenom() . ' ' . $agent->getNom();
                    $reso = $this->modelReceptionReso->rechercheParAgent($_POST["element"]);

                    break;
                case "date":
                    $_SESSION['recherche'] = " de l'année " . $_POST["element"];
                    $reso = $this->modelReceptionReso->rechercheParDate($_POST["element"]);

                    break;
                case "mot":
                    $_SESSION['recherche'] = ' contenant le mot "' . $_POST["element"] . '"';
                    $reso = $this->modelReceptionReso->rechercheParMot($_POST["element"]);

                    break;
                default:
                    header('Location: index.php?action=voirReso');
            }
            $titreFichier = 'recherchePar' . $_GET['type'] . '_' . $_POST["element"];
            $this->telechargerExcel($titreFichier, $reso);
            $this->vue->rechercheResolution($reso, $titreFichier);
        }
    }

    public function telechargerExcel($titre, $reso) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Numéro réception');
        $sheet->setCellValue('C1', 'Sujet');
        $sheet->setCellValue('D1', 'codeUgp_id');
        $sheet->setCellValue('E1', 'Departement_id');
        $sheet->setCellValue('F1', 'Date Demande');
        $sheet->setCellValue('G1', 'Date Reception');
        $sheet->setCellValue('H1', 'Notes');
        $sheet->setCellValue('I1', 'Numéro de projet');
        $sheet->setCellValue('J1', 'État');
        $sheet->setCellValue('K1', 'agent_id');
        $y = 2;
        foreach ($reso as $value) {

            $i = 1;
            while ($i <= 11) {

                switch ($i) {
                    case 1:
                        $sheet->setCellValue('A' . $y, $value->getId());
                        break;
                    case 2:
                        $sheet->setCellValue('B' . $y, $value->getNum());
                        break;
                    case 3:
                        $sheet->setCellValue('C' . $y, $value->getSujet());
                        break;
                    case 4:
                        $sheet->setCellValue('D' . $y, $value->getCodeUgp_id());
                        break;
                    case 5:
                        $sheet->setCellValue('E' . $y, $value->getDepartement_id());
                        break;
                    case 6:
                        $sheet->setCellValue('F' . $y, $value->getDateDemande());
                        break;
                    case 7:
                        $sheet->setCellValue('G' . $y, $value->getDateReception());
                        break;
                    case 8:
                        $sheet->setCellValue('H' . $y, $value->getNotes());
                        break;
                    case 9:
                        $sheet->setCellValue('I' . $y, $value->getNumProjet_id());
                        break;
                    case 10:
                        $sheet->setCellValue('J' . $y, $value->getTraitement());
                        break;
                    case 11:
                        $sheet->setCellValue('K' . $y, $value->getAgent_id());
                        break;
                }
                $i++;
            }
            $y++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('Excel/' . $titre . '.xlsx');
    }

    public function projetComplet() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
        $projet = $this->modelProjet->rechercheProjetParId($id);

        $this->vue->afficherUnProjet($projet);
    }

    public function allProjet() {
        $allProjet = $this->modelProjet->allProjetTrie();
        $this->vue->afficherProjet($allProjet);
    }

    public function allCour() {
        $allCour = $this->modelCour->allCourTrie();
        $this->vue->afficherCour($allCour);
    }

    public function allProgramme() {
        $allProg = $this->modelProg->allProgrammeTrie();
        $this->vue->afficherProgramme($allProg);
    }

    public function formulaireCour() {
        $this->vue->afficherFormulaireCour();
    }

    public function traitementCour() {
        $sigle = filter_var($_POST["sigle"], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
        $cycle = filter_var($_POST["cycle"], FILTER_SANITIZE_NUMBER_INT);
        $this->modelCour->nouveauCour($sigle, $nom, $cycle);
        $this->vue->afficherResulatCreation('Cour');
    }

    public function formulaireProgramme() {
        $ugp = $this->modelUgp->allUgpTrie();
        $this->vue->afficherFormulaireProgramme($ugp);
    }

    public function traitementProgramme() {

        $code = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
        $this->modelProg->nouveauProgramme($code, $nom, $type, $_POST['ugp']);
        $this->vue->afficherResulatCreation('Programme');
    }

}
