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

    public function preFormulaireRéso() {
        $this->vue->afficherPreFormulaireRésolution(10, 10);
    }

    public function formulaireRéso() {
        echo ('<form action="index.php?action=TraitementRéso" class="formReso" id="formReso" method="POST">');
        if ($_POST["projet"] == "non") {
            $this->vue->afficherFormulaireProjet();
        }

        $_SESSION['nbCour'] = $_POST['cour'];
        $_SESSION['nbprogramme'] = $_POST['programme'];
        $cour = $this->modelCour->allCourTrie();
        $prog = $this->modelProg->allProgrammeTrie();
        $ugp = $this->modelUgp->allUgpTrie();
        $projet = $this->modelProjet->allProjetTrie();
        $this->vue->afficherFormulaireResolution($cour, $prog, $ugp, $projet);
    }

}
