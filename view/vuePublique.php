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


    public function afficherFormulaireRésolution(){

      echo ('

      <form class="formpub" method="POST">
        <div class="input-groupe">
        <h2> Enregistrer une resoution</h2>
          <label for="typeresolution">Type de resolutions :</label>
          <select id="typeresolution" name="Type de resolutions">
            <option value="adpore">Aministration, Politique, Reglement</option>
            <option value="contin">Contingentement</option>
            <option value="creacour">Creation de cours</option>
            <option value="entente">Entente(Reseau, Extension, etc.)</option>
            <option value="evaprog">Evaluation de programme</option>
            <option value="fermprog">Fermeture de programme</option>
            <option value="habidir">Habilitation a la direction/codirection</option>
            <option value="modifcondad">Modification aux conditions d'."'".'admission</option>
            <option value="modifcour">Modification de cours</option>
            <option value="modifprog">Modification de programme</option>
            <option value="ouverad">Ouverture des Admissions</option>
            <option value="susad">Suspension des Admissions</option>
          </select>
        </div>

        <div class="input-groupe">
          <label for="instance">Instances :</label>
          <select id="instance" name="Instances">
            <option value="ca">CA</option>
            <option value="ce">CE</option>
            <option value="sce">SCE</option>
          </select>
        </div>

        <div class="input-groupe" style="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
          <label for="datereso">Date resolution:</label>
          <div id="datepicker" class="input-group date" data-date-format="dd/mm/yyyy">
            <input type="text" name="form-control" placeholder="dd/mm/yyyy">
            <span class="input-group-addon"><i class="glyphiconcglyphicon-calendar"></i></span>
        </div>
          <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
  	      <script >
  	       $(function () {
  	          $("#datepicker").datepicker({
                format: "dd/mm/yyyy",
  	            autoclose: true,
  	            todayHighlight: true,
  		          showOtherMonths: true,
  		          selectOtherMonths: true,
  		          autoclose: true,
  		          changeMonth: true,
  		          changeYear: true,
                orientation: "button"
  	          });
  	        });
  	       </script>
        </div>

        <div class="input-groupe">
          <label for="lname">Last Name :</label>
          <input type="text" id="lname" name="lastname" placeholder="Your last name..">
        </div>

      <input type="submit" value="Creer">

      </form>
      </div>');

      /**echo('<form action="index.php?action=validationFormuReso" method="POST">
      <div> Sujet:
      <textarea name="sujet" cols="50" rows="10" >Saisissez ici le sujet de la résolution..</textarea></br>
      </div>
      <div>
      Vos attendus:
      <textarea name="Attendu" cols="50" rows="10" value="Texte_par_défaut">Saisissez ici les attendus de la résolution..</textarea><br>
      </div>
      <p><input type="submit"  name="connexion" value="Connexion" /></p>
      </form>');
      **/
    }



  }
