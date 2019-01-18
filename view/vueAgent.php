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

  <a href="index.php?action=voirResoSoumi">Consulter la liste des résolutions reçues </a><br>

  <a href="index.php?action=voirResoDecanat">Consulter la liste des résolutions du Décanat</a><br>
   <a href="popUp.php?action=voirAllProjet" target="_self">
          Consulter la liste des projets
        </a> <br>

  <a href="index.php?action=soumettreReso" target="_self">
          Saisir une résolution reçue
        </a> <br>




</div>');
    }

    public function voirReso($reso, $titre) {
        echo('<div id="divconsult" class="">
        <div class="btt2">
        <br>Rechercher :
        <a href="index.php?action=voirResoSoumi">  Toutes les résolutions </a>
        <a href="index.php?action=resoNonTraiter">  Résolution non traitée  </a>
        <a href="index.php?action=resoPerso">  Mes résolutions </a>
          <a href="index.php?action=rechercheResoPar">  Par élément  </a>
           <a href="index.php?action=rechercheAvancer"> Recherche avancée  </a>
        <br> <br>
        <h2>' . $titre . ' :</h2>
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
            <th>Date de demande</th>
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
                    <td>' . $value->getCodeUgp_id() . '</td><td>');
            if ($value->getAgent_id() == NULL) {
                echo(' <a href="index.php?action=traiterResoSoumi&id=' . $value->getId() . '"><img src="image/valider" width="30" title= "Traiter la résolution"></a> ');
            }
            echo('<a href="index.php?action=modifierResoSoumi&num=' . $value->getId() . '"><img src="image/transfert" width="30" title= "Modifier la résolution "></a></td>');
        }
        echo('</tr></table></center></div>');
    }

    public function afficherFormulaireModif($reso, $programmeReso, $courReso, $cour, $programme, $ugp, $projet, $departement, $type) {
        $nbCour = 0;
        $nbProgramme = 0;
        echo('<div id="" class="row">
        <div id="divhalf1">
        <h1> Information de la résolution reçue actuellement </h1>
        Id de la résolution:    ' . $reso->getId() . '<br>
                Numéro de la résolution:    ' . $reso->getNum() . '<br>
                Type de  résolution:    ' . $type->getIdReso() . '<br>
                Sujet de la résolution:     ' . $reso->getSujet() . '<br>
                Projet associé:     <a href="index.php?action=projet&id=' . $reso->getNumProjet_id() . '"> ' . $reso->getNumProjet_id() . '</a><br>
                Date de demande:    ' . $reso->getDateDemande() . '<br>
                Date de réception:    ' . $reso->getDateReception() . '<br>
                Traitement:     ' . $reso->getTraitement() . '<br>
                Notes:  ' . $reso->getNotes() . '<br>
                Département:    ' . $reso->getDepartement_id() . '<br>
                Ugp:    ' . $reso->getCodeUgp_id() . '<br>
                agent:  ' . $reso->getAgent_id() . '<br><br>
                     Liste des cours concernés : <br>

                ');


        foreach ($courReso as $value) {
            echo($value->getSigle() . ':  ' . $value->getNom() . '<br>');
            $nbCour++;
            $_SESSION["courReso" . $nbCour] = $value->getSigle();
        }
        echo('  <br> <br>Liste des programmes concernés :  <br>');
        foreach ($programmeReso as $value) {
            echo($value->getCode() . ':  ' . $value->getNom() . '<br>');
            $nbProgramme++;
            $_SESSION["programmeReso" . $nbProgramme] = $value->getCode();
        }
        echo('</div>
            <div id="divhalf2">
              <form action="index.php?action=traitementModifReso&id=' . $reso->getId() . '&nbCour=' . $nbCour . '&nbProg=' . $nbProgramme . '" class="formModifReso" method="POST">
        <h1> Modification de la résolution reçue (Veuillez laisser vide les champs qui ne sont pas concernés par la modification):</h1><br>
             <center>
             <table class="table1">
             <tr>
                <td><label for="num">Numéro résolution reçue : </label></td>
        <td><input type="text" id="num"  name="num" ><br><br>
        </td></tr>
        </table>
         <div class="sujet">
        <label for="sujet">Sujet de la résolution :</label>
           <br>
                <textarea name="sujet" rows="3" cols="50" ></textarea>
                <br><br>
               </div>

               <center>
               <table class="table1">



            <tr>
            <td><label for="projet">Projet : </label></td>
         <td><select id="projet" name="projet">');
        echo('<option value=""></option>');
        foreach ($projet as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
        }
        echo('</select></td></tr>  ');








        echo('<tr> <td><label for="traitement">Traitement :</label></td>
           <br>
                 <td><textarea name="traitement" rows="3" cols="50"  ></textarea></td></tr>

<tr> <td><label for="noteReso">Note supplémentaire concernant la résolution (facultatif):</label></td>
           <br>
                 <td><textarea name="noteReso" rows="3" cols="50"  ></textarea></td></tr>

<tr>
                <td><label for="departement">Département concerné par la résolution: </label></td>
                <td><select id="departement"  name="departement">');
        echo('<option value=""></option>');


        foreach ($departement as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select></td>
        </tr>
                   <br>

<tr>
        <td><label for="ugp">UGP : </label></td>
         <td><select id="ugp" name="ugp">');
        echo('<option value=""></option>');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br></td></tr>');


        for ($i = 1; $i <= $nbCour; $i++) {
            echo('<tr>
                <td><label for="cour">Cours concernés par la résolution : </label></td>
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
                <td><label for="programme">Programmes concernés par la résolution : </label></td>
                <td><select id="programme' . $i . '" name="programme' . $i . '">');
            echo('<option value=""></option>');
            foreach ($programme as $value) {
                echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
            }
            echo('</select></td>
                   </tr> ');
        }
        echo('<br><br></table>

          <tr><td><div id="divb"> <input type="submit" name="valider" value="Créer"></div></tr>

           </center>
           </div>
           </form>
           </div>

           ');
    }

    public function traiterReso($reso, $programmeReso, $courReso, $type, $seance, $allType, $resoDeca) {
        $nbCour = 0;
        $nbProgramme = 0;
        echo('<div id="" class="row">
        <div id="divhalf1">
        <h1> Information sur la résolution reçue en cours de traitement</h1>
        Id de la résolution:    ' . $reso->getId() . '<br>
                Numéro de la résolution :    ' . $reso->getNum() . '<br>
                Type de  résolution :    ' . $type->getIdReso() . '<br>
                Sujet de la résolution :     ' . $reso->getSujet() . '<br>
                Projet associé :     <a href="index.php?action=projet&id=' . $reso->getNumProjet_id() . '"> ' . $reso->getNumProjet_id() . '</a><br>
                Date de demande :    ' . $reso->getDateDemande() . '<br>
                Date de réception :    ' . $reso->getDateReception() . '<br>
                Traitement :     ' . $reso->getTraitement() . '<br>
                Notes :  ' . $reso->getNotes() . '<br>
                Département :    ' . $reso->getDepartement_id() . '<br>
                Ugp :    ' . $reso->getCodeUgp_id() . '<br>
                Agent :  ' . $reso->getAgent_id() . '<br><br>
                     Liste des cours concernés : <br>

                ');


        foreach ($courReso as $value) {
            echo($value->getSigle() . ':  ' . $value->getNom() . '<br>');
            $nbCour++;
            $_SESSION["courReso" . $nbCour] = $value->getSigle();
        }
        echo('  <br> <br>Liste des programmes concernés :  <br>');
        foreach ($programmeReso as $value) {
            echo($value->getCode() . ':  ' . $value->getNom() . '<br>');
            $nbProgramme++;
            $_SESSION["programmeReso" . $nbProgramme] = $value->getCode();
        }
        echo('  <br> <br>Liste des résolutions décanat associées :  <br>');
        foreach ($resoDeca as $value) {
            echo('<a href="index.php?action=resoDeca&id=' . $value . '"> ' . $value . '</a><br><br>');
        }
        echo('</div>
            <div id="divhalf2">
              <form action="index.php?action=enregistrementResoDeca&id=' . $reso->getId() . '&nbCour=' . $nbCour . '&nbProg=' . $nbProgramme . '&id_projet=' . $reso->getNumProjet_id() . '" class="formModifReso" method="POST">
        <h1> Création de la résolution décanat :</h1><br>
             <center>
             <table class="table1">
             <tr>
                <td><label for="num">Numéro résolution décanat : </label></td>
        <td><input type="text" id="num"  name="num" ><br><br>
        </td></tr>
         <div class="numInstance">
        <label for="numInstance">Numéro unique d ' . "'" . 'instance:</label>
           <br>
                <textarea name="numInstance" rows="3" cols="50" ></textarea>
                <br><br>
               </div>

               <center>
               <table class="table1">
                <tr>
                  <td><label for="type">Type de résolution : </label></td>
                  <td><select id="type" name="type">');
        foreach ($allType as $value) {
            echo('<option value="' . $value->getType() . '">' . $value->getType() . '</option>');
        }
        echo('</select><br></td></tr>


            <tr>
            <td> <label for="resumeReso">Résumé de la résolution décanat :</label></td>
         <td><textarea name="resumeReso" rows="3" cols="50" ></textarea></td></tr><br>
           <tr>
            <td> <label for="descReso">Description de la résolution décanat :</label></td>
         <td><textarea name="descReso" rows="3" cols="50" ></textarea></td></tr>



           <tr>
                <td><label for="campus">Campus concerné par la résolution décanat : </label></td>
                <td><select id="campus"  name="campus">
         <option value="Alexandre-Taché">Alexandre-Taché</option>
                 <option value="Saint-Jérôme">Saint-Jérôme</option>
                 </select></td>
        </tr>


        <tr>
                <td><label for="seance">Séance (triée par date) : </label></td>
                <td><select id="seance"  name="seance">');


        foreach ($seance as $value) {
            echo('<option value="' . $value->getNumSeance() . '">' . $value->getDate() . ': ' . $value->getInstance() . '</option>');
        }
        echo('</select><a href="popUp.php?action=creerSeance"  target=_blank>Votre séance n' . "'" . 'existe pas ? Créez la ici</a</td>
        </tr>




        <tr> <td><label for="noteReso">Note supplémentaire concernant la résolution décanat (facultatif):</label></td>
           <br>
                 <td><textarea name="noteReso" rows="3" cols="50"  ></textarea></td></tr>

</table>

          <tr><td><div id="divb"> <input type="submit" name="valider" value="Créer"></div></tr>

           </center>
           </div>
           </form>
           </div>

           ');
    }

    public function voirResoDecanat($reso, $titre) {
        echo('<div id="divconsult" class="">
        <div class="btt2">
        <br>Rechercher :
        <a href="index.php?action=voirResoDecanat">  Toutes les résolutions décanat </a>
        <br> <br>
        <h2>' . $titre . ' :</h2>
        <br>
        Nombre trouvé: ' . $_SESSION['count'] . '<br><br>
        <a href="Excel/allResolutionDecanat.xlsx" download="allResolutionDecanat    .xlsx">Télécharger la liste</a>
        </div><br><br>
        <center>
        <table class="table2" >
        <tr>
            <th>Id</th>
            <th>Numéro</th>
            <th>Numéro instance unique</th>
            <th>Résumé</th>
            <th>Description</th>
            <th>Date</th>
            <th>Campus</th>
            <th>Action</th>
        </tr>');
        foreach ($reso as $value) {
            echo('<tr><td><a href="index.php?action=resolutionDecanat&id=' . $value->getId() . '"> ' . $value->getId() . '</a></td>
                    <td>' . $value->getNum() . '</td>
                    <td>' . $value->getNumInstance() . '</td>
                    <td>' . $value->getResumeReso() . '</td>
                    <td>' . $value->getDescription() . '</td>
                    <td>' . $value->getDateReso() . '</td>
                   <td>' . $value->getCampus() . '</td>
                    <td>');
            if ($value->getSuivi() == NULL) {
                echo(' <a href="index.php?action=traiterResoDecanat&id=' . $value->getId() . '"><img src="image/valider" width="30" title= "Entériner la résolution"></a> </td>');
            } else {
                echo( $value->getSuivi() . ' </td>');
            }
            echo('</tr></table></center></div>');
        }
    }

    public function afficherUneResolutionDecanat($reso) {
        echo('<div id="divconsult" class="resolution">
        <center>
        <table class="table3">
                <tr>
                  <td>Id de la résolution :</td>
                   <td>' . $reso->getId() . '</td>
                  </tr>

                <tr>
                <td>Numéro de la résolution :</td>
                <td>' . $reso->getNum() . '</td>
                </tr>
                 <tr>
                <td>Numéro instance unique :</td>  <td>' . $reso->getNumInstance() . '</td>
                </tr>

                <tr>
                <td>Séance associée :</td>
                <td>' . $reso->getNumSeance_id() . '</td>
                </tr>

                <tr>
                <td>Projet associé :</td>
                <td> <a href="index.php?action=projet&id=' . $reso->getNumProjet_id() . '"> ' . $reso->getNumProjet_id() . '</a></td>
                </tr>

                <tr>
                <td>Date de demande :</td>
                <td>' . $reso->getDateReso() . '</td>
                </tr>

                <tr>
                <td>Date effective :</td>
                <td>' . $reso->getDateEffective() . '</td>
                </tr>

                <tr>
                <td>Résumé :</td>
                <td>' . $reso->getResumeReso() . '</td>
                </tr>

                <tr>
                <td>Description :</td>  <td>' . $reso->getDescription() . '</td>
                </tr>

                <tr>
                <td>Campus :</td>    <td>' . $reso->getCampus() . '</td>
                </tr>

                <tr>
                <td>Note :</td>    <td>' . $reso->getNote() . '</td>
                </tr>


</table>
</center>');
    }

    public function cloturerResolutionDecanat($resoRecu, $resoDecanat) {
        echo('<div id="divconsult" class="resolution">
        <center>
        <h3>Entérinement de la résolution Décanat :</h3>
        <table class="table3">
         <tr>
                <td>Résolution:</td>
                  <td>Résolution Reçue:</td>
                   <td>Résolution Décanat:</td>
                  </tr>
                <tr>
                  <td>Id de la résolution :</td>
                   <td>' . $resoRecu->getId() . '</td>
                       <td>' . $resoDecanat->getId() . '</td>
                  </tr>

                <tr>
                <td>Numéro de la résolution :</td>
                <td>' . $resoRecu->getNum() . '</td>
                    <td>' . $resoDecanat->getNum() . '</td>
                </tr>
                <tr>
                <td>Projet associé :</td>
                <td><a href="index.php?action=projet&id=' . $resoRecu->getNumProjet_id() . '"> ' . $resoRecu->getNumProjet_id() . '</a></td>
                    <td><a href="index.php?action=projet&id=' . $resoDecanat->getNumProjet_id() . '"> ' . $resoDecanat->getNumProjet_id() . '</a></td>
                </tr>
                <td>Date création :</td>
                <td>' . $resoRecu->getDateReception() . '</td>
                   <td>' . $resoDecanat->getDateReso() . '</td>
                </tr>
                <td>Traitement:</td>
                <td>' . $resoRecu->getTraitement() . '</td>
                   <td>En cours</td>
                </tr>
</table>



<h2>Veuillez renseigner les champs suivants si des informations supplémentaires sont néccéssaires : (laissez vide dans le cas contraire)</h2>
  <form action="index.php?action=terminerResolution&idRecu='.$resoRecu->getId().'&idDeca=' . $resoDecanat->getId() . '" id="formReso" class="formReso" method="POST">
 <table class="table3">
 
 <tr>
                <td>Résolution:</td>
                  <td>Résolution Reçue:</td>
                   <td>Résolution Décanat:</td>
                  </tr>
                  
                   <tr>
                <td>Traitement:</td>
                  <td> <textarea name="traitementRecu" rows="3" cols="50"  form="formReso"></textarea></td>
                   <td><textarea name="traitementDecanat" rows="3" cols="50"  form="formReso"></textarea></td>
                  </tr>
                  <td>Note supplémentaire:</td>
                  <td> <textarea name="noteRecu" rows="3" cols="50"  form="formReso"></textarea></td>
                   <td><textarea name="noteDecanat" rows="3" cols="50"  form="formReso"></textarea></td>
                  </tr>


</table>
 <input type="submit" name="enteriner" value="Entériner">
 </form>
       </center></div> ');
    }

}
