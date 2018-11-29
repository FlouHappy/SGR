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
<div id="divagent" class="bttagent">

  <a href="index.php?action=voirResoSoumi">Consulter la liste des résolutions reçues</a><br>
  <a href="index.php?action=voirResoDecanat">Consulter la liste des résolutions décanat</a><br>
  <a href="index.php?action=creerSeance">Créer un nouveau Projet</a><br>
  <a href="index.php?action=creerSeance">Créer une nouvelle séance</a><br>
  <a href="index.php?action=creerCours">Ajouter un nouveau cours</a><br>
  <a href="index.php?action=creerProgramme">Ajouter un nouveau programme</a>
');
    }

    public function voirResoSoumi($reso) {
        echo('<div id="divconsult" class="">
        <div class="btt2">
        <br>Rechercher :
        <a href="index.php?action=resoNonTraiter">  Résolution non traitée  </a>
        <a href="index.php?action=resoPerso">  Mes résolutions </a>
         <a href="index.php?action=resoPerso">  Résolution en traitement </a>
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
            <th>Date de réception</th>
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
                echo(' <td><a href="index.php?action=traiterResoSoumi"><img src="image/valider" width="30" title= "Traiter la résolution"></a>
                        <a href="index.php?action=modifierResoSoumi&num='.$value->getId().'"><img src="image/transfert" width="30" title= "Modifier la résolution "></a></td>');
            } else {
                echo('<td></td>' );
            }
        }
        echo('</tr></table></center></div>');
    }

    public function afficherFormulaireModif($reso,$programmeReso,$courReso,$cour,$programme,$ugp,$projet,$departement){
        $nbCour=0;
        $nbProgramme=0;
         echo('<div id="" class="row">
        <div id="divhalf1">
        <h1> Information de la résolution reçue actuellement </h1>
        Id de la résolution :' . $reso->getId() . '<br>
                Numéro de la résolution :' . $reso->getNum() . '<br>
                Sujet de la résolution :' . $reso->getSujet() . '<br>
                Projet associé : <a href="index.php?action=projet&id=' . $reso->getNumProjet_id() . '"> ' . $reso->getNumProjet_id() . '</a><br>
                Date de demande :' . $reso->getDateDemande() . '<br>
                Date de réception :' . $reso->getDateReception() . '<br>
                Traitement :' . $reso->getTraitement() . '<br>
                Notes :' . $reso->getNotes() . '<br>
                Département :' . $reso->getDepartement_id() . '<br>
                UGP :' . $reso->getCodeUgp_id() . '<br>
                Agent :' . $reso->getAgent_id() . '<br><br>
                Liste des programmes concernés :  <br>
                ');
        foreach ($programmeReso as $value) {
            echo($value->getCode() . ':  ' . $value->getNom() . '<br>');
             $nbProgramme++;
        }
        echo('

                <br><br> Liste des cours concernés : <br>
                 ');
        foreach ($courReso as $value) {
            echo($value->getSigle() . ':  ' . $value->getNom() . '<br>');
             $nbCour++;
        }
        echo('</div>
            <div id="divhalf2">
              <form action="index.php?action=traitementModifReso&id='.$reso->getId().'&nbCour='.$nbCour.'&nbProg='.$nbProgramme.'" class="formModifReso" method="POST">
        <h1> Modification de la résolution reçue (Veuillez laisser vide les champs qui ne sont pas concernés par la modification):</h1><br>
             <center>
             <table class="table1">
             <tr>
                <td><label for="num">Numéro résolution reçue :</label></td>
        <td><input type="text" id="num"  name="num" ><br><br>
        </td></tr>
        </table>
         <div class="sujet">
        <label for="sujet">Sujet de la résolution :</label>
           <br>
                <textarea name="sujet" rows="3" cols="50" required form="formReso"></textarea>
                <br><br>
               </div>

               <center>
               <table class="table1">
               <tr>
        <td><label for="ugp">UGP : </label></td>
         <td><select id="ugp" name="ugp">');
         echo('<option value=""></option>');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br></td></tr>  ');


            echo('<tr>
            <td><label for="projet">Projet : </label></td>
         <td><select id="projet" name="projet">');
             echo('<option value=""></option>');
            foreach ($projet as $value) {
                echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
            }
            echo('</select></td></tr>  ');



            for ($i = 1; $i <= $nbCour; $i++) {
                echo('
                 <tr>
                <td><label for="cour">Cours concernés par la résolution :</label></td>
                <td><select id="cour' . $i . '" name="cour' . $i . '">');
                 echo('<option value=""></option>');
                foreach ($cour as $value) {
                    echo('<option value="' . $value->getSigle() . '">' . $value->getSigle() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }



            for ($i = 1; $i <= $nbProgramme; $i++) {
                echo('
                 <tr">
                <td><label for="programme">Programmes concernés par la résolution :</label></td>
                <td><select id="programme' . $i . '" name="programme' . $i . '">');
                 echo('<option value=""></option>');
                foreach ($programme as $value) {
                    echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }


        echo('<tr>
                <td><label for="departement">Département concerné par la résolution :</label></td>
                <td><select id="departement"  name="departement">');
         echo('<option value=""></option>');


        foreach ($departement as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select></td>
        </tr>
                   <br> ');

        echo('<tr> <td><label for="noteReso">Note supplémentaire concernant la résolution (facultatif) :</label></td>
           <br>
                 <td><textarea name="noteReso" rows="3" cols="50"  form="formModifReso"></textarea></td></tr>
                <br><br></table>

          <tr><td><div id="divb"> <input type="submit" name="valider" value="Créer"></div></tr>
          </form>
           </center>
           </div>

           </div>

           ');

    }

}
