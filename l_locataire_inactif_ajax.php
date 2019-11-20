<?php
include 'connexion.php';
$search=$_POST['search'];
if ($search=="")
{
	$reponse=$db->query("SELECT * FROM `locataire` WHERE statut='inactif' 
ORDER BY annee_inscription, num_dossier ASC");
$resultat=$reponse->rowCount();
}
else
{
	$reponse=$db->prepare("SELECT * FROM `locataire` WHERE CONCAT (prenom,' ',' ',nom) like CONCAT('%', ?, '%') AND statut='inactif' ORDER BY annee_inscription, num_dossier ASC");
	$reponse->execute(array($search));
}
$resultat=$reponse->rowCount();
if ($resultat<1)
{
	echo "<tr><td colspan='7'><h3 class='center'>Aucun résultat</h3></td></tr>";
}
while ($donnees= $reponse->fetch())
{
$id=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$telephone=$donnees['3'];
$cni=$donnees['4'];
$num_dossier=$donnees['5'];
$annee_inscription=$donnees['6'];
$statut=$donnees['7'];
echo "<tr>";											
	echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_locataire.php?id=$id'><i class='material-icons'>edit</i></a></td>";
	echo "<td>".str_pad($num_dossier, 3,"0", STR_PAD_LEFT)."/".substr($annee_inscription, -2)."</td>";
	echo "<td>".$prenom." ".$nom."</td>";
	echo "<td>".$cni."</td>";
	echo "<td>".$telephone."</td>";
	echo "<td> <a href='infos_mens_loc.php?id=$id'>Détail</a></td>";
	echo "<td><a class='red btn' href='s_locataire.php?id=".$id."' onclick='return(confirm(\"Voulez-vous supprimer ce locataire ?\"))'>Supprimer </a></td>";
	echo "<td><a class='brown btn' href='e_location.php?id=".$id."' onclick='return(confirm(\"Voulez-vous réactiver ce locataire ?\"))'>Réactiver </a></td>";
echo "</tr>";}

?>