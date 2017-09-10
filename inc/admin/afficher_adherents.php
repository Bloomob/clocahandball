<?php include_once('dev/ajout_adherent.traitement.php'); ?>
<div class="wrapper adherents">
    <div class="row text-center">
        <div class="col-md-12">
            <h3 id="title_tenue_ajout">Liste des adhérents</h3>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Numéro Licence</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date Naissance</th>
                    <th>Email</th>
                    <th>Adresse</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($aAdherents as $adherent => $value){ ?>
                      <tr>
                        <td><?php echo $value['HR_ADHERENT_ID']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_NUM_LICENCE']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_NOM']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_PRENOM']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_DATE_NAISSANCE']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_ADRESSE_MAIL']; ?></td>
                        <td><?php echo $value['HR_ADHERENT_NUM_RUE'] . ' ' . $value['HR_ADHERENT_NOM_RUE'] . ' ' . $value['HR_ADHERENT_VILLE']; ?></td>
                        <td><a href="admin.php?page=modifier_adherent&amp;id=<?php echo $value['HR_ADHERENT_ID']; ?>" class="btn btn-warning" role="button">Modifier</a></td>

                      </tr>
                    <?php }
                     ?>
                </tbody>
            </table>
            <form class="" action="inc/admin/excel_adherent.php" method="post">
                <input type="submit" name="export_excel" class="btn btn-success" value="Export to excel" >
            </form>
        </div>
    </div>
</div>