<?php	
session_start();				
include 'connexion.php';
$search=$_POST['search'];
$annee=$_POST['annee'];
$db->query("SET lc_time_names = 'fr_FR';");
if ($search=="") 
{
	if ($annee=="all") 
	{
		$reponse=$db->query("SELECT * FROM patient ORDER BY annee_inscription, num_dossier ASC");
	}
	else
	{
		$reponse=$db->prepare("SELECT * FROM patient WHERE annee_inscription=? ORDER BY annee_inscription, num_dossier ASC");
		$reponse->execute(array($annee));
	}
}
else
{
	if ($annee=="all") 
	{
		$reponse=$db->prepare("SELECT * FROM patient WHERE CONCAT (prenom,' ',' ',nom) like CONCAT('%', ?, '%')  ORDER BY annee_inscription, num_dossier ASC");
		$reponse->execute(array($search));
	}
	else
	{
		$reponse=$db->prepare("SELECT * FROM patient WHERE CONCAT (prenom,' ',' ',nom) like CONCAT('%', ?, '%') AND annee_inscription=?  ORDER BY annee_inscription, num_dossier ASC");
		$reponse->execute(array($search, $annee));
	}
	
}

$resultat=$reponse->rowCount();
while ($donnees= $reponse->fetch())
{
$id_patient=$donnees['0'];
$prenom=$donnees['1'];
$nom=$donnees['2'];
$date_naissance=$donnees['3'];
$lieu_naissance=$donnees['4'];
$profession=$donnees['5'];
$domicile=$donnees['6'];
$telephone=$donnees['7'];
$sexe=$donnees['8'];
$situation_matrimoniale=$donnees['9'];
$antecedant=$donnees['10'];
$allergie=$donnees['11'];
$num_dossier=$donnees['12'];
$annee_inscription=$donnees['13'];

echo "<tr>";
	echo "<td>";
	if ($_SESSION['fonction']=='administrateur')
	{
	 echo "<a class='red btn' href='supprimer.php?id_patient=".$id_patient."' onclick='return(confirm(\"Voulez-vous supprimer ce patient ainsi que toutes les consultations effectuées par ce dernier ?\"))'>Supprimer </a><br><br>";
	echo "<a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_patient.php?id=$id_patient'><i class='material-icons'>edit</i></a>";

	}
	echo "</td>";
	echo "<td>".str_pad($num_dossier, 3,"0",STR_PAD_LEFT)."/".substr($annee_inscription, -2)."</td>";
	echo "<td>".$prenom." ".$nom."</td>";
	echo "<td>".$date_naissance." à ".$lieu_naissance."</td>";
	echo "<td>".$profession."</td>";
	echo "<td>".$domicile."</td>";
	echo "<td>".$telephone."</td>";
	echo "<td><a target='_blank' class='btn' href='dossier_p.php?id=".$id_patient."'>Dossier</a><br><br>";
	if ($_SESSION['fonction']=='administrateur' OR $_SESSION['fonction']=='secretaire')
	{
	echo "<a target='_blank' class='' href='d_regularisation.php?id=".$id_patient."'>Demande de régularisation</a><br><br><a target='_blank' class='' href='d_consultation.php?id=".$id_patient."'>Demande de consultation</a>";
	}
	echo "</td>";
echo "</tr>";}
if ($resultat<1)
{
	echo "<tr><td colspan='4'><h3 class='center'>Aucun patient</h3></td></tr>";
}

?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>