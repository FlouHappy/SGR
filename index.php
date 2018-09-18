<?php
session_start();

require_once '/vendor/autoload.php';
use SGR\controller\Connexion;
use SGR\controller\controlPublique;
use SGR\controller\controlAgent;
use SGR\controller\controlAdmin;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Systeme de Gestion des Resolutions</title>
        <link rel="stylesheet" type="text/css" href="/projetUqo/css/stylesheet.css" />
        <link href="/projetUqo/css/dycalendar.min.css" rel="stylesheet">
    </head>

    <body>
        <div id="page">
            <div id="head" class="row">
                <div id="head1"><br><br>
                    <a href="https://uqo.ca" title="Site officiel UQO.ca">UQO</a>
                </div>
                <div id="head2">
                    <h1 class="head2" ><a href="index.php">SGR</a></h1>
                    <h5 class="head21">Systeme de Gestion des Resolutions</h5>

                </div>
                <?php
                /*
                 * On vérifie ici si l user est connecté ou non et affiche la barre de connexion ou déconnexion
                 */
                $controlCon = new Connexion();
                $controlCon->verifierConnexion();
                ?>	

            </div>
            <div id="container">
                <p></p>
                <div>
                    <?php
                    
                    /*
                     * Ensemble des actions permises par type d utilisateur
                     */
                    //parti non connecté
                    if (!isset($_SESSION["user"])) {
                        $controlPublic= new controlPublique();
                        //parti non connecté avec action donné publique            
                        if (isset($_GET["action"])) {
                            switch ($_GET["action"]) {
                                case "connexion":
                                    $controlCon->formulaireConnexion();
                                    break;
                                case "validationConnexion":
                                    $controlCon->validerFormulaireConnexion();
                                    break;
                                case "accueil":
                                   $controlPublic->accueil();
                                    break;
                                case "soumettreReso":
                                     $controlPublic->formulaireRéso();
                                    
                                    break;


                                
                            }
                            //parti non connecté (page accueil ) 
                        } else {
                            header('Location: index.php?action=accueil');
                            exit();
                            
                        }

                        //parti connecté
                    } else {
                           $controlAgent=new controlAgent();
                           $controlAdmin=new controlAdmin();
                        //parti  connecté commune
                        if (isset($_GET["action"])) {
                            switch ($_GET["action"]) {

                                case "deconnexion":
                                    $controlCon->deconnecter();
                                    break;



                                
                            }
                            //parti  connecté  admin
                            if ($_SESSION["user"] == 'admin') {
                                 switch ($_GET["action"]) {
                                
                                 case "accueil":
                                    $controlAdmin->accueil();
                                    break;
                                }
                                
                            }
                            //parti  connecté agent
                            else {
                                switch ($_GET["action"]) {
                                
                                 case "accueil":
                                    $controlAgent->accueil();
                                    break;
                                }
                                
                            }
                        }else{
                            
                            header('Location: index.php?action=accueil');
                            exit();
                        }
                    }
                    ?>	
                        </div>
            </div>

        </div>

    </body>
</html>