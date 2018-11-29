<?php

session_start();

require_once 'vendor/autoload.php';

use SGR\controller\Connexion;
use SGR\controller\controlPublique;
use SGR\controller\controlAgent;
use SGR\controller\controlAdmin;
?>

<?php include("template/template1.php") ?>



<?php
$controlPublic = new controlPublique();
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "voirAllProjet":
            $controlPublic->allProjet();
            break;
        case "voirAllCour":
            $controlPublic->allCour();
            break;
        case "voirAllProgramme":
            $controlPublic->allProgramme();
            break;
        case "creerCour":
            $controlPublic->formulaireCour();
            break;
        case "traitementCour":
            $controlPublic->traitementCour();
            break;
        case "creerProgramme":
            $controlPublic->formulaireProgramme();
            break;
        case "traitementProgramme":
            $controlPublic->traitementProgramme();
            break;
        case "creerSeance":
            $controlPublic->formulaireSeance();
            break;
         case "traitementSeance":
             $controlPublic->traitementSeance();
            break;
    }
}
include("template/template2.php") ?>
