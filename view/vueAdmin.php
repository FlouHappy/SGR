<?php
namespace SGR\view;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class VueAdmin {

    function __construct() {
        
    }
    
    public function afficherAccueil() {
        echo('
<ul>
  
  <li><a href="index.php?action=adminAgent">Ajouter/modifier/supprimer un agent</a></li>
  <li><a href="index.php?action=adminResoSoumi">Ajouter/modifier/supprimer une résolutions soumise</a></li>
  <li><a href="index.php?action=adminResoDeca">Ajouter/modifier/supprimer une résolutions Décanat</a></li>
  <li><a href="index.php?action=adminSeance">Ajouter/modifier/supprimer une séance</a></li>
  <li><a href="index.php?action=adminCours">Ajouter/modifier/supprimer un cours</a></li>
  <li><a href="index.php?action=adminProgramme">Ajouter/modifier/supprimer un programme</a></li>
</ul>');
    }

}

