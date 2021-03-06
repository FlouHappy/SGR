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
                $controlPublic->traitementReso();
                header('Location: index.php?action=resoCreer');
                break;
            case "resoCreer":
                $controlPublic->accueil();
                echo('Votre résolution a été enregistré');
                break;
            case "voirReso":
                $controlPublic->rechercheReso();
                break;
            case "resolution":
                $controlPublic->resolutionComplete();
                break;
            case "projet":
                $controlPublic->projetComplet();
                break;
            case"rechercheResoPar":
                $controlPublic->rechercheParType();
                break;
            case "resultatRecherchePar":
                $controlPublic->resultatRechercheParType();
                break;
            case"rechercheAvancer":
                $controlPublic->rechercheAvancerPreForm();
                break;
            case"formulaireRechercheAvancer":
                $controlPublic->rechercheAvancerForm();
                break;
            case"traitementRechercheAvancer":
                $controlPublic->traitementRecherche();
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
    $controlPublic = new controlPublique;
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
                case"voirResoSoumi":
                    $controlAgent->voirResoSoumi();
                    break;

                case"modifierResoSoumi":
                    $controlAgent->modifierResoSoumi();
                    break;
                case "resolution":
                    $controlPublic->resolutionComplete();
                    break;

                case"traitementModifReso":
                    $controlAgent->traitementModifResoSoumi();
                    header('Location: index.php?action=resoModifier');
                    break;
                case "resoModifier":
                    $controlAgent->accueil();
                    echo('Votre résolution a été modifiée avec succes');
                    break;
                case "projet":
                    $controlPublic->projetComplet();
                    break;
                case"resoNonTraiter":
                    $controlAgent->afficherResoNontraiter();
                    break;
                case "resoPerso" :
                    $controlAgent->afficherResoPerso();
                    break;
                case"rechercheResoPar":
                    $controlPublic->rechercheParType();
                    break;
                case "resultatRecherchePar":
                    $controlAgent->resultatRechercheParType();
                    break;
                case"traiterResoSoumi":
                    $controlAgent->traiterReso();
                    break;
                case"enregistrementResoDeca":
                    $controlAgent->enregistrementReso();
                    header('Location: index.php?action=resoAssocier');
                    break;
                case "resoAssocier":
                    $controlAgent->accueil();
                    echo('Votre résolution a été associé a une résolution Decanat');

                    break;
                case "soumettreReso":
                    $controlPublic->preFormulaireReso();
                    break;
                case "formulaireReso":
                    $controlPublic->formulaireReso();
                    break;
                case "traitementReso":
                    $controlPublic->traitementReso();
                    header('Location: index.php?action=resoCreer');
                    break;
                case "resoCreer":
                    $controlPublic->accueil();
                    echo('Votre résolution a été enregistré');
                    break;

                case"voirResoDecanat":
                    $controlAgent->afficherResoDecanat();
                    break;
                case"resolutionDecanat":
                    $controlAgent->resolutionDecanatComplete();
                    break;
                case"rechercheAvancer":
                    $controlPublic->rechercheAvancerPreForm();
                    break;
                case"formulaireRechercheAvancer":
                    $controlPublic->rechercheAvancerForm();
                    break;
                case"traitementRechercheAvancer":
                    $controlAgent->traitementRecherche();
                    break;
                case "traiterResoDecanat":
                    $controlAgent->traiterResoDecanat();
                    break;
                case "terminerResolution":
                    $controlAgent->enterinerReso();
                     $controlPublic->accueil();
                      echo('Votre résolution a été entérinée');
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
