<?php
namespace SGR\view;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class VueAgent {

    function __construct() {
        
    }
    
    public function afficherAccueil() {
        echo('
<ul>
  
  <li><a href="index.php?action=voirReso">Consulter la liste des résolution soumis</a></li>
  <li><a href="index.php?action=voirResoPerso">Consulter les résolutions soumises dont vous etes responsable</a></li>
  <li><a href="index.php?action=creerResoDeca">Créer une résolution Décanat</a></li>
  <li><a href="index.php?action=creerSeance">Créer un nouveau Projet</a></li>
  <li><a href="index.php?action=creerSeance">Créer une nouvelle séance</a></li>
  <li><a href="index.php?action=creerCours">Ajouter un nouveau cours</a></li>
  <li><a href="index.php?action=creerProgramme">Ajouter un nouveau programme</a></li>
</ul>');
    }

}
