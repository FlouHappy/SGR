<?php

namespace SGR\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\view\VueAgent;
use SGR\model\Agent;
use SGR\model\Cour;
use SGR\model\Programme;
use SGR\model\Ugp;
use SGR\model\DecanatReso;
use SGR\model\Projet;
use SGR\model\ReceptionReso;
use SGR\model\Departement;
use SGR\model\typeResolution;
use SGR\model\seance;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class controlAgent {

    private $vue;
    private $modelCour;
    private $modelProg;
    private $modelUgp;
    private $modelProjet;
    private $modelReceptionReso;
    private $modelDepartement;
    private $modelAgent;
    private $modelTypeResolution;
    private $modelSeance;
    private $modelDecanatReso;

    function __construct() {
        $this->vue = new VueAgent();
        $this->modelCour = new Cour();
        $this->modelProg = new Programme();
        $this->modelUgp = new Ugp();
        $this->modelAgent = new Agent();
        $this->modelProjet = new Projet();
        $this->modelReceptionReso = new ReceptionReso();
        $this->modelDepartement = new Departement();
        $this->modelTypeResolution = new typeResolution();
        $this->modelSeance = new Seance();
        $this->modelDecanatReso = new DecanatReso();
    }

    public function accueil() {
        $_SESSION["count"] = 0;
        $this->vue->afficherAccueil();
    }

    public function voirResoSoumi() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->allResolutionTrie();
        $titre = 'allResolutionSoumi';
        $this->telechargerExcel($titre, $reso);
        $this->vue->voirReso($reso, 'Liste de toutes les résolutions reçues');
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
        $sheet->setCellValue('J1', 'agent_id');
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
                        $sheet->setCellValue('J' . $y, $value->getAgent_id());
                        break;
                }
                $i++;
            }
            $y++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('Excel/' . $titre . '.xlsx');
    }

    public function modifierResoSoumi() {
        $id = filter_var($_GET["num"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelReceptionReso->rechercheResoParId($id);
        $programmeReso = $this->modelProg->programmeAssocier($id);
        $courReso = $this->modelCour->courAssocier($id);

        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $projet = $this->modelProjet->allProjetTrie();
        $departement = $this->modelDepartement->allDepartementTrie();
        $type = $this->modelTypeResolution->rechercheTypeParReso($id);
        $this->vue->afficherFormulaireModif($reso, $programmeReso, $courReso, $cour, $prog, $ugp, $projet, $departement, $type);
    }

    public function afficherResoNontraiter() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->ResolutionParTraitement("Enregistré");
        $titre = 'ResolutionNonTraité';
        $this->telechargerExcel($titre, $reso);
        $this->vue->voirReso($reso, "Liste de toutes les résolutions non traitées");
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
            $this->vue->voirReso($reso, "Liste des résolutions concernées par le " . $_GET['type'] . ": " . $_POST["element"]);
        }
    }

    public function afficherResoPerso() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->rechercheParAgent($_SESSION["user"]);
        $titreFichier = 'rechercheParAgent_' . $_SESSION["user"];
        $this->telechargerExcel($titreFichier, $reso);
        $this->vue->voirReso($reso, "Liste des résolutions affecté a l'agent " . $_SESSION["user"]);
    }

    public function traiterReso() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelReceptionReso->rechercheResoParId($id);
        $programmeReso = $this->modelProg->programmeAssocier($id);
        $courReso = $this->modelCour->courAssocier($id);
        $departement = $this->modelDepartement->allDepartementTrie();
        $typeRecu = $this->modelTypeResolution->rechercheTypeParReso($id);
        $type= $this->modelTypeResolution->allTypeResoTrie();
        $seance = $this->modelSeance->allSeanceTrie();
        $resoDeca= $this->modelDecanatReso->rechercheAssociationTypeReso($id);
        $this->vue->traiterReso($reso, $programmeReso, $courReso, $typeRecu, $seance,$type,$resoDeca);
    }

    public function traitementModifResoSoumi() {
        $reso = $this->modelReceptionReso->rechercheResoParId($_GET["id"]);
        $sqlPart1 = "";

        if ($_POST['num'] != '') {
            $num = $_POST['num'];
            $sqlPart1 = $sqlPart1 . "NumReception='$num',";
        }


        if ($_POST['sujet'] != '') {
            $sujet = $_POST["sujet"];
            $sqlPart1 = $sqlPart1 . "Sujet='$sujet',";
        }
        if ($_POST['projet'] != '') {
            $projet = $_POST['projet'];
            $sqlPart1 = $sqlPart1 . "NumProjet_id=$projet,";
        }
        if ($_POST['noteReso'] != '') {
            $noteReso = $_POST['noteReso'];
            $sqlPart1 = $sqlPart1 . "Notes='$noteReso',";
        }
        if ($_POST['departement'] != '') {
            $departement = $_POST['departement'];
            $sqlPart1 = $sqlPart1 . "Departement_id='$departement',";
        }


        if ($_POST['ugp'] != '') {
            $ugp = $_POST['ugp'];
            $sqlPart1 = $sqlPart1 . "codeUgp_id='$ugp',";
        }


        $sqlPart1 = substr($sqlPart1, 0, -1);
        $sql = "UPDATE receptionReso SET " . $sqlPart1 . " WHERE id=" . $reso->getId();
        $this->modelReceptionReso->updateReso($sql);

        for ($i = 1; $i <= $_GET['nbCour']; $i++) {
            if ($_POST["cour" . $i] != '') {
                $idOldCour = $_SESSION['courReso' . $i];
                $this->modelReceptionReso->updateAssociationCour($_GET['id'], $_POST["cour" . $i], $idOldCour);
            }
        }

        for ($i = 1; $i <= $_GET['nbProg']; $i++) {
            if ($_POST["programme" . $i] != '') {
                $idOldProgramme = $_SESSION['programmeReso' . $i];
                echo($this->modelReceptionReso->updateAssociationProgramme($_GET['id'], $_POST["programme" . $i], $idOldProgramme));
            }
        }
    }

    public function enregistrementReso() {
        $this->modelDecanatReso->nouvelleResoDecanat($_POST["num"], $_POST["numInstance"], $_POST["seance"], $_GET["id_projet"], $_POST["resumeReso"], $_POST["descReso"], $_POST["campus"], $_POST["noteReso"]);
        $deca=$this->modelDecanatReso->rechercheResoParNumReception($_POST["num"]);
        $id=$deca->getId();
        $this->modelDecanatReso->assocDecanatRecu($_GET['id'],$id);
        $this->modelDecanatReso->associationTypeReso($id, $_POST['type']);
        
        
        
    }

}
