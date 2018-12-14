<?php

namespace SGR\controller;

/*
 * Gere toutes les actions lié a l user public
 */

use SGR\view\VuePublique;
use SGR\model\Cour;
use SGR\model\Programme;
use SGR\model\Ugp;
use SGR\model\Agent;
use SGR\model\Projet;
use SGR\model\Seance;
use SGR\model\ReceptionReso;
use SGR\model\typeResolution;
use SGR\model\Departement;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class controlPublique {
    /*
     * Charge tout les modeles neccessaires aux actions de l user public.
     */

    private $vue;
    private $modelCour;
    private $modelProg;
    private $modelUgp;
    private $modelProjet;
    private $modelReceptionReso;
    private $modelDepartement;
    private $modelAgent;
    private $modelSeance;

    function __construct() {
        $this->vue = new VuePublique();
        $this->modelCour = new Cour();
        $this->modelProg = new Programme();
        $this->modelUgp = new Ugp();
        $this->modelAgent = new Agent();
        $this->modelProjet = new Projet();
        $this->modelReceptionReso = new ReceptionReso();
        $this->modelDepartement = new Departement();
        $this->modelTypeReso = new typeResolution();
        $this->modelSeance = new Seance();
    }

    /*
     * page d accueil public
     */

    public function accueil() {
        $this->vue->afficherAccueil();
    }

    /*
     * demande a la vue d afficher le pré-formulaire des résolutions reçues
     */

    public function preFormulaireReso() {
        $this->vue->afficherPreFormulaireRésolution(10, 10);
    }

    /*
     * demande a la vue d afficher le formulaire adapté selon les choix fait dans le pré-formulaire
     */

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
        $typeReso = $this->modelTypeReso->allTypeResoTrie();
        $departement = $this->modelDepartement->allDepartementTrie();
        $this->vue->afficherFormulaireResolution($cour, $prog, $ugp, $projet, $departement, $typeReso);
    }

    /*
     * Traitement des informations du formulaire de cration de résolutions reçues et cré la résolution
     */

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
        $this->modelReceptionReso->associationTypeReso($id->getId(), $_POST["type"]);
    }

    /*
     * transmet la liste de toutes les résolutions reçues trié par id a la vue
     */

    public function rechercheReso() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->allResolutionTrie();
        $titre = 'allResolution';
        $_SESSION['recherche'] = 'Liste de toutes les résolutions reçues';
        $this->telechargerExcel($titre, $reso);
        $this->vue->rechercheResolution($reso, $titre);
    }

    /*
     * demande a la vue d afficher UNE résolution reçue en détail
     */

    public function resolutionComplete() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
        $reso = $this->modelReceptionReso->rechercheResoParId($id);
        $programme = $this->modelProg->programmeAssocier($id);
        $cour = $this->modelCour->courAssocier($id);
        $this->vue->afficherUneResolution($reso, $programme, $cour);
    }

    /*
     * demande a la vue d afficher le formulaire de recherche des résolutions reçues par élément 
     */

    function rechercheParType() {
        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $agent = $this->modelAgent->allAgentTrie();
        $departement = $this->modelDepartement->allDepartementTrie();
        $this->vue->rechercheParType($cour, $prog, $ugp, $departement, $agent);
    }

    /*
     * transmet la liste des résolution reçues selon les choix fait par l user
     */

    function resultatRechercheParType() {
        $_SESSION["count"] = 0;
        if (isset($_GET["type"])) {
            $reso;
            switch ($_GET["type"]) {
                case "ugp":
                    $_SESSION['recherche'] = 'Liste des résolutions reçues affiliées a l' . "'" . 'UGP ' . $_POST["element"];
                    $reso = $this->modelReceptionReso->rechercheParUgp($_POST["element"]);

                    break;
                case "programme":
                    $programme = $this->modelProg->chercherUnProgramme($_POST["element"]);
                    $_SESSION['recherche'] = 'Liste des résolutions reçues affiliées au programme ' . $_POST["element"] . ' (' . $programme->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParProgramme($_POST["element"]);

                    break;
                case "cour":
                    $cour = $this->modelCour->chercherUnCour($_POST["element"]);
                    $_SESSION['recherche'] = 'Liste des résolutions reçues affiliées au cours ' . $_POST["element"] . ' (' . $cour->getNom() . ') ';
                    $reso = $this->modelReceptionReso->rechercheParCour($_POST["element"]);

                    break;
                case "agent":
                    $agent = $this->modelAgent->rechercheParId($_POST["element"]);
                    $_SESSION['recherche'] = 'Liste des résolutions reçues traitées par ' . $agent->getPrenom() . ' ' . $agent->getNom();
                    $reso = $this->modelReceptionReso->rechercheParAgent($_POST["element"]);

                    break;
                case "date":
                    $_SESSION['recherche'] = " Liste des résolutions reçues de l'année " . $_POST["element"];
                    $reso = $this->modelReceptionReso->rechercheParDate($_POST["element"]);

                    break;
                case "mot":
                    $_SESSION['recherche'] = ' Liste des résolutions reçues contenant le mot "' . $_POST["element"] . '"';
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

    /*
     * Création du fichier Excel pour les utilisateur public de la liste des résolutions reçues affichée
     */

    public function telechargerExcel($titre, $reso) {

        function cellColor($cells, $color) {
            global $objPHPExcel;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $color
                )
            ));
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();



        $sheet->setCellValue('A1', $titre);
        $sheet->setCellValue('A2', 'Numéro');
        $sheet->setCellValue('B2', 'Résolutions reçue');
        $sheet->setCellValue('C2', 'Sujet');
        $sheet->setCellValue('D2', 'codeUgp_id');
        $sheet->setCellValue('E2', 'Departement_id');
        $sheet->setCellValue('F2', 'Date Demande');
        $sheet->setCellValue('G2', 'Date Reception');
        $sheet->setCellValue('H2', 'Notes');
        $sheet->setCellValue('I2', 'Numéro de projet');
        $sheet->setCellValue('J2', 'État');
        $sheet->setCellValue('K2', 'agent_id');
        $y = 3;
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

    /*
     * Transmet UN projet a la vue selon l id choisi
     */

    public function projetComplet() {
        $id = filter_var($_GET["id"], FILTER_SANITIZE_STRING);
        $projet = $this->modelProjet->rechercheProjetParId($id);

        $this->vue->afficherUnProjet($projet);
    }

    /*
     * Transmet la liste des projets trié par id a la vue
     */

    public function allProjet() {
        $allProjet = $this->modelProjet->allProjetTrie();
        $this->vue->afficherProjet($allProjet, 'Liste de tout les projets');
    }

    /*
     * Transmet la liste des cours trié par Sigle a la vue
     */

    public function allCour() {
        $allCour = $this->modelCour->allCourTrie();
        $this->vue->afficherCour($allCour);
    }

    /*
     * Transmet la liste des programmes triéés par Code a la vue
     */

    public function allProgramme() {
        $allProg = $this->modelProg->allProgrammeTrie();
        $this->vue->afficherProgramme($allProg);
    }

    /*
     * Demande a la vue d afficher le formulaire de craétion de cours
     */

    public function formulaireCour() {
        $this->vue->afficherFormulaireCour();
    }

    /*
     * Création d un nouveau cours apres filtrage des valeurs du formulaire
     */

    public function traitementCour() {
        $sigle = filter_var($_POST["sigle"], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
        $cycle = filter_var($_POST["cycle"], FILTER_SANITIZE_NUMBER_INT);
        $this->modelCour->nouveauCour($sigle, $nom, $cycle);
        $this->vue->afficherResulatCreation('Cour');
    }

    /*
     * Demande a la vue d afficher le formulaire de création de Programme
     */

    public function formulaireProgramme() {
        $ugp = $this->modelUgp->allUgpTrie();
        $this->vue->afficherFormulaireProgramme($ugp);
    }

    /*
     * Création d un nouveau programme apres filtrage des valeurs
     */

    public function traitementProgramme() {

        $code = filter_var($_POST["code"], FILTER_SANITIZE_STRING);
        $nom = filter_var($_POST["nom"], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
        $this->modelProg->nouveauProgramme($code, $nom, $type, $_POST['ugp']);
        $this->vue->afficherResulatCreation('Programme');
    }

    /*
     * Demande a la vue d afficher le formulaire de création de séance
     */

    public function formulaireSeance() {
        $this->vue->afficherFormulaireSeance();
    }

    /*
     * Création d une nouvelle séance apres filtrage des valeurs
     */

    public function traitementSeance() {

        $date = filter_var($_POST["date"], FILTER_SANITIZE_STRING);
        $instance = filter_var($_POST["instance"], FILTER_SANITIZE_STRING);
        $this->modelSeance->nouvelleSeance($date, $instance);
        echo('Votre Séance a été crée, vous pouvez fermer cet onglet');
    }

    /*
     * Transmet  a la vue les informations néccessaires aux formulaire de rehcerche avancée
     */

    public function rechercheAvancerForm() {

        $departement = $this->modelDepartement->allDepartementTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $this->vue->afficherFormulaireRechercheAvancer($departement, $ugp);
    }

    /*
     * Demande a la vue d afficher le pré formulaire de rehcerche d avancée
     */

    public function rechercheAvancerPreForm() {

        $this->vue->afficherPreFormulaireRecherche();
    }

    /*
     * Transmet la liste des résolutions reçues selon concerné par la recherche avancée et création de la requete SQL modulable
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
        $this->telechargerExcel($titreFichier, $reso);
        $this->vue->rechercheResolution($reso, $titreFichier);
    }

    /*
     * Transmet la liste des projets concerné par la recherche par Mot clé
     */

    public function traitementRechercheProjet() {
        $projet = $this->modelProjet->rechercheParMot($_POST["mot"]);
        $titre = "Liste de tout les projets contenant le mot clé: " . $_POST["mot"];
        $this->vue->afficherProjet($projet, $titre);
    }

}
