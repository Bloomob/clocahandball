<?php
$connect = mysqli_connect("localhost", "root", "root", "clocahand");

$output = '';

if(isset($_POST['export_excel'])){
  $sql = 'select * from adherents';
  $result = mysqli_query($connect, $sql);

  $output .= '
    <table class="table" bordered="1">
      <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Numéro rue</th>
        <th>Nom rue</th>
        <th>Code Postal</th>
        <th>Ville</th>
        <th>Tel. Domicile</th>
        <th>Tel. Portable1</th>
        <th>Tel Portable2</th>
        <th>Adresse Mail</th>
        <th>Date de naissance</th>
        <th>Sexe</th>
        <th>Catégorie</th>
        <th>Fonction</th>
        <th>Mutation</th>
        <th>Moyen Payement1</th>
        <th>Moyen Payement2</th>
        <th>Moyen Payement3</th>
        <th>Moyen Payement4</th>
        <th>Moyen Payement5</th>
        <th>Montant Payement1</th>
        <th>Montant Payement2</th>
        <th>Montant Payement3</th>
        <th>Montant Payement4</th>
        <th>Montant Payement5</th>
        <th>Numéro Chéque Caution</th>
        <th>Document manquant</th>
        <th>Date Qualification</th>
        <th>Fiche inscription</th>
        <th>Charte Bonne conduite</th>
        <th>Date Création</th>
        <th>Commentaire</th>
        <th>Tee-shirt numéro</th>
        <th>Tee-shirt taille</th>
        <th>Tee-shirt status</th>
        <th>Tee-shirt status-date</th>
        <th>Chaussette taille</th>
        <th>Chaussette status</th>
        <th>Chaussette status-date</th>
        <th>Ballon taille</th>
        <th>Ballon status</th>
        <th>Ballon status-date</th>
        <th>Chasuble taille</th>
        <th>Chasuble status</th>
        <th>Chasuble status-date</th>
      </tr>
  ';
  while($row = mysqli_fetch_array($result)){
    $output .= '
      <tr>
        <td>'.$row['HR_ADHERENT_NUM_LICENCE'].'</td>
        <td>'.$row['HR_ADHERENT_NOM'].'</td>
        <td>'.$row['HR_ADHERENT_PRENOM'].'</td>
        <td>'.$row['HR_ADHERENT_NUM_RUE'].'</td>
        <td>'.$row['HR_ADHERENT_NOM_RUE'].'</td>
        <td>'.$row['HR_ADHERENT_CODE_POSTAL'].'</td>
        <td>'.$row['HR_ADHERENT_VILLE'].'</td>
        <td>'.$row['HR_ADHERENT_TEL_DOM'].'</td>
        <td>'.$row['HR_ADHERENT_TEL_MOB1'].'</td>
        <td>'.$row['HR_ADHERENT_TEL_MOB2'].'</td>
        <td>'.$row['HR_ADHERENT_ADRESSE_MAIL'].'</td>
        <td>'.$row['HR_ADHERENT_DATE_NAISSANCE'].'</td>
        <td>'.$row['HR_ADHERENT_SEXE'].'</td>
        <td>'.$row['HR_ADHERENT_CATEGORIE'].'</td>
        <td>'.$row['HR_ADHERENT_FONCTION'].'</td>
        <td>'.$row['HR_ADHERENT_MUTATION'].'</td>
        <td>'.$row['HR_MOYEN_PAIMENT1'].'</td>
        <td>'.$row['HR_MOYEN_PAIMENT2'].'</td>
        <td>'.$row['HR_MOYEN_PAIMENT3'].'</td>
        <td>'.$row['HR_MOYEN_PAIMENT4'].'</td>
        <td>'.$row['HR_MOYEN_PAIMENT5'].'</td>
        <td>'.$row['HR_MONTANT_PAIEMENT1'].'</td>
        <td>'.$row['HR_MONTANT_PAIEMENT2'].'</td>
        <td>'.$row['HR_MONTANT_PAIEMENT3'].'</td>
        <td>'.$row['HR_MONTANT_PAIEMENT4'].'</td>
        <td>'.$row['HR_MONTANT_PAIEMENT5'].'</td>
        <td>'.$row['HR_CHEQUE_CAUTION_NUM'].'</td>
        <td>'.$row['HR_DOC_MANQUANT'].'</td>
        <td>'.$row['HR_ADHERENT_DATE_QUALIF'].'</td>
        <td>'.$row['HR_ADHERENT_FI'].'</td>
        <td>'.$row['HR_ADHERENT_CBC'].'</td>
        <td>'.$row['HR_DATE_CREATION'].'</td>
        <td>'.$row['HR_ADHERENT_COMMENT'].'</td>
        <td>'.$row['HR_TEESHIRT_NUM'].'</td>
        <td>'.$row['HR_TEESHIRT_TAILLE'].'</td>
        <td>'.$row['HR_TEESHIRT_STATUS'].'</td>
        <td>'.$row['HR_TEESHIRT_STATUS_DATE'].'</td>
        <td>'.$row['HR_CHAUSSETTE_TAILLE'].'</td>
        <td>'.$row['HR_CHAUSSETTE_STATUS'].'</td>
        <td>'.$row['HR_CHAUSSETTE_STATUS_DATE'].'</td>
        <td>'.$row['HR_BALLON_TAILLE'].'</td>
        <td>'.$row['HR_BALLON_STATUS'].'</td>
        <td>'.$row['HR_BALLON_STATUS_DATE'].'</td>
        <td>'.$row['HR_CHASUBLE_TAILLE'].'</td>
        <td>'.$row['HR_CHASUBLE_STATUS'].'</td>
        <td>'.$row['HR_CHASUBLE_STATUS_DATE'].'</td>
      </tr>
    ';
  }
  $output .='
    </table>
  ';
  header("Content-Type: application/xls");
  header("Content-Disposition: attachment; filename=download.xls");
  echo $output;
}
