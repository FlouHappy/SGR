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
<ul>
  <li><a href="index.php?action=soumettreReso">Soumettre une résolution</a></li>
  <li><a href="index.php?action=voirReso">Consulter la liste des résolution</a></li>
</ul>');
    }
    
public function afficherFormulaireRésolution(){
    echo('<form action="index.php?action=validationFormuReso" method="POST">
    <div> Sujet:
		<textarea name="sujet" cols="50" rows="10" >Saisissez ici le sujet de la résolution..</textarea></br>
			</div>
			 <div>
                         Vos attendus:
		<textarea name="Attendu" cols="50" rows="10" value="Texte_par_défaut">Saisissez ici les attendus de la résolution..</textarea><br>
			</div>
			<p><input type="submit"  name="connexion" value="Connexion" /></p>
		</form>');
    
}
       
    

}
