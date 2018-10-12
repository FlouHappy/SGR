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
      <div id="input-groupe">

        <a href="index.php?action=soumettreReso">
          <button id="btn_seconnecter" type="button">Soumettre une resolution </button>
        </a>

        <a href="index.php?action=voirReso">
          <button id="btn_seconnecter" type="button">Consulter liste de resolutions</button></a>
      <br>

        <a href="index.php?action=connexion">
          <button id="btn_seconnecter" type="button">Se Connecter</button>
        </a>
      </div>');
    }

    public function afficherPreFormulaireRésolution($nbCour, $nbProgramme) {

        echo ('

      <form action="index.php?action=FormulaireReso" class="formPreForm" method="POST">
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
    }

    public function afficherFormulaireProjet() {
        echo('<h1> Renseignement du projet :</h1><br>
                <label for="description">Description du projet :</label><br>
                <textarea name="description" rows="10" cols="50" required form="formReso"></textarea>
                <br><br>
          <label for="etat">Etat du projet:</label>
          <input type="radio" name="etat" value="ouvert" required> Ouvert 
          <input type="radio" name="etat" value="fermé"> Fermé
          <input type="radio" name="etat" value="attente"> En attente <br><br><br>
          
           <label for="noteProjet">Note supplémentaire concernant le projet (facultatif):</label>
           <br>
                <textarea name="noteProjet" rows="10" cols="50"  form="formReso"></textarea>
                <br><br>
           <label for="nlien">Lien vers le dossier du projet (facultatif):</label>     
    <input type="text" i required placeholder="lien vers le dossier du projet" name="lien" >
    <br>
                <br>');
    }

    public function afficherFormulaireResolution($cour, $prog, $ugp, $projet) {


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
        echo('</select> </div> ');

        if ($_POST["projet"] == "oui") {
            echo('<label for="projet">Projet : </label>
         <select id="projet" name="projet">');
            foreach ($projet as $value) {
                echo('<option value="' . $value->getNum() . '">' . $value->getNum() . ': ' . $value->getDescription() . '</option>');
            }
            echo('</select> </div> ');
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

        echo('<label for="noteReso">Note supplémentaire concernant la résolution (facultatif):</label>
           <br>
                <textarea name="noteReso" rows="10" cols="50"  form="formReso"></textarea>
                <br><br>
                
             <input type="submit" name="valider" value="Créer"></form> ');
    }

}
