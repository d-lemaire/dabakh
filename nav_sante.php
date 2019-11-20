<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//calcul du nombre de personne sur la liste d'attente
include 'connexion.php';
$nbr;
if ($_SESSION['fonction']=='medecin' OR $_SESSION['fonction']=='administrateur') 
{
  $req=$db->query("SELECT COUNT(*) FROM `consultation` WHERE etat='infirmier' OR etat='secretaire'");
}
else 
{
  $req=$db->query("SELECT COUNT(*) FROM consultation WHERE etat='secretaire'");
}
  $donnee_attente=$req->fetch();
  $nbr=$donnee_attente['0'];
$req->closeCursor();

//calcul du nombre de prescription en attente
 $req=$db->query('SELECT COUNT(*) FROM `prescription` WHERE etat="non"');
$donnee_attente=$req->fetch();
  $nbr_prescription=$donnee_attente['0'];
$req->closeCursor();

//calcul du nombre de rendez-vous pour la date actuelle
 $req=$db->query('SELECT COUNT(*) FROM `rdv` WHERE date_rdv=CURRENT_DATE()');
$donnee_rdv=$req->fetch();
  $nbr_rdv=$donnee_rdv['0'];
$req->closeCursor(); 
?>



<!--Dropdown structure  soins -->
<ul id="soins" class="dropdown-content">

  <li><a href="l_analyse.php">Autres soins dispensés</a></li>
  <li><a href="l_consultation_d.php">Soins à domicile</a></li>
   <?php
    if (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='daf'))
    {
      ?>
      <li><a href="l_rapport_assis.php">Rapport d'assistance</a></li>
      <?php    
    }
    ?>
  
</ul>

<!-- Dropdown Structure constante -->
<ul id="constante" class="dropdown-content">
  <li><a href="l_patient_constante.php">Enregistrer</a></li>
  <li><a href="l_constante.php">Liste des constantes</a></li>
</ul>

<!-- Dropdown Structure services et produits -->
<ul id="prescription" class="dropdown-content">
  <?php
    if (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin'))
    {
      ?>
      <li><a href="e_prescription1.php">Nouvelle Prescription</a></li>
      <?php    
    }
    ?>
  <li><a href="l_prescription.php">Liste prescription</a></li>
</ul>

<!--Dropdown structure caisse -->
<ul id="caisse" class="dropdown-content">
     <?php
      if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='daf')
      {
        ?>
        <li><a href="e_caisse_sante.php">Nouvelle opération</a></li>
        <?php    
      }
      ?>
    <li><a href="etat_caisse_sante.php">Etat caisse</a></li>
    <?php
    if ($_SESSION['fonction']=='administrateur') 
    {
      ?>
      
      <li><a href="etat_banque.php">Etat banque</a></li>  
      <?php  
    }
    
    ?>
</ul>

<!-- Dropdown Structure services et produits -->
<ul id="s_p" class="dropdown-content">
  <li><a href="analyse.php">Analyse</a></li>
  <li><a href="consultation.php">Consultations</a></li>
  <li><a href="hospitalisation.php">Hospitalisation</a></li>
  <li><a href="produit.php">Produits</a></li>
  <li><a href="l_ravitaillement_produit.php">Ravitaillement produit</a></li>
  <li><a href="soins_externes.php">Soins externes</a></li>
  <li><a href="soins_domicile.php">Soins à domicile</a></li>
</ul>

<!-- Dropdown Structure deconnexion -->
<ul id="deconnexion" class="dropdown-content">
  <li><a href="deconnexion.php">Déconnexion</a></li>
  <?php
      if ($_SESSION['fonction']!='femme de charge')
      {
        ?>
      <li><a href="pointage_personnel_sante.php">Pointage</a></li>
      <li><a href="pointage_personnel_individuel.php?id=<?=$_SESSION['id']?>">Liste Pointage</a></li>

       <?php    
      }
      if ($_SESSION['service1']=="service general") 
      {
      ?>

       <?php
      }
      if ($_SESSION['fonction']=="administrateur") 
      {
        ?>
        <li><a href="l_compte_rendu.php">Compte rendu</a></li>
        <?php
      }
      else
      {
        ?>
        <li><a href="l_compte_rendu.php?id=<?=$_SESSION['id']?>">Compte rendu</a></li>
        <?php
      }
       if ($_SESSION['service1']=='service general') 
      {
        ?>
        <li><a href="immobilier.php">Immobilier</a></li>
        <?php
      }
      ?>
      
</ul>

