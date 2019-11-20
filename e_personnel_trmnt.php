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
		$prenom=htmlspecialchars(strtoupper(suppr_accents($_POST['prenom'])));
		$nom=htmlspecialchars(strtoupper(suppr_accents($_POST['nom'])));
		$telephone=htmlspecialchars($_POST['telephone']);
		$fonction=htmlspecialchars($_POST['fonction']);
		$service=htmlspecialchars($_POST['service']);
		$date_embauche=htmlspecialchars($_POST['date_embauche']);
		
		$reponse=$db->prepare('SELECT COUNT(*) FROM personnel WHERE nom=?');
		$reponse->execute(array($nom));
		$donnee= $reponse->fetch();
		$nbr=($donnee['0'] + 1);
		if ($nbr==1) 
		{
			$login= strtolower(str_replace(" ", "_", $nom))."@dabakh";
		}
		else
		{
			$login= strtolower(str_replace(" ", "_", $nom)).$nbr."@dabakh";
		}
		$pwd="pwd".strtolower($nom);
		$req=$db->prepare('INSERT INTO personnel(prenom, nom, telephone, fonction, date_embauche, login, pwd, service, etat) values (?,?,?,?,?,?,?,?,"activer") ');
		$req->execute(array($prenom, $nom, $telephone, $fonction, $date_embauche, $login, sha1($pwd), $service)) or die(print_r($req->errorInfo()));
		$nbr=$req->rowCount();
		if ($nbr>0) {
		?>
		<!-- Modal Structure -->
		<div id="valide" class="modal">
			<div class="modal-content">
				<h4 class="center">Inscription validée</h4>
				<h5>Le nouveau membre <span> <b> <?= $nom ?> <?= $prenom ?> </b></span> est bien enregistrer.</h5>
				<h5>Son login est : <b> <?= $login ?></b></h5>
				<h5>Son mot de passe est : <b> <?php echo"pwd".strtolower(str_replace(" ", "_", $nom)) ?></b></h5>
			</div>
			<div class="modal-footer">
				<a href="l_personnel.php" class="modal-action modal-close waves-effect waves-green btn-flat"><h6>OK</h6></a>
			</div>
		</div>
		<?php
		}
		else
		{
		?>
		<script type="text/javascript">
			alert('Erreur enregistrement non éffectué');
			window.location="e_personnel.php";
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