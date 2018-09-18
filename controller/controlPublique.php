<?php
namespace SGR\controller;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use SGR\view\VuePublique;
use SGR\model\Agent;
class controlPublique {

    private $vue;

    function __construct() {
        $this->vue = new VuePublique();
    }
    
    public function accueil(){
         $this->vue->afficherAccueil();
        
    }
    
    public function formulaireRéso(){
         $this->vue->afficherFormulaireRésolution();
    }
}