<!--Dropdown structure personnel -->
<ul id="personnel" class="dropdown-content">
  <?php
    if ($_SESSION['fonction']=="administrateur") 
    {
      ?>
      <li><a href="e_personnel.php">Ajouter</a></li>
      <?php
    }
  ?>
  <li><a href="l_personnel.php">Liste personnel</a></li>
  <li><a href="list_pointage_personnel.php">Pointages du personnel</a></li>
</ul>

<!--Dropdown structure patient -->
<ul id="patient" class="dropdown-content">
   <?php
      if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='infirmier' OR $_SESSION['fonction']=='administrateur') 
      {
        echo '<li><a href="e_patient.php">Nouveau dossier</a></li>';
      }
      ?>
  <li><a href="l_patient.php">Liste des patients</a></li>
</ul>

<!--Dropdown structure consultation -->
<ul id="consultation" class="dropdown-content">
  <?php
      if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='infirmier') 
      {
        echo '<li><a href="l_patient_cons.php">Nouvelle consultation</a></li>';
      }
      ?>
  <li><a href="l_consultation.php">Liste des consultations</a></li>
</ul>

<!--Dropdown structure rendez-vous -->
<ul id="rdv" class="dropdown-content">
  <li><a href="n_patient_rdv.php">Nouveau rendez-vous</a></li>
  <li><a href="l_rdv">Liste des rendez-vous</a></li>
</ul>

<!--Dropdown structure demande -->
<ul id="demande" class="dropdown-content">
  <li><a href="l_d_regularisation.php">Régularisation</a></li>
  <li><a href="l_d_consultation.php">Consultation</a></li>
</ul>
<!--Dropdown structure contact -->
<ul id="contact" class="dropdown-content">
  <li><a href="e_contact.php">Nouveau </a></li>
  <li><a href="l_contact.php">Liste des contacts</a></li>
</ul>
<!--Dropdown structure produit-ravitaillement pour AD et infirmier -->
<ul id="ravitaillement-produit" class="dropdown-content">
  <li><a href="produit.php">Produit</a></li>
  <li><a href="l_ravitaillement_produit.php">Ravitaillement produit</a></li>
</ul>




<!--Menu -->
<!--Image d'entete-->
<div class="white center entete_img">
  <img style="" src="../css/images/entete.jpg" width="50%" >
</div>

