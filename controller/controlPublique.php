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
use SGR\model\Projet;

class controlPublique {

    private $vue;
    private $modelCour;
    private $modelProg;
    private $modelUgp;
    private $modelProjet;

    function __construct() {
        $this->vue = new VuePublique();
        $this->modelCour = new Cour();
        $this->modelProg = new Programme();
        $this->modelUgp = new Ugp();
        $this->modelProjet = new Projet();
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
        $_SESSION['nbprogramme'] = $_POST['programme'];
        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $projet = $this->modelProjet->allProjetTrie();
        $this->vue->afficherFormulaireResolution($cour, $prog, $ugp, $projet);
    }

    public function traitementReso() {
        $msgProjet;
        if ($_SESSION['projet'] == "oui") {
            $descrip = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
            $noteProjet = filter_var($_POST["noteProjet"], FILTER_SANITIZE_STRING);
            $lien = filter_var($_POST["lien"], FILTER_SANITIZE_STRING);
            $msgProjet = $this->modelProjet->nouveauProjet($descrip, $_POST["etat"], $noteProjet, $lien);
        }
        $numReso = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
        $sujetReso = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
        $ugp= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
        $noteReso= filter_var($_POST["description"], FILTER_SANITIZE_STRING);
    }

}
