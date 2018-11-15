public function rechercheResolutionParType($reso,$titreFichier) {

    echo('<div id=""><br><br>Rechercher : <a href="index.php?action=rechercheResoPar">
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


.input-groupe {
  margin: 10px 0px 10px 0px;
}

.input-groupe label{
  display: block;
  text-align: left;
  margin: 3px;

}
.input-groupe input{
  height: 25px;
  width: 20%;
  padding:12px 20px;
  border-radius: 5px;
  text-align: center;
  border: 1px solid black;
}
