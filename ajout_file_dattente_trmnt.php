<?php
session_start();
include 'connexion.php';
$date_consultation=date("Y-m-d");
$req=$db->prepare("SELECT COUNT(*) FROM consultation WHERE date_consultation=? AND id_patient=? AND etat='secretaire'");
$req->execute(array($date_consultation,$_GET['id_patient']));
$donnees=$req->fetch();
$id_user=$_SESSION['prenom']." ".$_SESSION['nom'];

if ($donnees['0']>0) 
{
	?>
	<script type="text/javascript">
		alert('Patient déja ajouté à la file dattente');
		window.history.go(-1);
	</script>
	<?php
}
else
{
	$reponse=$db->query('SELECT MAX(id_consultation) FROM consultation');
	$donnees=$reponse->fetch();
	$id_consultation=$donnees['0']+1;
	$req->CloseCursor();
	$req=$db->prepare('INSERT INTO `consultation` (id_consultation, `date_consultation`,`id_patient`, etat, id_user_s) VALUES (?,?, ?, "secretaire",?)')or die(print_r($req->errorInfo()));
	$nbr=$req->execute(array($id_consultation, $date_consultation,$_GET['id_patient'], $id_user));
	if ($nbr>0) 
	{
		$id_service=$_POST['service'];
		$req=$db->prepare('UPDATE consultation SET  id_service=? WHERE id_consultation=?');
		$nbr=$req->execute(array($id_service, $id_consultation))  or die(print_r($req->errorInfo()));
		$req->closeCursor();
		if ($nbr>0) 
		{
			?>
			<script type="text/javascript">
				alert('Consultation enregistrée');
				window.location="l_attente.php";
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
				alert('Erreur consultation non enregistrée');
				//window.location="l_patient_cons.php";
			</script>
		<?php
		}
		
	}
	else
	{
		?>
		<script type="text/javascript">
			alert('Erreur patient non ajouté à la file dattente');
			//window.location="l_patient_cons.php";
		</script>
		<?php
	}
}



?>