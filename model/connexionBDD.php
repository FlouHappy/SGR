<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
