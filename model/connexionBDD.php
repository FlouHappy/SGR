<?php
/* 
 * Grere la connexion avec la base de donnée
 * 
 * !!!!!Servira aussi avec gerer la connexion avec Gestat!!!!!!!!!
 */
namespace SGR\model;
class  ConnexionBDD

{
    
    private  $con;

    function __construct()
    {
        $this->con = mysqli_connect("localhost","root","","decanat");
        $this->con->set_charset('utf8'); 
    }
    
    public function getConnexionBDD() {
 
     return  $this->con;
   }
   
   public  function fermerConnexion(){
       mysqli_close($this->con);
       
   }
   
  

    
}

?>
