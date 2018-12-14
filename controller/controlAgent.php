<?php

namespace SGR\controller;

/*
 * Gere toute les actions lié a l'agent
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
    /*
     * Charge tout les modeles neccessaires aux actions de l agent.
     */

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

    /*
     * Charge la liste des résolution reçues dans le navigateur et fichier excel et le trasnmet a la vue
     */

    public function voirResoSoumi() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->allResolutionTrie();
        $titre = 'allResolutionSoumi';
        $this->telechargerExcel($titre, $reso);
        $this->vue->voirReso($reso, 'Liste de toutes les résolutions reçues');
    }

    /*
     * Création du fichier Excel pour les résolutions reçues
     * @param $titre : titre du fichier
     * @param $reso  : liste des résolutions reçues a copié dans le fichier Excel
     */

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

    /*
     * Création du fichier Excel pour les résolutions Décanat
     * @param $titre : titre du fichier
     * @param $reso  : liste des résolutions décanat a copié dans le fichier Excel
     */

    public function telechargerExcelDecanat($titre, $reso) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Numéro résolution');
        $sheet->setCellValue('C1', 'Séance');
        $sheet->setCellValue('D1', 'Projet');
        $sheet->setCellValue('E1', 'Résumé');
        $sheet->setCellValue('F1', 'Description');
        $sheet->setCellValue('G1', 'Campus');
        $sheet->setCellValue('H1', 'Note');
        $sheet->setCellValue('I1', 'Date');
        $y = 2;
        foreach ($reso as $value) {

            $i = 1;
            while ($i <= 10) {

                switch ($i) {
                    case 1:
                        $sheet->setCellValue('A' . $y, $value->getId());
                        break;
                    case 2:
                        $sheet->setCellValue('B' . $y, $value->getNum());
                        break;
                    case 3:
                        $sheet->setCellValue('C' . $y, $value->getNumSeance_id());
                        break;
                    case 4:
                        $sheet->setCellValue('D' . $y, $value->getNumProjet_id());
                        break;
                    case 5:
                        $sheet->setCellValue('E' . $y, $value->getResumeReso());
                        break;
                    case 6:
                        $sheet->setCellValue('F' . $y, $value->getDescription());
                        break;
                    case 7:
                        $sheet->setCellValue('G' . $y, $value->getCampus());
                        break;
                    case 8:
                        $sheet->setCellValue('H' . $y, $value->getNote());
                        break;
                    case 9:
                        $sheet->setCellValue('I' . $y, $value->getDateReso());
                        break;
                }
                $i++;
            }
            $y++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('Excel/' . $titre . '.xlsx');
    }

    /*
     * Modifie la résolutions reçues a travers les données reĉues depuis le formulaire de modification
     */

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

    /*
     * transmet uniquement les résolution non traité a la vue
     */

    public function afficherResoNontraiter() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->ResolutionParTraitement("Enregistré");
        $titre = 'ResolutionNonTraité';
        $this->telechargerExcel($titre, $reso);
        $this->vue->voirReso($reso, "Liste de toutes les résolutions non traitées");
    }

    /*
     * Transmet les résolutions selon la recherche par élément éffectué
     */

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

    /*
     * Transmet la liste des résolutiuons reçues non traité pour un agent donné a la vue
     */

    public function afficherResoPerso() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->rechercheParAgent($_SESSION["user"]);
        $titreFichier = 'rechercheParAgent_' . $_SESSION["user"];
        $this->telechargerExcel($titreFichier, $reso);
        $this->vue->voirReso($reso, "Liste des résolutions affecté a l'agent " . $_SESSION["user"]);
    }

    /*
     * tranmet la liste des résolutions Décanat trié par id a la vue
     */

    public function afficherResoDecanat() {
        $_SESSION["count"] = 0;
        $reso = $this->modelDecanatReso->allResolutionTrie();
        $titreFichier = 'allResolutionDecanat';
        $this->telechargerExcelDecanat($titreFichier, $reso);
        $this->vue->voirResoDecanat($reso, "Liste de toutes les résolutions Décanat:");
        ;
    }

    /*
     * Transmet toute les informations neccéssaire a la vue pour le traitement d une résolutions Décanat
     */

    public function traiterReso() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelReceptionReso->rechercheResoParId($id);
        $programmeReso = $this->modelProg->programmeAssocier($id);
        $courReso = $this->modelCour->courAssocier($id);
        $departement = $this->modelDepartement->allDepartementTrie();
        $typeRecu = $this->modelTypeResolution->rechercheTypeParReso($id);
        $type = $this->modelTypeResolution->allTypeResoTrie();
        $seance = $this->modelSeance->allSeanceTrie();
        $resoDeca = $this->modelDecanatReso->rechercheAssociationTypeReso($id);
        $this->vue->traiterReso($reso, $programmeReso, $courReso, $typeRecu, $seance, $type, $resoDeca);
    }

    /*
     * Création de la requete SQL selon les modifications par l user souhaité sur la résolutions reçues  
     */

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
        if ($_POST['traitement'] != '') {
            $traitement = $_POST['traitement'];
            $sqlPart1 = $sqlPart1 . "Traitement='$traitement',";
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

    /*
     * Création d'une nouvelle résolution Décanat et mise a jour des tables en relation avec la ésolutions Décanat
     */

    public function enregistrementReso() {
        $this->modelDecanatReso->nouvelleResoDecanat($_POST["num"], $_POST["numInstance"], $_POST["seance"], $_GET["id_projet"], $_POST["resumeReso"], $_POST["descReso"], $_POST["campus"], $_POST["noteReso"]);
        $deca = $this->modelDecanatReso->rechercheResoParNumReception($_POST["num"]);
        $id = $deca->getId();
        $resoRecu = $this->modelReceptionReso->rechercheResoParId($_GET['id']);
        $this->modelDecanatReso->assocDecanatRecu($_GET['id'], $id);
        $this->modelDecanatReso->associationTypeReso($id, $_POST['type']);
        $this->modelDecanatReso->associationUgp($id, $resoRecu->getCodeUgp_id());
        $date = date("Y-m-d");
        $traitement = 'Enregistré et associé à la résolution Décanat id: ' . $id;
        $this->modelReceptionReso->updateAssociationResoDecanat($_GET['id'], $traitement, $date, $_SESSION['user']);
    }

    /*
     * Transmet la résolution Décanat avec l id souhaité a la vue 
     */

    public function resolutionDecanatComplete() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelDecanatReso->rechercheResoParId($id);
        $this->vue->afficherUneResolutionDecanat($reso);
    }

    /*
     * Construction de la requete sql selon la recherche faite et transmision de la liste des résolutions a la vue 
     */

    public function traitementRecherche() {
        $_SESSION["count"] = 0;
        $sql = "SELECT * FROM receptionreso WHERE";
        $_SESSION['recherche'] = "Liste des résolutions reçues avec les caractéristiques suivante:<br>";
        $titreFichier = "recherchePar";
        if (isset($_POST['departement'])) {
            $departement = $_POST['departement'];
            $sql = $sql . " Departement_id='$departement' AND";
            $_SESSION['recherche'] = $_SESSION['recherche'] . 'Département:' . $departement . '<br> ';
            $titreFichier = $titreFichier . 'Departement_' . $departement;
        }
        if (isset($_POST['ugp'])) {
            $ugp = $_POST['ugp'];
            $sql = $sql . " CodeUgp_id='$ugp' AND";
            $_SESSION['recherche'] = $_SESSION['recherche'] . 'Ugp:' . $ugp . '<br> ';
            $titreFichier = $titreFichier . 'Ugp_' . $ugp;
        }


        if ($_SESSION['nbDateRecherche'] == 2) {
            $d1 = $_POST['date1'];
            $d2 = $_POST['date2'];
            $_SESSION['recherche'] = $_SESSION['recherche'] . 'Date: entre ' . $d1 . ' et ' . $d2 . '<br> ';
            $sql = $sql . " DateReception BETWEEN '$d1' AND '$d2'";
            $titreFichier = $titreFichier . 'Date_Entre_' . $d1 . '_Et_' . $d2;
        } else if ($_SESSION['nbDateRecherche'] == 1) {
            $d1 = $_POST['date1'];
            $sql = $sql . " DateReception='$d1'";
            $_SESSION['recherche'] = $_SESSION['recherche'] . 'Date:' . $d1 . '<br> ';
            $titreFichier = $titreFichier . 'Date_' . $d1;
        }

        $reso = $this->modelReceptionReso->rechercheParSql($sql);
        $this->vue->voirReso($reso, $_SESSION['recherche']);
    }

}
