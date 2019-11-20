<?php
include 'connexion.php';
if ($_POST['search']=="") 
{
	$db->query("SET lc_time_names = 'fr_FR';");
	$req=$db->query("SELECT logement.id, CONCAT(bailleur.prenom,' ', bailleur.nom), logement.designation, type_logement.type_logement, logement.adresse, logement.pu, logement.nbr
	FROM `logement`, bailleur, type_logement  
	WHERE logement.id_type=type_logement.id AND logement.id_bailleur=bailleur.id AND logement.nbr>0 AND bailleur.etat='activer' ORDER BY nom, prenom");
}
else
{
	$req=$db->prepare("SELECT logement.id, CONCAT(bailleur.prenom,' ', bailleur.nom), logement.designation, type_logement.type_logement, logement.adresse, logement.pu, logement.nbr
	FROM `logement`, bailleur, type_logement  
	WHERE logement.id_type=type_logement.id AND logement.id_bailleur=bailleur.id AND logement.nbr>0 AND bailleur.etat='activer' AND CONCAT (prenom,' ',' ',nom) like CONCAT('%', ?, '%') ORDER BY nom, prenom");
	$req->execute(array($_POST['search']));
}
$resultat=$req->rowCount();
while ($donnees= $req->fetch())
{
$id=$donnees['0'];					
$bailleur=$donnees['1'];					
$logement=$donnees['2'];					
$type_logement=$donnees['3'];					
$adresse=$donnees['4'];									
$pu=$donnees['5'];					
$nbr=$donnees['6'];					
echo "<tr>";
	echo "<td></td>";
	echo "<td>".$bailleur."</td>";
	echo "<td>".$logement."</td>";
	echo "<td>".$type_logement."</td>";
	echo "<td>".$nbr."</td>";
	echo "<td>".$adresse."</td>";
	echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
echo "</tr>";
}
if ($resultat<1)
{
	echo "<h3 class='center'>Aucun résultat</h3>";
}

?>