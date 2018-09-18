<?php
namespace SGR\view;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VueConnexion {

    function __construct() {
        
    }

    public function afficherBarreConnexion() {
        echo('<h3><a href="index.php?action=connexion">se connecter</a></h3>');
    }

    public function afficherFormulaireConnexion() {

        echo('<form action="index.php?action=validationConnexion" method="POST">
    <div> login:
		<input name="usager" id="placeholder" required placeholder="Entrez votre identifiant" /><br>
			</div>
			 <div>
                         mot de passe:
			<input name="mdp"  id="placeholder" required placeholder="Entrez votre mot de passe"/><br>
			</div>
			<p><input type="submit"  name="connexion" value="Connexion" /></p>
		</form>');
    }

    public function afficherAccueilConnexionAdmin() {
        echo('Bonjour vous etes connecté en tant que Adminstrateur <h3><a href="index.php?action=deconnexion">se déconnecter</a></h3>');
    }

    public function afficherAccueilConnexionAgent() {
        echo('Bonjour ' . $_SESSION["prenom"] . ' ' . $_SESSION["nom"] . ' vous etes connecté en tant qu'."'".'agent <h3><a href="index.php?action=deconnexion">se déconnecter</a></h3>');
    }

}
