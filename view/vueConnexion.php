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



    public function afficherFormulaireConnexion() {

        echo('<form action="index.php?action=validationConnexion" method="POST">
        <div id="divcon">

        <label for="usager">Utilisateur: </label><br>
        <input type="text" id="placeholder" required placeholder="Entrez votre identifiant" name="usager" placeholder="Votre nom d'."'".'utilisateur..">
<br>
        <label for="mdp">Mot de Passe: </label><br>
        <input type="password" id="placeholder" required placeholder="Entrez votre mot de passe" name="mdp" placeholder="Votre Mot de Passe.."><br>


        <input type="submit" name="connexion" value="Connexion">

    </div>
		</form>');
    }

    public function afficherAccueilConnexionAdmin() {
        echo('Bonjour! Vous etes connecté en tant que Adminstrateur <h3><a href="index.php?action=deconnexion">se déconnecter</a></h3>');
    }

    public function afficherAccueilConnexionAgent() {
        echo('Bonjour ' . $_SESSION["prenom"] . ' ' . $_SESSION["nom"] . '! Vous etes connecté en tant qu'."'".'agent <h3><a href="index.php?action=deconnexion">se déconnecter</a></h3>');
    }

}
?>
