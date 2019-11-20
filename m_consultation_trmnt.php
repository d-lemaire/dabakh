<?php
//recupération du prix du service dispensé
include 'connexion.php';
$id_service=$_POST['service'];
$req=$db->prepare("SELECT pu FROM service WHERE id=?");
$req->execute(array($id_service));
$donnees=$req->fetch();
$pu_sevice=$donnees['0'];
$req->closeCursor();
$etat='medecin';
$date_consultation=$_POST['date_consultation'];
$poids=$_POST['poids'];
$tension=$_POST['tension'];
$pouls=$_POST['pouls'];
$temperature=$_POST['temperature'];
$glycemie=$_POST['glycemie'];
$tdr=$_POST['tdr'];
$plaintes=$_POST['plaintes'];
$histoire_maladie=htmlspecialchars($_POST['histoire_maladie']);
$ant_medicaux=htmlspecialchars($_POST['ant_medicaux']);
$ant_chirurgicaux=htmlspecialchars($_POST['ant_chirurgicaux']);
$traitement_cours=htmlspecialchars($_POST['traitement_cours']);
$allergie=htmlspecialchars($_POST['allergie']);
$neurologie=htmlspecialchars($_POST['neurologie']);
$hemodynamique=htmlspecialchars($_POST['hemodynamique']);
$respiratoire=htmlspecialchars($_POST['respiratoire']);
$autres_appareils=htmlspecialchars($_POST['autres_appareils']);
$ecg=htmlspecialchars($_POST['ecg']);
$biologie=htmlspecialchars($_POST['biologie']);
$radiographie=htmlspecialchars($_POST['radiographie']);
$tdm=htmlspecialchars($_POST['tdm']);
$echographie=htmlspecialchars($_POST['echographie']);
$autres_examen=htmlspecialchars($_POST['autres_examen']);
$traitement=htmlspecialchars($_POST['traitement']);
$evolution=htmlspecialchars($_POST['evolution']);
$traitement_sortie=htmlspecialchars($_POST['traitement_sortie']);
$resume=htmlspecialchars($_POST['resume']);

if (isset($_POST['cout'])) 
{
	$cout=$_POST['cout'];
}
else
{
	$cout=0;
}
if (isset($_POST['cout_hospitalisation'])) 
{
	$cout_hospitalisation=$_POST['cout_hospitalisation'];
}
else
{
	$cout_hospitalisation=0;
}

$montant=$cout+$cout_hospitalisation+$pu_sevice;

$req=$db->prepare('UPDATE consultation SET date_consultation=?, poids=?, pouls=?, tension=?, temperature=?, etat=?, glycemie=?, tdr=?, histoire_maladie=?, ant_medicaux=?, ant_chirurgicaux=?, traitement_cours=?, allergie=?, neurologie=?, hemodynamique=?, respiratoire=?, autres_appareils=?, ecg=?, biologie=?, radiographie=?, tdm=?, echographie=?, autres_examen=?, id_service=?, montant=?, traitement=?, evolution=?, traitement_sortie=?, resume=?, plaintes=? WHERE id_consultation=?');
$nbr=$req->execute(array($date_consultation, $poids, $pouls, $tension, $temperature, $etat, $glycemie, $tdr, $histoire_maladie, $ant_medicaux, $ant_chirurgicaux, $traitement_cours, $allergie, $neurologie, $hemodynamique, $respiratoire, $autres_appareils, $ecg, $biologie, $radiographie, $tdm, $echographie, $autres_examen, $id_service, $montant, $traitement, $evolution, $traitement_sortie, $resume, $plaintes, $_GET['id']))  or die(print_r($req->errorInfo()));
$req->closeCursor();
if ($nbr>0) 
{
	if ($_GET['reglement']=='non') 
	{
		
	?>
	<script type="text/javascript">
		alert('Consultation modifiée.');
		window.location="l_consultation.php";
	</script>
	<?php
	}
	else
	{
		?>
		<script type="text/javascript">
			alert('Consultation modifiée. Veillez penser à refaire la facture en supprimant l\'ancien reglement dans la caisse ');
			window.location="l_consultation.php";
		</script>
		<?php
}
//header('location:i_m_mensualite.php?id='.$num);
}
else
{
?>
<script type="text/javascript">
	alert('Erreur consultation non modifiée');
	window.location="l_consultation.php";
</script>
<?php
}

?>