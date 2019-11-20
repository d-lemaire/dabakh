<?php	
session_start();				
include 'connexion.php';
$search=$_POST['search'];
$db->query("SET lc_time_names = 'fr_FR';");
if ($search=="") {
	$reponse=$db->query("SELECT * FROM patient");
}
else
{
	$reponse=$db->prepare("SELECT * FROM patient WHERE prenom like CONCAT('%', ?, '%') OR nom like CONCAT('%', ?, '%')");
	$reponse->execute(array($search,$search));
}

$resultat=$reponse->rowCount();
while ($donnees= $reponse->fetch())
{
$id_patient=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$date_naissance=$donnees['3'];
$lieu_naissance=$donnees['4'];

echo "<tr>";
	echo "<td></td>";
	echo "<td>".$id_patient."</td>";
	echo "<td>".$prenom."</td>";
	echo "<td>".$nom."</td>";
	echo "<td>".$date_naissance." à ".$lieu_naissance."</td>";
	echo "<td><a class='btn ' href='e_rdv.php?id_patient=".$id_patient."'>Programmer</a></td>";
echo "</tr>";}
if ($resultat<1)
{
	echo "<tr><td colspan='4'><h3 class='center'>Aucun patient</h3></td></tr>";
}

?>