<nav>
  <div class="nav-wrapper">
    <a href="sante.php" class="brand-logo">Dabakh</a>
    <a href="sante.php" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
	 <?php
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier') OR ($_SESSION['fonction']=='medecin'))
      {
        ?>
      <li>
        <a class="dropdown-trigger" date-beloworigin="true" data-target="ravitaillement-produit">Produit</a>
      </li>
      <?php
      
        }
     
        ?>
      <?php
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='secretaire'))
      {
        ?>
      <li>
        <a class="dropdown-trigger" date-beloworigin="true" data-target="contact">Contact</a>
      </li>
      <?php
      
        }
     
        ?>
      <li>
        <a class="dropdown-trigger" date-beloworigin="true" data-target="soins">Soins</a>
      </li>

        <?php
        
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier'))
      {
        ?>
        <li>
          <a class="dropdown-trigger" date-beloworigin="true" data-target="constante">Constante</a>
        </li>
        <li>
          <a class="dropdown-trigger" date-beloworigin="true" data-target="prescription">
          Prescription
          <?php
            if ($nbr_prescription>0) {
              echo'<span class="new badge red">'.$nbr_prescription.'</span>';
            }
          ?>
        </a>
        </li>
        <?php  
      } 
      if (($_SESSION['fonction']=='secretaire') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='daf'))
      {
        ?>
        <li>
          <a href="etat_caisse_sante.php" class="dropdown-trigger" date-beloworigin="true" data-target="caisse">Finances</a>
        </li>
        <?php  
      }       
      if ($_SESSION['fonction']=='secretaire') 
      {
        echo '<li ><a  href="consultation.php" class="dropdown-trigger" data-beloworigin="true" data-target="s_p">Services et produits</a></li>';
      }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier') OR ($_SESSION['fonction']=='secretaire'))
      {
      ?>
      <li>
        <a  href="l_attente.php">
          Liste d'attente
          <?php
            if ($nbr>0) {
              echo'<span class="new badge red">'.$nbr.'</span>';
            }
          ?>
        </a> 
      </li>
      <?php
      }
      if ($_SESSION['fonction']=='secretaire') 
      {
        echo '<li ><a  href="" class="dropdown-trigger" data-beloworigin="true" data-target="demande">Demande</a></li>';
      }
      ?>
      
      <?php
      if ($_SESSION['fonction']=='secretaire') 
      {
        ?>
        <li >
          <a  href="l_rdv.php" class="dropdown-trigger" data-beloworigin="true" data-target="rdv">
          Rendez-vous
          <?php
            if ($nbr_rdv>0) {
              echo'<span class="new badge red">'.$nbr_rdv.'</span>';
            }
          ?>
        </a>
        </li>
        <?php
      }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier' OR ($_SESSION['fonction']=='secretaire')))
      {
      ?>
      <li ><a  href="l_consultation.php" class="dropdown-trigger" data-beloworigin="true" data-target="consultation">Consultation</a></li>
      <?php
      }
      if (($_SESSION['fonction']=='secretaire') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier'))
      {
        echo '<li ><a  href="l_patient.php" class="dropdown-trigger" data-beloworigin="true" data-target="patient">Patient</a></li>';
      }
      ?>
      <?php
      if ($_SESSION['fonction']=='administrateur' OR $_SESSION['fonction']=='daf')
      {
        echo '<li ><a  href="l_personnel.php" class="dropdown-trigger" data-beloworigin="true" data-target="personnel">personnel</a></li>';
      }
      if ($_SESSION['fonction']=='femme de charge' )
      {
        echo '<li ><a  href="pointage_personnel_sante.php">Pointage</a></li>';
      }
      ?>
      <li>
        <a class="dropdown-trigger ab" href="deconnexion.php" data-beloworigin="true"  data-target="deconnexion"><i class="material-icons">power_settings_new</i></a>
      </li>
      
    </ul>
  </div>
</nav>

<ul class="sidenav" id="mobile-demo">
  <?php
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier'))
      {
        ?>
      <li><a href="l_patient_cons_d.php?p=sd">Enregistrer</a></li>
  <li><a href="l_consultation_d.php">Soins effectués</a></li>

      <?php
      }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier') OR ($_SESSION['fonction']=='secretaire'))
        {
          ?>
      <?php
      if  (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='infirmier'))
      {
        ?>
     <li><a href="e_analyse.php">Ajouter</a></li>

        <?php
      }
      ?>
  <li><a href="l_analyse.php">Autres soins dispensés</a></li>  <?php
      if  (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='infirmier'))
      {
        ?>
     <li><a href="e_analyse.php">Ajouter</a></li>

        <?php
      }
      ?>
  <li><a href="l_analyse.php">Autres soins dispensés</a></li>
        <?php
        }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier'))
      {
        ?>
         <li><a href="l_patient_constante.php">Enregistrer</a></li>
  <li><a href="l_constante.php">Liste des constantes</a></li>
        <?php
      if (($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='medecin'))
      {
        ?>
        <li><a href="e_prescription1.php">Nouvelle Prescription</a></li>
        <?php    
      }
      ?>
  <li><a href="l_prescription.php">Liste prescription</a></li>
        <?php  
      } 
      if (($_SESSION['fonction']=='secretaire') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='daf'))
      {
        ?>
         <?php
      if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='daf')
      {
        ?>
        <li><a href="e_caisse_sante.php">Nouvelle opération</a></li>
        <?php    
      }
      ?>
    <li><a href="etat_caisse_sante.php">Etat caisse</a></li>
    <?php
    if ($_SESSION['fonction']=='administrateur') 
    {
      ?>
      <li><a href="banque.php">Nouvelle opération</a></li>
      <li><a href="etat_banque.php">Etat banque</a></li>  
      <?php  
    }
    
    ?>
        <?php  
      }       
      if ($_SESSION['fonction']=='secretaire') 
      {
        ?>
         <li><a href="analyse.php">Analyse</a></li>
        <li><a href="consultation.php">Consultations</a></li>
        <li><a href="hospitalisation.php">Hospitalisation</a></li>
        <li><a href="produit.php">Produits</a></li>
        <li><a href="soins_externes.php">Soins externes</a></li>
        <li><a href="soins_domicile.php">Soins à domicile</a></li>
        <?php
      }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier') OR ($_SESSION['fonction']=='secretaire'))
      {
      ?>
      <li>
        <a  href="l_attente.php">
          Liste d'attente
          <?php
            if ($nbr>0) {
              echo'<span class="new badge red">'.$nbr.'</span>';
            }
          ?>
        </a> 
      </li>
      <?php
      }
      if ($_SESSION['fonction']=='secretaire') 
      {
        ?>
         <li><a href="l_d_regularisation.php">Régularisation</a></li>
  <li><a href="l_d_consultation.php">Consultation</a></li>
  <?php
      }
      ?>
      
      <?php
      if ($_SESSION['fonction']=='secretaire') 
      {
        ?>
        <li><a href="n_patient_rdv.php">Nouveau rendez-vous</a></li>
  <li><a href="l_rdv">Liste des rendez-vous</a></li>
        <?php
      }
      if (($_SESSION['fonction']=='medecin') OR ($_SESSION['fonction']=='administrateur') OR ($_SESSION['fonction']=='infirmier' OR ($_SESSION['fonction']=='secretaire')))
      {
      ?>
       <?php
      if ($_SESSION['fonction']=='secretaire' OR $_SESSION['fonction']=='infirmier') 
      {
        echo '<li><a href="l_patient_cons.php">Nouvelle consultation</a></li>';
      }
      ?>
  <li><a href="l_consultation.php">Liste des consultations</a></li>
      <?php
      }
      if (($_SESSION['fonction']=='secretaire') OR ($_SESSION['fonction']=='administrateur'))
      {
        ?>
         <?php
      if ($_SESSION['fonction']=='secretaire') 
      {
        echo '<li><a href="e_patient.php">Nouveau dossier</a></li>';
      }
      ?>
  <li><a href="l_patient.php">Liste des patients</a></li>
      <?php
      }
      ?>
      <?php
      if ($_SESSION['fonction']=='administrateur' OR $_SESSION['fonction']=='daf')
      {
        ?>
        <li><a href="e_personnel.php">Ajouter</a></li>
  <li><a href="l_personnel.php">Liste personnel</a></li>
  <li><a href="list_pointage_personnel.php">Pointages du personnel</a></li>
        <?php
      }
      if ($_SESSION['fonction']=='femme de charge' )
      {
        echo '<li ><a  href="pointage_personnel_sante.php">Pointage</a></li>';
      }
      ?>
     <li><a href="deconnexion.php">Déconnexion</a></li>
  <?php
      if ($_SESSION['fonction']!='femme de charge')
      {
        ?>
      <li><a href="pointage_personnel_sante.php">Pointage</a></li>
       <?php    
      }
      ?>
