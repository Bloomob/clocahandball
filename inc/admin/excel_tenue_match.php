<?php
$connect = mysqli_connect("localhost", "root", "root", "clocahand");

$output = '';

if(isset($_POST['export_excel'])){
  $sql = 'select * from tenue_match';
  $result = mysqli_query($connect, $sql);

  $output .= '
    <table class="table" bordered="1">
      <tr>
        <th>Numéro</th>
        <th>Taille</th>
        <th>Sexe</th>
        <th>Status</th>
        <th>Type</th>
        <th>Poste</th>
        <th>Date</th>
        <th>Adhérent</th>
      </tr>
  ';
  while($row = mysqli_fetch_array($result)){
    $output .= '
      <tr>
        <td>'.$row['HR_TENUE_NUMERO'].'</td>
        <td>'.$row['HR_TENUE_TAILLE'].'</td>
        <td>'.$row['HR_TENUE_SEXE'].'</td>
        <td>'.$row['HR_TENUE_STATUS'].'</td>
        <td>'.$row['HR_TENUE_TYPE'].'</td>
        <td>'.$row['HR_TENUE_POSTE'].'</td>
        <td>'.$row['HR_TENUE_DATE'].'</td>
        <td>'.$row['HR_TENUE_ID_ADHERENT'].'</td>
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
