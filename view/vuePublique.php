<?php

namespace SGR\view;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VuePublique {

    function __construct() {

    }

    public function afficherAccueil() {

        echo('
      <div id="divpublic" class="btt">

        <a href="index.php?action=soumettreReso" target="_self">
          Saisir une resolution recue
        </a> <br>

        <a href="index.php?action=voirReso">
          Consulter la liste des resolutions reçues</a>
      <br>

        <a href="index.php?action=connexion">
        Gerer les resolutions du decanat
        </a>
      </div>');
    }

    public function afficherPreFormulaireRésolution($nbCour, $nbProgramme) {

        echo ('
      <form action="index.php?action=formulaireReso" class="formPreForm" method="POST">
        <div id="divsoumettre" class="btt2">
        <a href="popUp.php?action=voirAllProjet"  target=_blank>Voir les projets existants</a>
         <a href="popUp.php?action=voirAllCour"  target=_blank>Voir les cours existants</a>
          <a href="popUp.php?action=voirAllProgramme"  target=_blank>Voir les programmes existants</a><br><br><br><br>

        <h1> Renseignement sur la résolution reçue</h1><br>
          Projet deja existant:
          <input type="radio" name="projet" value="oui" required> Oui
          <input type="radio" name="projet" value="non"> Non<br><br>

<center>
  <table class="table1">
    <tr>
        <td> Combien de cours sont concernés par la résolution: </td>
          <td> <select id="cour" name="cour">
            <option value="none">Inderteminé</option>');
        for ($i = 1; $i <= $nbCour; $i++) {
            echo('<option value="' . $i . '">' . $i . '</option>');
        }
        echo('
            <option value="all">tout</option>
          </select> </td></tr>
  </table>
</center>

Nouveau cour non repertorié ? <a href="popUp.php?action=creerCour" >Créer le cour </a>  <br><br><br><br>


<center>
  <table class="table1">
    <tr>
          <td>Combien de programmes sont concernés par la résolution: </td>
          <td><select id="programme" name="programme">
            <option value="none">Inderteminé</option>');
        for ($i = 1; $i <= $nbProgramme; $i++) {
            echo('<option value="' . $i . '">' . $i . '</option>');
        }

        echo('
            <option value="all">tout</option>
          </select></td></tr> </td>
  </table>
</center>

Nouveau programme non repertorié ? <a href="popUp.php?action=creerProgramme" >Créer le programme </a>  <br><br><br><br>
      <input type="submit" value="Valider">
</div>');
    }

    public function afficherFormulaireProjet() {

        echo('<div id="test" class="row">
        <div id="divhalf1">
        <h1> Renseignement sur le projet :</h1><br>
                <label for="description">Description du projet :</label><br>
                <textarea name="description" rows="5" cols="50" required form="formReso"></textarea>
                <br><br>
          <label for="etat">Etat du projet:</label>
          <input type="radio" name="etat" value="ouvert" required> Ouvert
          <input type="radio" name="etat" value="attente"> En attente <br><br><br>

           <label for="noteProjet">Note supplémentaire concernant le projet (facultatif):</label>
           <br>
                <textarea name="noteProjet" rows="5" cols="50"  form="formReso"></textarea>
                <br><br>
           <label for="nlien">Lien vers le dossier du projet (facultatif):</label>
    <input type="text"  placeholder="lien vers le dossier du projet" name="lien" >
    <br>

                </div>
          ');
    }

    public function afficherFormulaireResolution($cour, $prog, $ugp, $projet, $departement,$typeReso) {


        echo('

        <div id="divhalf2">
        <h1> Renseignement sur la résolution reçue:</h1><br>

          <div class="sujet">
            <label for="sujet">Sujet de la résolution:</label>
          <br>
               <textarea name="sujet" rows="3" cols="50" required form="formReso"></textarea>
               <br><br>
              </div>

             <center>
             <table class="table1">
             <tr>
                <td><label for="num">Numéro résolution reçue: </label></td>
                <td><input type="text" id="num" required placeholder="1234567890" name="num" >
                </td>
              </tr>
              <tr>
                  <td><label for="type">Type de Résolution : </label></td>
                  <td><select id="type" name="type">');
        foreach ($typeReso as $value) {
            echo('<option value="' . $value->getType() . '">' . $value->getType() . '</option>');
        }
        echo('</select><br></td></tr>

               <tr>
                  <td><label for="ugp">UGP : </label></td>
                  <td><select id="ugp" name="ugp">');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br></td></tr>  ');

        if ($_POST["projet"] == "oui") {
            echo('<tr>
            <td><label for="projet">Projet : </label></td>
         <td><select id="projet" name="projet">');
            foreach ($projet as $value) {
                echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
            }
            echo('</select></td></tr>  ');
        }

        if (($_POST['cour'] != "none") && ($_POST['cour'] != "all" )) {
            for ($i = 1; $i <= $_POST['cour']; $i++) {
                echo('
                 <tr>
                <td><label for="cour">Cours concernés par la résolution: </label></td>
                <td><select id="cour' . $i . '" name="cour' . $i . '">');
                foreach ($cour as $value) {
                    echo('<option value="' . $value->getSigle() . '">' . $value->getSigle() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }
        }

        if (($_POST['programme'] != "none") && ($_POST['programme'] != "all" )) {
            for ($i = 1; $i <= $_POST['programme']; $i++) {
                echo('
                 <tr">
                <td><label for="programme">Programmes concernés par la résolution: </label></td>
                <td><select id="programme' . $i . '" name="programme' . $i . '">');
                foreach ($prog as $value) {
                    echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }
        }

        echo('<tr>
                <td><label for="departement">Departement concerné par la résolution: </label></td>
                <td><select id="departement"  name="departement">');


        foreach ($departement as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select></td>
        </tr>
                   </table><br>

        <label for="noteReso">Note supplémentaire concernant la résolution (facultatif):</label>
           <br>
                <textarea name="noteReso" rows="3" cols="50"  form="formReso"></textarea>
                <br><br>

           </center>
           </div>
           </div>

           <div id="divb"> <input type="submit" name="valider" value="Créer"></div>

           </form>');
    }
    public function afficherFormulaireResolution2($cour, $prog, $ugp, $projet, $departement) {


        echo('
<form action="index.php?action=formulaireReso" class="formPreForm" method="POST">
        <div id="divhalf2">
        <h1> Renseignement sur la résolution reçue:</h1><br>

          <div class="sujet">
            <label for="sujet">Sujet de la résolution:</label>
          <br>
               <textarea name="sujet" rows="3" cols="50" required form="formReso"></textarea>
               <br><br>
              </div>

             <center>
             <table class="table1">
             <tr>
                <td><label for="num">Numéro résolution reçue: </label></td>
                <td><input type="text" id="num" required placeholder="1234567890" name="num" >
                </td>
              </tr>

               <tr>
                  <td><label for="ugp">UGP : </label></td>
                  <td><select id="ugp" name="ugp">');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br></td></tr>  ');

        if ($_POST["projet"] == "oui") {
            echo('<tr>
            <td><label for="projet">Projet : </label></td>
         <td><select id="projet" name="projet">');
            foreach ($projet as $value) {
                echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
            }
            echo('</select></td></tr>  ');
        }

        if (($_POST['cour'] != "none") && ($_POST['cour'] != "all" )) {
            for ($i = 1; $i <= $_POST['cour']; $i++) {
                echo('
                 <tr>
                <td><label for="cour">Cours concernés par la résolution: </label></td>
                <td><select id="cour' . $i . '" name="cour' . $i . '">');
                foreach ($cour as $value) {
                    echo('<option value="' . $value->getSigle() . '">' . $value->getSigle() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }
        }

        if (($_POST['programme'] != "none") && ($_POST['programme'] != "all" )) {
            for ($i = 1; $i <= $_POST['programme']; $i++) {
                echo('
                 <tr">
                <td><label for="programme">Programmes concernés par la résolution: </label></td>
                <td><select id="programme' . $i . '" name="programme' . $i . '">');
                foreach ($prog as $value) {
                    echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select></td>
                   </tr> ');
            }
        }

        echo('<tr>
                <td><label for="departement">Departement concerné par la résolution: </label></td>
                <td><select id="departement"  name="departement">');


        foreach ($departement as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select></td>
        </tr>
                   </table><br>

        <label for="noteReso">Note supplémentaire concernant la résolution (facultatif):</label>
           <br>
                <textarea name="noteReso" rows="3" cols="50"  form="formReso"></textarea>
                <br><br>

           </center>
           </div>
           

           </form>');
    }

    public function rechercheResolution($reso) {

        echo('<div id="divconsult" class="">
        <div class="btt2">
        <br>Rechercher :
        <a href="index.php?action=rechercheResoPar">  Par élément  </a>
        <a href="index.php?action=rechercheAvancer">  Recherche avancée  </a>
        <a href="index.php?action=voirReso">          Toutes les résolutions  </a>
        <br> <br>
        <h2>Liste de toutes les résolutions :</h2>
        <br>
        Nombre trouvé: ' . $_SESSION['count'] . '<br><br>
        <a href="Excel/allResolution.xlsx" download="allResolution.xlsx">Télécharger la liste</a>
        </div><br><br>
        <center>
        <table class="table2" >
        <tr>
            <th>Id</th>
            <th>Numéro</th>
            <th>Sujet</th>
            <th>Date de la demande</th>
            <th>Date de reception</th>
            <th>Département</th>
            <th>UGP</th>
        </tr>');
        foreach ($reso as $value) {
            echo('<tr><td><a href="index.php?action=resolution&id=' . $value->getId() . '"> ' . $value->getId() . '</a></td>
                    <td>' . $value->getNum() . '</td>
                    <td>' . $value->getSujet() . '</td>
                    <td>' . $value->getDateReception() . '</td>
                    <td>' . $value->getDateDemande() . '</td>
                    <td>' . $value->getDepartement_id() . '</td>
                    <td>' . $value->getCodeUgp_id() . '</td></tr>' );
        }
        echo('</table></center></div>');
    }

    public function afficherUneResolution($reso, $programme, $cour) {
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
                <td>Sujet de la résolution :</td>
                <td>' . $reso->getSujet() . '</td>
                </tr>

                <tr>
                <td>Projet associé :</td>
                <td> <a href="index.php?action=projet&id=' . $reso->getNumProjet_id() . '"> ' . $reso->getNumProjet_id() . '</a></td>
                </tr>

                <tr>
                <td>Date de demande :</td>
                <td>' . $reso->getDateDemande() . '</td>
                </tr>

                <tr>
                <td>Date de reception :</td>
                <td>' . $reso->getDateReception() . '</td>
                </tr>

                <tr>
                <td>Traitement :</td>
                <td>' . $reso->getTraitement() . '</td>
                </tr>

                <tr>
                <td>Notes :</td>  <td>' . $reso->getNotes() . '</td>
                </tr>

                <tr>
                <td>Departement :</td>    <td>' . $reso->getDepartement_id() . '</td>
                </tr>

                <tr>
                <td>Ugp :</td>    <td>' . $reso->getCodeUgp_id() . '</td>
                </tr>

                <tr>
                <td>Agent :</td>  <td>' . $reso->getAgent_id() . '</td>
                </tr>
</table>
</center>

<center>
<table class="table3">
                <tr>
                <th>Liste des programmes concerné :  </th>
                </tr>
                ');
        foreach ($programme as $value) {
            echo('<tr>
                  <td>'.$value->getCode() . ' :  ' . $value->getNom() . '</td>
                  </tr>');
        }
        echo('
                <tr>
                <th> Liste des cours concerné:</th>
                 </tr>');
        foreach ($cour as $value) {
            echo('<tr>
                  <td>'.$value->getSigle() . ':  ' . $value->getNom() . '</td>
                  </tr>');
        }
        echo('</table></center></div>');
    }

    public function afficherUnProjet($projet) {
        echo('<div id="divconsult" class="resolution">
        <center>
          <table class="table3">
            <tr>
                <td>Numéro du projet :</td>
                <td>' . $projet->getNum() . '</td>
            </tr>

            <tr>
                <td>Description :</td>
                <td>' . $projet->getDescription() . '</td>
            </tr>

            <tr>
                <td>État :</td>
                <td>' . $projet->getEtat() . '</td>
            </tr>

            <tr>
                <td>Notes :</td>
                <td>' . $projet->getNote() . '</td>
            </tr>

            <tr>
                <td>Lien dossier :</td>
                <td>' . $projet->getLien() . '</td>
            </tr>

        </table></center></div>');
    }

    public function rechercheParType($cour, $prog, $ugp, $departement, $agent) {
        //par Ugp
        echo ('<form action="index.php?action=resultatRecherchePar&type=ugp" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par UGP:</h2>
                 <div class="ugp">
        <label for="element">UGP: </label>
         <select id="element" name="element">');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Rechercher">
                 </form><br>  <br>  <br>  ');

        //Par programme
        echo ('<form action="index.php?action=resultatRecherchePar&type=programme" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par programme:</h2>
                 <div class="programme">
        <label for="element">Programme: </label>
         <select id="element" name="element">');
        foreach ($prog as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Rechercher">
                 </form>');

        //Par cour
        echo ('<form action="index.php?action=resultatRecherchePar&type=cour" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par cour:</h2>
                 <div class="cour">
        <label for="element">Cour: </label>
         <select id="element" name="element">');
        foreach ($cour as $value) {
            echo('<option value="' . $value->getSigle() . '">' . $value->getSigle() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Rechercher">
                 </form>');


        //Par Agent
        echo ('<form action="index.php?action=resultatRecherchePar&type=agent" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par agent:</h2>
                 <div class="agent">
        <label for="element">Agent: </label>
         <select id="element" name="element">');
        foreach ($agent as $value) {
            echo('<option value="' . $value->getId() . '">' . $value->getNom() . ' ' . $value->getPrenom() . '</option>');
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Rechercher">
                 </form>');


        //Par date
        echo ('<form action="index.php?action=resultatRecherchePar&type=date" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par Date:</h2>
                 <div class="date">
        <label for="element">Date: </label>
         <select id="element" name="element">');
        $i = 2015;
        $date = date("Y");
        $fin = intval($date);
        while ($i <= $fin) {
            echo('<option value="' . $i . '">' . $i . '</option>');
            $i++;
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Rechercher">
                 </form>');

        //Par Mot clé
        echo ('<form action="index.php?action=resultatRecherchePar&type=mot" class="formReso" id="formReso" method="POST">
                 <h2>Recherche Par Mot clé:</h2>
                 <div class="Mot">
        <label for="element">Mot clé: </label>
        <input type="text" id="element" name="element" required >

        <br>
                <input type="submit" name="valider" value="Rechercher">
                 </form>');
    }

    public function afficherProjet($projet) {
        echo('<div id="divconsult">
        <h1>Liste des projets </h1><br>
            <center><table class="table3" >
        <tr>
            <th>Id</th>
            <th>Description Projet</th>
            <th>État</th>
            <th>Note</th>
            <th>Lien dossier</th>
            <th>Agent responsable</th>
        </tr>');
        foreach ($projet as $value) {
            echo('<tr><td>' . $value->getNum() . '</td>
                    <td>' . $value->getDescription() . '</td>
                    <td>' . $value->getEtat() . '</td>
                    <td>' . $value->getNote() . '</td>
                    <td>' . $value->getlien() . '</td>
                    <td>' . $value->getAgent() . '</td></tr>' );
        }
        echo('</table></center></div>');
    }

    public function afficherCour($cour) {
        echo('<div id="divconsult">
         <h1>Liste des cours ordonnés par sigle </h1><br>
         <center>
            <table  class="table3" >
        <tr>
            <th>Sigle</th>
            <th>Nom</th>
            <th>Cycle</th>
        </tr>');
        foreach ($cour as $value) {
            echo('<tr><td>' . $value->getSigle() . '</td>
                    <td>' . $value->getNom() . '</td>
                    <td>' . $value->getCycle() . '</td></tr>' );
        }
        echo('</table></center></div>');
    }

     public function afficherProgramme($programme) {
        echo('<div id="divconsult">
         <h1>Liste des programmes ordonnés par code </h1><br>
            <center>
            <table class="table2" >
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Ugp associé</th>
        </tr>');
        foreach ($programme as $value) {
            echo('<tr><td>' . $value->getCode() . '</td>
                    <td>' . $value->getNom() . '</td>
                    <td>' . $value->getType() . '</td>
                    <td>' . $value->getUgp() . '</td></tr>' );
        }
        echo('</table></center></div>');
    }

    public function afficherFormulaireCour() {


        echo('<form action="popUp.php?action=traitementCour" class="formPreForm" method="POST">

        <div id="divsoumettre" class="btt2">
        <h1> Renseignement sur le Cour:</h1><br><br>
          <label for="sigle">Sigle du cour: </label>
        <input type="text" id="sigle" required  name="sigle" ><br><br>


        <label for="nom">Nom du cour: </label>
        <input type="text" id="nom" required  name="nom" ><br><br>


        <label for="cycle">Cycle du cour: </label>
        <input type="number" id="cycle" required  name="cycle" ><br><br>

            </select><br>
                <input type="submit" name="valider" value="Créer">
        </div>

                 </form>');
    }

    public function afficherFormulaireProgramme($ugp) {


        echo('<form action="popUp.php?action=traitementProgramme" class="formPreForm" method="POST">

        <div id="divsoumettre" class="btt2">
        <h1> Renseignement sur le Programme:</h1><br><br>
          <label for="sigle">Code programme: </label>
        <input type="text" id="code" required  name="code" ><br><br>


        <label for="nom">Nom du programme: </label>
        <input type="text" id="nom" required  name="nom" ><br><br>


        <label for="type">Type programme (facultatif): </label>
       <select id="type" name="type">
            <option value="none">none</option>
            <option value="court de premier cycle">court de premier cycle</option>
            <option value="court de deuxième cycle"> court de deuxième cycle</option>
            <option value="court de deuxième cycle"> court de deuxième cycle</option>
            <option value="sur mesure"> sur mesure</option>
          </select><br>

        <label for="ugp">UGP associé (facultatif): </label>
         <select id="ugp" name="ugp">
         <option value="NULL">none</option>');

        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br>
                <input type="submit" name="valider" value="Créer">
        </div>

                 </form>');
    }

    public function afficherResulatCreation($res){
        echo('
                <div id="divsoumettre" class="btt2">
                Votre '.$res.' a été creé <br><br><br>

        <a href="index.php?action=soumettreReso">Retourner au formulaire</a>
         </div>');
    }
    
    
    public function afficherFormulaireSeance(){
        echo('<form action="popUp.php?action=traitementSeance" class="formPreForm" method="POST">

        <div id="divsoumettre" class="btt2">
        <h1> Renseignement sur la Séance:</h1><br><br>
        
          <label for="date">Date: </label>
        <input type="date"  required name="date" min="2000-12-31"><br><br>

    <label for="instance">Instance: </label></td>
                <td><select id="instance"  name="instance">
         <option value="CA">CA</option>
                 <option value="CE">CE</option>
                  <option value="SCE">SCE</option>
                 </select>
                 <br>

    <input type="submit" name="valider" value="Créer">
        </div>

                 </form>');
        
        
    }

}
