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
$annee= date('Y');
$dateFormat = date("Y-m-d");
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
if(date("n")==12){
        $datefr=1;
        $annee=$annee+1;
 }
else{
$datefr = $mois[date("n")];
  }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Etat journalier de la caisse</title>
   <?php include 'entete.php'; ?>
</head>

<body style="background-image: url(<?=$image ?>etat_caisse_banque.jpg) ;">
    <?php
       include 'verification_menu_sante.php';              
    ?>
    <div class="row page">
            <br>
            <div class="col s12   ">
                <div class="row">
                    <?php
                    if ($_SESSION['fonction']!="daf")
                    {
                    ?>
                    <a href="e_caisse_sante.php" class="btn col s8 offset-s1 m2 offset-m1 ">Nouvelle opération</a>
                    <?php
                    }
                    ?>
                    <a onclick="window.print()" href="" class="btn col s8 offset-s1  m2 offset-m1">Imprimer</a>
                    <a href="etat_caisse_journalier_sante.php" class="btn col s8 offset-s3  m2 offset-m1">Caisse journalière</a>
                    <div class="col s4 input-field white" style="border-radius: 45px">
                        <i class="material-icons prefix">search</i>
                        <input type="text" name="search" id="search">
                        <label for="search">Recherche</label>
                    </div>
                </div>
                
                <div class="row" style="margin-top:-20px;">
                    <h4 class="center" style="color: #0d47a1; ">Grand livre caisse du mois de</h4>
                    <h5 class="row">
                    <select class="browser-default col offset-s3 s3 m2 offset-m4 l2 offset-l4" name="mois" class="mois" style="background-color: transparent;">
                        <?php
                        for ($i=1; $i <= 12; $i++) {
                        echo "<option value='$i'";
                            if ($mois[$i]==$datefr) {
                            echo "selected";
                            }
                        echo">$mois[$i]</option>";
                        }
                        ?>
                    </select>
                    <select class="browser-default col s2 offset-s1  m2 offset-m1 l2 offset-l1" name="annee">
                        <option value="" disabled>--Choisir Annee--</option>
                        <?php
                        echo '<option value="'. $annee .'" selected>'. $annee .'</option>';
                        echo '<option value="'. ($annee + 1) .'" >'. ($annee + 1) .'</option>';
                        ?>
                    </select>
                    </h5>
                    <table class="" >
                        <thead>
                            <tr style="color: #0d47a1">
                                <th >Date</th>
                                <th >N° PJ</th>
                                <th class="libelle">Libellé</th>
                                <th  class="compte">Débit</th>
                                <th  class="compte">Crédit</th>
                                <th  class="compte">Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>
<style type="text/css">
    select {
        font-family: georgia;
    }

    th {
        font: 16pt georgia;
        font-weight: bold;
    }

    table {
        background: white;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        function etat_caisse() {
            var search = $('input:first').val();
             var mois = $('select:eq(0)').val();
            var annee = $('select:eq(1)').val();
            $.ajax({
                type: 'POST',
                url: 'etat_caisse_sante_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee+"&search="+ search,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

       
        etat_caisse();

        $('select').change(function() {
         etat_caisse();
        });
        
         $('input:first').keyup(function(){
        var search = $('input:first').val();
        etat_caisse(search)
            });
        $('.tooltipped').tooltip();
    });

</script>
<style type="text/css">
  /*import du css de materialize*/
    @import "../css/materialize.min.css"print;
    /*CSS pour la page à imprimer */
    /*Dimension de la page*/
    @page {
    size: portrait;
    margin: 15px;
    margin-top: 25px;
    }
    .compte{
    width: 100px;
    text-align: center;
    }
    .date{
    width: 70px;
    }
    
    @media print {
    .btn, .input-field {
    display: none;
    }
    nav {
    display: none;
    }
    div {
    font: 12pt "times new roman";
        
    }
    h4{
        margin-bottom: -20px;
    }
    select {
    border-color: transparent;
        margin-bottom: -15px;
    }
    .page{
    padding: -20px;
    }
    img{
        width: 50%;
        margin-bottom: -25px;
    }

    }

</style>

</html>
