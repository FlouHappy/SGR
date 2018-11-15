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
  
  <li><a href="index.php?action=voirResoSoumi">Consulter la liste des résolution soumises </a></li>
  <li><a href="index.php?action=voirResoDecanat">Consulter la liste des résolutions Decanat</a></li>
  <li><a href="index.php?action=creerSeance">Créer un nouveau Projet</a></li>
  <li><a href="index.php?action=creerSeance">Créer une nouvelle séance</a></li>
  <li><a href="index.php?action=creerCours">Ajouter un nouveau cours</a></li>
  <li><a href="index.php?action=creerProgramme">Ajouter un nouveau programme</a></li>
</ul>');
    }

    public function voirResoSoumi($reso) {
        echo('<div id="divconsult" class="">
        <div class="btt2">
        <br>Rechercher :
        <a href="index.php?action=resoNonTraiter">  Résolution non traité  </a>
        <a href="index.php?action=resoPerso">  Mes résolutions </a>
         <a href="index.php?action=resoPerso">  Résolution en cour de traitement </a>
        <br> <br>
        <h2>Liste de toutes les résolutions :</h2>
        <br>
        Nombre trouvé: ' . $_SESSION['count'] . '<br><br>
        <a href="Excel/allResolutionSoumi.xlsx" download="allResolutionSoumi.xlsx">Télécharger la liste</a>
        </div><br><br>
        <center>
        <table class="table2" >
        <tr>
            <th>Id</th>
            <th>Numéro</th>
            <th>Sujet</th>
            <th>Date de reception</th>
            <th>État</th>
            <th>UGP</th>
            <th>Action</th>
        </tr>');
        foreach ($reso as $value) {
            echo('<tr><td><a href="index.php?action=resolution&id=' . $value->getId() . '"> ' . $value->getId() . '</a></td>
                    <td>' . $value->getNum() . '</td>
                    <td>' . $value->getSujet() . '</td>
                    <td>' . $value->getDateDemande() . '</td>
                    <td>' . $value->getTraitement() . '</td>
                    <td>' . $value->getCodeUgp_id() . '</td>');
            if ($value->getAgent_id() == NULL) {
                echo(' <td><a href="index.php?action=validerResoSoumi"><img src="image/valider" width="30" title= "valider la résolution"></a>
                        <a href="index.php?action=refuserResoSoumi"><img src="image/refuser" width="30" title= "refuser la résolution"></a>
                        <a href="index.php?action=associerResoSoumi"><img src="image/transfert" width="30" title= "Associer a une résolution Decanat "></a></td>');
            } else {
                echo('<td></td>' );
            }
        }
        echo('</tr></table></center></div>');
    }

}
