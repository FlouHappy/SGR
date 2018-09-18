<?php
namespace SGR\controller;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use SGR\view\VueAdmin;
use SGR\model\Agent;


class controlAdmin{
    
    private $vue;

    function __construct() {
        $this->vue = new VueAdmin();
    }
    
    public function accueil(){
         $this->vue->afficherAccueil();
        
    }
}
