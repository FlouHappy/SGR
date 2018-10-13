<?php

session_start();

require_once '/vendor/autoload.php';

use SGR\controller\Connexion;
use SGR\controller\controlPublique;
use SGR\controller\controlAgent;
use SGR\controller\controlAdmin;
?>

<?php include("template/template1.php") ?>



<?php

/*
 * On vérifie ici si l user est connecté ou non et affiche la barre de connexion ou déconnexion
 */
$controlCon = new Connexion();
$controlCon->verifierConnexion();
?>

<?php

/*
 * Ensemble des actions permises par type d utilisateur
 */
//parti non connecté
if (!isset($_SESSION["user"])) {
    $controlPublic = new controlPublique();
    //parti non connecté avec action donné publique
    if (isset($_GET["action"])) {
        switch ($_GET["action"]) {
            case "connexion":
                $controlCon->formulaireConnexion();
                break;
            case "validationConnexion":
                $controlCon->validerFormulaireConnexion();
                break;
            case "accueil":
                $controlPublic->accueil();
                break;
            case "soumettreReso":
                $controlPublic->preFormulaireReso();
                break;
            case "formulaireReso":
                $controlPublic->formulaireReso();
                break;
            case "traitementReso":
                var_dump($_POST);
                var_dump($_SESSION);
                $controlPublic->traitementReso();
                break;
        }
        //parti non connecté (page accueil )
    } else {
        header('Location: index.php?action=accueil');
        exit();
    }

    //parti connecté
} else {
    $controlAgent = new controlAgent();
    $controlAdmin = new controlAdmin();
    //parti  connecté commune
    if (isset($_GET["action"])) {
        switch ($_GET["action"]) {

            case "deconnexion":
                $controlCon->deconnecter();
                break;
        }
        //parti  connecté  admin
        if ($_SESSION["user"] == 'admin') {
            switch ($_GET["action"]) {

                case "accueil":
                    $controlAdmin->accueil();
                    break;
            }
        }
        //parti  connecté agent
        else {
            switch ($_GET["action"]) {

                case "accueil":
                    $controlAgent->accueil();
                    break;
            }
        }
    } else {

        header('Location: index.php?action=accueil');
        exit();
    }
}
?>


<?php include("template/template2.php") ?>