</ul>

<style type="text/css">
nav 
{
  background-color: #2e7d32   ; 
  <?php
    if ($_SESSION['fonction']=="infirmier") 
    {
    ?>  
    background-color: #4db6ac   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="medecin" OR $_SESSION['fonction']=="administrateur") 
    {
    ?>  
    background-color: #009688   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="secretaire") 
    {
    ?>  
    background-color: #01579b    ; 
    <?php
    }
  ?>
  }
ul.dropdown-content>li>a{/*Sélection des liens qui sont dans les listes déroulentes de la barre de navigation que l'on met en bleu*/
background-color : white   ;
color: #2e7d32  ;
<?php
    if ($_SESSION['fonction']=="infirmier") 
    {
    ?>  
    color: #4db6ac   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="medecin" OR $_SESSION['fonction']=="administrateur") 
    {
    ?>  
    color: #009688   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="secretaire") 
    {
    ?>  
    color: #01579b    ; 
    <?php
    }
  ?>
}
ul.dropdown-content>li>a:hover{
  background-color: #2e7d32  ;
<?php
    if ($_SESSION['fonction']=="infirmier") 
    {
    ?>  
    background-color: #4db6ac   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="medecin" OR $_SESSION['fonction']=="administrateur") 
    {
    ?>  
    background-color: #009688   ; 
    <?php
    }
  ?>
  <?php
    if ($_SESSION['fonction']=="secretaire") 
    {
    ?>  
    background-color: #01579b    ; 
    <?php
    }
  ?>
color: white;
}
.dropdown-trigger{
padding-left: 50px;
}
/*Code nécessaire pour la barre de navigation */
.dropdown-content {
overflow-y: visible;
}
/* Permet de décaler la liste déroulante vers la droite*/
.dropdown-content .dropdown-content {
margin-left: 100%;
}
body{
font: 12pt 'times new roman';
}
</style>
<script type="text/javascript">
$(document).ready(function(){
$('.sidenav').sidenav();
$(".dropdown-trigger").dropdown({
hover: true, //déroulement de la liste au survol de l'élément
inDuration : 400,
outDuration : 300,
coverTrigger:false,//la liste déroulante apparaîtra sous le déclencheur.

belowOrigin: false,
alignment: 'right'
});
});
</script>