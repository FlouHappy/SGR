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
      <div id="divcon" class="btn-group">

        <a href="index.php?action=soumettreReso">
          <button id="btn_seconnecter" type="button">Soumettre une resolution </button>
        </a> <br>

        <a href="index.php?action=voirReso">
          <button id="btn_seconnecter" type="button">Consulter liste de resolutions</button></a>
      <br>

        <a href="index.php?action=connexion">
          <button id="btn_seconnecter" type="button">Se Connecter</button>
        </a>
      </div>');
    }

    public function afficherPreFormulaireRésolution($nbCour, $nbProgramme) {
      echo('<div id="divcon">');
        echo ('
      <form action="index.php?action=formulaireReso" class="formPreForm" method="POST">
        <div class="input-groupe">
        <h2> Renseignement Résolution</h2>
          <label for="projet">Projet deja existant:</label>
          <input type="radio" name="projet" value="oui" required> Oui<br>
          <input type="radio" name="projet" value="non"> Non<br><br>
          <a href="popUp.php"  target=_blank>Voir liste projet existant</a>
        </div>

        <div class="cour">
          <label for="cour">Combien de cours sont concernés par la résolution: </label>
          <select id="cour" name="cour">
            <option value="none">Inderteminé</option>');
        for ($i = 1; $i <= $nbCour; $i++) {
            echo('<option value="' . $i . '">' . $i . '</option>');
        }


        echo('
            <option value="all">tout</option>
          </select>
        </div>

         <div class="programme">
          <label for="programme">Combien de programmes sont concernés par la résolution: </label>
          <select id="programme" name="programme">
            <option value="none">Inderteminé</option>');
        for ($i = 1; $i <= $nbProgramme; $i++) {
            echo('<option value="' . $i . '">' . $i . '</option>');
        }


        echo('
            <option value="all">tout</option>
          </select>
        </div>

      <input type="submit" value="Valider">

      </form>');
      echo('</div>');
    }

    public function afficherFormulaireProjet() {
      echo('<div id="divconhalf1">');
        echo('<h1> Renseignement du projet :</h1><br>
                <label for="description">Description du projet :</label><br>
                <textarea name="description" rows="10" cols="50" required form="formReso"></textarea>
                <br><br>
          <label for="etat">Etat du projet:</label>
          <input type="radio" name="etat" value="ouvert" required> Ouvert
          <input type="radio" name="etat" value="attente"> En attente <br><br><br>

           <label for="noteProjet">Note supplémentaire concernant le projet (facultatif):</label>
           <br>
                <textarea name="noteProjet" rows="10" cols="50"  form="formReso"></textarea>
                <br><br>
           <label for="nlien">Lien vers le dossier du projet (facultatif):</label>
    <input type="text"  placeholder="lien vers le dossier du projet" name="lien" >
    <br>
                <br>');
                echo('</div>');
    }

    public function afficherFormulaireResolution($cour, $prog, $ugp, $projet, $departement) {
      echo('<div id="divconhalf2">');

        echo('<h1> Renseignement sur la résolution :</h1><br>
             <div class="num">
                <label for="num">Numéro Résolution: </label>
        <input type="text" id="num" required  name="num" ><br><br>
        </div>
         <div class="sujet">
        <label for="sujet">Sujet de la résolution:</label>
           <br>
                <textarea name="sujet" rows="10" cols="50" required form="formReso"></textarea>
                <br><br>
               </div>

          <div class="ugp">
        <label for="ugp">UGP : </label>
         <select id="ugp" name="ugp">');
        foreach ($ugp as $value) {
            echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select><br>  ');

        if ($_POST["projet"] == "oui") {
            echo('<label for="projet">Projet : </label>
         <select id="projet" name="projet">');
            foreach ($projet as $value) {
                echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
            }
            echo('</select>  ');
        }

        if (($_POST['cour'] != "none") && ($_POST['cour'] != "all" )) {
            for ($i = 1; $i <= $_POST['cour']; $i++) {
                echo('
                 <div class="cour">
                <label for="cour">Cours concernés par la résolution: </label>
                <select id="cour' . $i . '" name="cour' . $i . '">');
                foreach ($cour as $value) {
                    echo('<option value="' . $value->getSigle() . '">' . $value->getSigle() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select>
                   </div> ');
            }
        }

        if (($_POST['programme'] != "none") && ($_POST['programme'] != "all" )) {
            for ($i = 1; $i <= $_POST['programme']; $i++) {
                echo('
                 <div class="programme">
                <label for="programme">Programmes concernés par la résolution: </label>
                <select id="programme' . $i . '" name="programme' . $i . '">');
                foreach ($prog as $value) {
                    echo('<option value="' . $value->getCode() . '">' . $value->getcode() . ': ' . $value->getNom() . '</option>');
                }
                echo('</select>
                   </div> ');
            }
        }

        echo('<div class="departement">
                <label for="departement">Departement concerné par la résolution: </label>
                <select id="departement"  name="departement">');


        foreach ($departement as $value) {
            echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getNom() . '</option>');
        }
        echo('</select>
                   </div> ');

        echo('<label for="noteReso">Note supplémentaire concernant la résolution (facultatif):</label>
           <br>
                <textarea name="noteReso" rows="10" cols="50"  form="formReso"></textarea>
                <br><br>

            ');
           echo('</div>
           <input type="submit" name="valider" value="Créer"></form>');
    }

    public function rechercheResolution($reso) {
      echo('<div id="divcon">');
        echo('<br><br>Rechercher : <a href="index.php?action=rechercheResoPar">
          <button id="btn_seconnecter" type="button">Par élément </button>
        </a> <a href="index.php?action=rechercheAvancer">
          <button id="btn_seconnecter" type="button">Recherche avancée</button>
        </a><a href="index.php?action=voirReso">
          <button id="btn_seconnecter" type="button">Toutes les résolutions</button>
        </a>
        <br> <br><h2>Liste de toutes les résolutions :</h2>  <br> <br>Nombre de resultat trouvé: '.$_SESSION['count'].'<br><a href="Excel/allResolution.xlsx" download="allResolution.xlsx">Télécharger la liste</a>
        </a><br><br><table >
        <tr>
            <th>Id</th>
            <th>Numéro</th>
            <th>Sujet</th>
            <th>Date de la demande</th>
            <th>Date de reception</th>
            <th>Département</th>
            <th>Ugp</th>
        </tr>');
        foreach ($reso as $value) {
            echo('<tr><td><a href="index.php?action=resolution&id='.$value->getId().'"> '.$value->getId().'</a></td>
                    <td>'.$value->getNum().'</td>
                    <td>'.$value->getSujet().'</td>
                    <td>'.$value->getDateDemande().'</td>
                    <td>'.$value->getDateReception().'</td>
                    <td>'.$value->getDepartement_id().'</td>
                    <td>'.$value->getCodeUgp_id().'</td></tr>'  );
        }
     echo('</table>');
     echo('</div>');
    }

    public function rechercheResolutionParType($reso,$titreFichier) {

        echo('<div id="divcon"><br><br>Rechercher : <a href="index.php?action=rechercheResoPar">
          <button id="btn_seconnecter" type="button">Par élément </button>
        </a> <a href="index.php?action=rechercheAvancer">
          <button id="btn_seconnecter" type="button">recherche avancée</button>
        </a> <a href="index.php?action=voirReso">
          <button id="btn_seconnecter" type="button">Toutes les résolutions</button>
        </a>
        <br> <br><h2>Liste des résolutions '.$_SESSION['recherche'].' :</h2>  <br> <br>Nombre de resultat trouvé: '.$_SESSION['count'].'<br><a href="Excel/'.$titreFichier.'.xlsx" download="'.$titreFichier.'.xlsx">Télécharger la liste</a>
        </a><br><br><table>
        <tr>
            <th>Id</th>
            <th>Numéro</th>
            <th>Sujet</th>
            <th>Date de la demande</th>
            <th>Département</th>
            <th>Ugp</th>
        </tr>');
        foreach ($reso as $value) {
            echo('<tr><td><a href="index.php?action=resolution&id='.$value->getId().'"> '.$value->getId().'</a></td>
                    <td>'.$value->getNum().'</td>
                    <td>'.$value->getSujet().'</td>
                    <td>'.$value->getDateDemande().'</td>
                    <td>'.$value->getDepartement_id().'</td>
                    <td>'.$value->getCodeUgp_id().'</td></tr>'  );
        }
     echo('</table></div>');
    }

    public function afficherUneResolution($reso,$programme,$cour){
        echo('<div class="resolution">
                Id de la résolution:    '.$reso->getId().'<br>
                Numéro de la résolution:    '.$reso->getNum().'<br>
                Sujet de la résolution:     '.$reso->getSujet().'<br>
                Projet associé:     <a href="index.php?action=projet&id='.$reso->getNumProjet_id().'"> '.$reso->getNumProjet_id().'</a><br>
                Date de demande:    '.$reso->getDateDemande(). '<br>
                Date de reception:    '.$reso->getDateReception(). '<br>
                Traitement:     '.$reso->getTraitement(). '<br>
                Notes:  '.$reso->getNotes(). '<br>
                Departement:    '.$reso->getDepartement_id(). '<br>
                Ugp:    '.$reso->getCodeUgp_id(). '<br>
                agent:  '.$reso->getAgent_id(). '<br><br>
                Liste des programmes concerné :  <br>
                ');
        foreach ($programme as $value){
            echo($value->getCode().':  '.$value->getNom().'<br>');

        }
        echo('

                <br><br> Liste des cours concerné: <br>
                 ');
        foreach ($cour as $value){
            echo($value->getSigle().':  '.$value->getNom().'<br>');

        }
        echo('

</div>');
    }

    public function afficherUnProjet($projet){
        echo('<div class="resolution">
                Numéro du projet:    '.$projet->getNum().'<br>
                Description :     '.$projet->getDescription().'<br>
                État:    '.$projet->getEtat().'<br>
                Notes:    '.$projet->getNote(). '<br>
                Lien dossier:     '.$projet->getLien(). '<br><br><br>

        </div>');

    }
    


    public function rechercheParType($cour,$prog,$ugp,$departement,$agent){
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
        $i=2015;
        $date=date("Y");
        $fin= intval($date);
        while ($i <=$fin ) {
            echo('<option value="' . $i. '">' . $i . '</option>');
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
    
    
}
