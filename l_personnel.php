<?php
session_start();
include 'connexion.php';
if (!isset($_SESSION['fonction'])) {
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Liste du personnel</title>
		<?php include 'entete.php'; ?>
	</head>
	<body style="background-image: url(<?=$image ?>l_personnel.jpg);">
		<?php
		include 'verification_menu_sante.php';
		?>
		<div class="row">
			<h4 class="center col s12 white-text" >Liste du personnel</h4>
			<div class="col s12   ">
				<table class="bordered highlight centered striped">
					<thead>
						<tr style="color: #0d47a1">
							<th  data-field=""></th>
							<th data-field="prenom">Prénom</th>
							<th data-field="nom">Nom</th>
							<th data-field="nom">Fonction</th>
							<th data-field="tel">Date d'embauche</th>
							<th data-field="tel">N° Téléphone</th>
							<th data-field="adr">login</th>
							<th data-field="adr">Service</th>
						</tr>
					</thead>
					<tbody>
						
						<?php
						include 'connexion.php';
						$reponse=$db->query("SELECT * FROM personnel ORDER BY nom ");
						$resultat=$reponse->rowCount();
						while ($donnees= $reponse->fetch())
						{
						$id=$donnees['0'];
						$prenom=$donnees['1'];
						$nom=$donnees['2'];
						$fonction=$donnees['3'];						
						$telephone=$donnees['4'];
						$date_embauche=$donnees['5'];						
						$login=$donnees['6'];						
						$service=$donnees['8'];						
						echo "<tr>";
							if ($_SESSION['fonction']=="administrateur") 
							{
								echo "<td> <a class='tooltipped' data-position='top' data-delay='50' data-tooltip='cliquez ici pour modifier' href='m_personnel.php?id=$id'>Modifier</a></td>";
							}
							else
							{
								echo "<td></td>";
							}
							echo "<td>".$prenom."</td>";
							echo "<td>".$nom."</td>";
							echo "<td>".$fonction."</td>";
							echo "<td>".$date_embauche."</td>";
							echo "<td>".$telephone."</td>";
							echo "<td>".$login."</td>";
							echo "<td>".$service."</td>";
							if ($_SESSION['fonction']=="administrateur") 
							{
								echo "<td> <a class='btn blue darken-4 tooltipped' data-position='top' data-delay='50' data-tooltip='Modifier mot de passe' href='password_sante.php?id=$id'>Mot de passe</a></td>";
								echo "<td> <a class='btn red tooltipped' data-position='top' data-delay='50' data-tooltip='Supprimer' href='supprimer_personnel.php?id=$id'><i class='material-icons'>close</i></a></td>";
							}
						echo "</tr>";}
						
						?>
					</tbody>
				</table>
				<?php
				if ($resultat<1)
				{
					echo "<h3 class='center'>Aucun résultat</h3>";
				}
				?>
			</div>
		</div>
		
	</body>
	<style type="text/css">
		table
		{
			background: white;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
	$('.tooltipped').tooltip();
	});
	</script>
	<style type="text/css">

		/*import du css de materialize*/
		@import "../css/materialize.min.css" print;
		/*CSS pour la page à imprimer */
		/*Dimension de la page*/
		@page
		{
			size: portrait;
			margin: 0;
			margin-top: 25px;
		}
		@media print
		{
			button{
				display: none;
			}
			nav{
				display: none;
			}
			div
			{
			font: 12pt "times new roman";
			}
			select{
				border-color: transparent
			}
		}
	</style>
</html>