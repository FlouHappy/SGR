<?php

namespace SGR\controller;

use SGR\view\VueConnexion;
use SGR\model\Agent;

/*
 * Gere la connexionde l utilisateur en tant que admin ou agent
 */

class Connexion {

    private $vue;

    function __construct() {
        $this->vue = new VueConnexion();
    }

    /*
     * Vérifie que a chaque acces d une page l user est bien connecté
     */

    public function verifierConnexion() {
        if (!empty($_SESSION["user"])) {
            if ($_SESSION["user"] == "admin") {
                $this->vue->afficherAccueilConnexionAdmin();
            } else {
                $this->vue->afficherAccueilConnexionAgent();
            }
        } else {
            
        }
    }

    /*
     * demande a la vue d afficher le formulaire de connexion (user,mdp)
     */

    public function formulaireConnexion() {
        $this->vue->afficherFormulaireConnexion();
    }

    /*
     * Déconnecte l utilisateur 
     */

    public function deconnecter() {
        session_destroy();
        header('Location: index.php?msg=deconnectionSuccess');
        exit();
    }

    /*
     * Verification des informations rmepli dans le formulaire de connexion
     */

    public function validerFormulaireConnexion() {
        if (!empty($_POST["usager"]) && !empty($_POST["mdp"])) {
            $agentBdd = new Agent();
            if ($_POST["usager"] == "admin") {

                $agent = $agentBdd->rechercheParId('admin');
                if (password_verify($_POST["mdp"], $agent->getMdp())) {
                    $_SESSION["user"] = "admin";
                    header('Location: index.php');
                    exit();
                } else {
                    header('Location: index.php?action=connexion&error=compteInexistant');
                    exit();
                }
            } else {

                $user = filter_var($_POST["usager"], FILTER_SANITIZE_STRING);
                $verif = $agentBdd->rechercheExistenceUser($user);
                if ($verif == true) {
                    $agent = $agentBdd->rechercheParId($user);
                    if (password_verify($_POST["mdp"], $agent->getMdp())) {

                        $_SESSION["nom"] = $agent->getNom();
                        $_SESSION["prenom"] = $agent->getPrenom();
                        $_SESSION["user"] = $user;
                        header('Location: index.php');
                        exit();
                    } else {
                        header('Location: index.php?action=connexion&error=compteInexistant');
                        exit();
                    }
                } else {
                    header('Location: index.php?action=connexion&error=compteInexistant');
                    exit();
                }
            }
        } else {
            header('Location: index.php?action=connexion&error=champManquant');
            exit();
        }
    }

}
