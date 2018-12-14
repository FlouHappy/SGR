<?php

namespace SGR\controller;

/*
 * Gere toutes les actions lié a l admin
 */

use SGR\view\VueAdmin;
use SGR\model\Agent;

class controlAdmin {

    private $vue;

    function __construct() {
        $this->vue = new VueAdmin();
    }

    /*
     * Affiche la page d'accueil
     */

    public function accueil() {
        $this->vue->afficherAccueil();
    }

}
