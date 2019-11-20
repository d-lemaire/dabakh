<?php
session_start();	
include 'connexion.php';
$search=$_POST['search'];
if ($search=="")  
{
	$reponse=$db->query('SELECT * FROM produit order by produit');
}
else
{
	$reponse=$db->prepare("SELECT * FROM produit WHERE produit like CONCAT('%',?,'%') order by produit");
	$reponse->execute(array($search));	
}
while ($donnees= $reponse->fetch()) {
	$id=$donnees['0'];
	$produit=$donnees['1'];
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
		echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='modif_produit.php?id=$id'><i class='material-icons left'>edit</i>Modifier</a> </td>";
      }
      else
      {
		echo "<td></td>";
      }
     
        
	echo "<td>".$produit."</td>";
	echo "<td>".number_format($pu,0,'.',' ')." Fcfa</td>";
	echo "<td>".$qt."</td>";
	echo "<tr>";
}
if (!isset($id)) 
{
	echo "<tr><td colspan='4'><h3 class='center'>Aucun produit enregistré</h3></td></tr>";
}
?>