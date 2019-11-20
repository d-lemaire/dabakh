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
    <title>Enregistrement d'une opération</title>
    <?php include 'entete.php'; ?>
</head>
<body style="background-image: url(<?=$image ?>e_caisse_caution.jpg) ;">
    <?php
        include 'verification_menu_immo.php';   
    ?>
    <div class="container white">

        <div class="row z-depth-5" style="padding: 10px;">
            <h3 class="center">Caisse caution</h3>
            <h4 class="center">Enregistrement d'une opération</h4>
            <form class="col s12" method="POST" id="form" action="e_caisse_caution_trmnt.php">
                <div class="row">
                    <div class="col s4 input-field">
                        <select class="browser-default" name="type" required>
                            <option value="" disabled selected>Choisir type de l'opération</option>
                            <option value="entree">Entrée</option>
                            <option value="sortie">Sortie</option>
                            <option value="solde">Solde</option>

                        </select>
                    </div>
                    <div class="col s6 input-field">
                        <select class="browser-default" name="section" required>
                            <option value="" disabled selected>Section</option>
                            <option value="Approvisionnement">Approvisionnement</option>
                            <option value="Electricite">Electricite</option>
                            <option value="Eau">Eau</option>
                            <option value="Reparation">Reparation(s)</option>
                            <option value="Remboursement">Remboursement</option>
                            <option class="grey" value="solde">Solde</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <input type="text" name="motif" id="motif">
                        <label for="motif">Motif de l'opération</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s3 input-field">
                        <input type="text" class="datepicker" name="date_operation" id="date_operation" required>
                        <label for="date_operation">Date de l'opération</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="number" name="montant" id="montant">
                        <label for="montant">Montant de l'opération</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s2 offset-s8 input-field">
                        <input class="btn" type="submit" name="enregistrer" value="Sauvegarder">
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#form').submit(function() {
            if (!confirm('Voulez-vous confirmer l\'enregistrement de cette opération ?')) {
                return false;
            }
        });
        $('select').formSelect();
        $('.datepicker').datepicker({
            autoClose: true,
            yearRange: [2017, 2020],
            showClearBtn: true,
            i18n: {
                nextMonth: 'Mois suivant',
                previousMonth: 'Mois précédent',
                labelMonthSelect: 'Selectionner le mois',
                labelYearSelect: 'Selectionner une année',
                months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
                weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                today: 'Aujourd\'hui',
                clear: 'Réinitialiser',
                cancel: 'Annuler',
                done: 'OK'

            },
            format: 'yyyy-mm-dd'
        });
    });

</script>

</html>
