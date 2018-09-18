<?php
namespace SGR\controller;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use SGR\view\VueAgent;
use SGR\model\Agent;


class controlAgent{
    
    private $vue;

    function __construct() {
        $this->vue = new VueAgent();
    }
    
    public function accueil(){
         $this->vue->afficherAccueil();
        
    }
}

