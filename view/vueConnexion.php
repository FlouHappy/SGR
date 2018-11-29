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
        <input type="text" id="placeholder" required placeholder="Entrez votre identifiant" name="usager" >
<br>
        <label for="mdp">Mot de Passe: </label><br>
        <input type="password" id="placeholder" required placeholder="Entrez votre mot de passe" name="mdp" ><br>


        <input type="submit" name="connexion" value="Connexion">

    </div>
		</form>');
    }

    public function afficherAccueilConnexionAdmin() {
        echo('<div id="vide" class="row">
        <div id="divl2">Bonjour! Vous êtes connecté en tant que Adminstrateur.</div>
        <div id="divr2"><a href="index.php?action=deconnexion">Déconnexion</a></div>

        </div>
        ');
    }

    public function afficherAccueilConnexionAgent() {
        echo('<div id="vide" class="row">
        <div id="divl2" >Bonjour ' . $_SESSION["prenom"] . ' ' . $_SESSION["nom"] . '! Vous êtes connecté en tant qu'."'".'agent.</div>
        <div id="divr2" ><a href="index.php?action=deconnexion">Déconnexion</a></div>

        </div>

        ');
    }

}
?>
