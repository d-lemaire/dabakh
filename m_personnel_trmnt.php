<!DOCTYPE html>
<html>
	<head>
		<title>Traitement de l'ajout</title>
		<?php include 'entete.php'; ?>
	</head>
	<body>
		<?php
		include 'connexion.php';
		include 'supprim_accents.php';
		$id=$_GET['id'];
		$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
		$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
		$telephone=htmlspecialchars($_POST['telephone']);
		$fonction=htmlspecialchars($_POST['fonction']);
		$service=htmlspecialchars($_POST['service']);
		$date_embauche=htmlspecialchars($_POST['date_embauche']);
		$login=htmlspecialchars($_POST['login']);
		
	
		$req=$db->prepare('UPDATE personnel SET prenom=?, nom=?, telephone=?, fonction=?, date_embauche=?, service=?, login=? WHERE id=? ');
		$req->execute(array($prenom, $nom, $telephone, $fonction, $date_embauche, $service, $login, $id)) or die(print_r($req->errorInfo()));
		$nbr=$req->rowCount();
		if ($nbr>0) {
		?>
		<script type="text/javascript">
			alert('Modification effectué');
			window.location="l_personnel.php";
		</script>
		<?php
		}
		else
		{
		?>
		<script type="text/javascript">
			alert('Erreur Modification non enregistré');
			window.location="l_personnel.php";
		</script>
		<?php
		}
		?>
	</body>
	<script type="text/javascript">
	$(document).ready(function(){
    $('.modal').modal();
    $('#valide').modal('open');
  	});
       
	</script>
	<style type="text/css">
		span{
			color: #0d47a1 ;
		}
	</style>
</html>