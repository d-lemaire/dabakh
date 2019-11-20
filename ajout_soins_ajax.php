<?php
include 'connexion.php';
$p=$_POST['p'];
$req=$db->prepare('SELECT pu FROM soins_externes WHERE id=?');
$req->execute(array($_POST['soins']));
$donnees=$req->fetch(); 
$cout=$donnees['0'];
$req->closeCursor();

$req=$db->prepare('SELECT count(*) FROM soins_externes_patient WHERE id_soins=? AND id_patient=?');
$req->execute(array($_POST['soins'],$_POST['patient'])) or die($req->errorInfo());
$donnees1=$req->fetch(); 
$nbr=$donnees1['0'];
$req->closeCursor();
if ($nbr>0) 
{
	$req=$db->prepare("SELECT  soins_externes.soins, soins_externes.pu, soins_externes_patient.quantite, soins_externes_patient.montant, soins_externes_patient.id
		FROM soins_externes_patient, soins_externes 
		WHERE soins_externes_patient.id_soins=soins_externes.id AND soins_externes_patient.id_patient=?");
	$req->execute(array($_POST['patient']));
	$nbr=$req->rowCount();

	while ($donnees_l_soins=$req->fetch()) 
	{
		echo "<tr>";
			echo "<td>".$donnees_l_soins['0']."</td>";
			echo "<td>".$donnees_l_soins['1']."</td>";
			echo "<td>".$donnees_l_soins['2']."</td>";
			echo "<td>".$donnees_l_soins['3']."</td>";
			echo "<td><a href='supprimer_soins_externes.php?id_pat=".$_POST['patient']."&amp;id=".$donnees_l_soins['4']."&amp;p=".$p."'><i class='material-icons red-text'>clear</i></a></td>";
		echo "</tr>";		
	}	

	$req=$db->prepare("SELECT SUM(soins_externes_patient.montant) FROM soins_externes_patient WHERE soins_externes_patient.id_patient=?");
	$req->execute(array($_POST['patient'])) or die($req->errorInfo());
	$donnees=$req->fetch();
		echo '<input type="hidden" name="cout" class="cout" id="cout" value="'.$donnees['0'].'">';
	echo "<tr class='grey'>";
		echo "<td>TOTAL</td>";			
		echo "<td></td>";			
		echo "<td></td>";			
		echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
	echo "</tr>";
		?>
	<script type="text/javascript">
		alert("Soins déja enregistré");
	</script>
	<?php
}
else
{
	$date_soins=date('Y-m-d');
	$cout=$_POST['qt'] * $cout;
	$req=$db->prepare('INSERT INTO `soins_externes_patient` ( `id_soins`, `id_patient`, `quantite`, `montant`, `date_soins`) VALUES (?, ?, ?, ?, ?) ');
	$req->execute(array($_POST['soins'],$_POST['patient'], $_POST['qt'], $cout, $date_soins	)) or die($req->errorInfo());
	$req->closeCursor();

	$req=$db->prepare("SELECT  soins_externes.soins, soins_externes.pu, soins_externes_patient.quantite, soins_externes_patient.montant, soins_externes_patient.id
		FROM soins_externes_patient, soins_externes 
		WHERE soins_externes_patient.id_soins=soins_externes.id AND soins_externes_patient.id_patient=?");
	$req->execute(array($_POST['patient']));
	$nbr=$req->rowCount();

	while ($donnees_l_soins=$req->fetch()) 
	{
		echo "<tr>";
			echo "<td>".$donnees_l_soins['0']."</td>";
			echo "<td>".$donnees_l_soins['1']."</td>";
			echo "<td>".$donnees_l_soins['2']."</td>";
			echo "<td>".$donnees_l_soins['3']."</td>";
			echo "<td><a href='supprimer_soins_externes.php?id_pat=".$_POST['patient']."&amp;id=".$donnees_l_soins['4']."&amp;p=".$p."'><i class='material-icons red-text'>clear</i></a></td>";
		echo "</tr>";		
	}	

	$req=$db->prepare("SELECT SUM(soins_externes_patient.montant) FROM soins_externes_patient WHERE soins_externes_patient.id_patient=?");
	$req->execute(array($_POST['patient'])) or die($req->errorInfo());
	$donnees=$req->fetch();
		echo '<input type="hidden" name="cout" class="cout" id="cout" value="'.$donnees['0'].'">';
	echo "<tr class='grey'>";
		echo "<td>TOTAL</td>";			
		echo "<td></td>";			
		echo "<td></td>";			
		echo "<td><b>".number_format($donnees['0'],0,'.',' ')." Fcfa</b></td>";			
	echo "</tr>";
}
?>
