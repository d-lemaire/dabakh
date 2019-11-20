<?php
session_start();	
include 'connexion.php';
$search=$_POST['search'];
if ($search=="")  
{
	$reponse=$db->query('SELECT * FROM consommable order by consommable');
}
else
{
	$reponse=$db->prepare("SELECT * FROM consommable WHERE consommable like CONCAT('%',?,'%') order by consommable");
	$reponse->execute(array($search));	
}
while ($donnees= $reponse->fetch()) {
	$id=$donnees['0'];
	$consommable=$donnees['1'];
	$pu=$donnees['2'];
	$qt=$donnees['3'];
	$id_ravitaillement=$donnees['4'];
	if ($qt<1) 
	{
		echo "<tr class='red lighten-3'>";
	}
	elseif ($qt<11) 
	{
		echo "<tr class='yellow lighten-3'>";
	}
	else
	{
		echo "<tr>";
	}
	
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='secretaire'))
      {
		echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_consommable.php?id=$id'><i class='material-icons left'>edit</i></a><br><br>
		<a class='tooltipped red-text' data-position='top' data-delay='50' data-tooltip='supprimer' href='s_consommable.php?id=$id' onclick='return(confirm(\"Voulez-vous supprimer ce consommable ?\"))'><i class='material-icons left'>close</i></a> </td>";
      }
     
        
	echo "<td>".$consommable."</td>";
	echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
	echo "<td>".$qt."</td>";
	
	echo "<td><a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour ravitailler' href='e_ravitaillement_consommable.php?id=$id'>ravitailler</a></td>";
	echo "<tr>";
}
if (!isset($id)) 
{
	echo "<tr><td colspan='4'><h3 class='center'>Aucun consommable enregistré</h3></td></tr>";
}
?>
<script type="text/javascript">
	$('.tooltipped').tooltip();
</script>