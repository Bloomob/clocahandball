<?php include_once('dev/ajout_tenue.traitement.php'); ?>
<div class="wrapper tenues">
    <div class="row text-center">
            <div class="col-md-12">
            <h3 id="title_tenue_ajout">Liste des tenues de match</h3>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Numero</th>
                    <th>Taille</th>
                    <th>Sexe</th>
                    <th>Poste</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Joueur</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($aTenue as $tenue => $value){ ?>
                      <tr>
                        <td><?php echo $value['HR_TENUE_ID']; ?></td>
                        <td><?php echo $value['HR_TENUE_NUMERO']; ?></td>
                        <td><?php echo $value['HR_TENUE_TAILLE']; ?></td>
                        <td><?php echo $value['HR_TENUE_SEXE']; ?></td>
                        <td><?php echo $value['HR_TENUE_POSTE']; ?></td>
                        <td><?php echo $value['HR_TENUE_STATUS']; ?></td>
                        <td><?php echo $value['HR_TENUE_TYPE']; ?></td>
                        <td><?php echo $value['HR_TENUE_ID_ADHERENT']; ?></td>
                        <td><?php echo $value['HR_TENUE_DATE']; ?></td>
                        <td><a href="admin.php?page=modifier_tenue&amp;id=<?php echo $value['HR_TENUE_ID']; ?>" class="btn btn-warning" role="button">Modifier</a></td>
                      </tr>
                    <?php }
                     ?>
                </tbody>
            </table>
            <form class="" action="inc/admin/excel_tenue_match.php" method="post">
                <input type="submit" name="export_excel" class="btn btn-success" value="Export to excel" >
            </form>
        </div>
    </div>
</div>
