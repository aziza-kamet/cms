<table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>login</th>
        <th>quantity</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $salesReport = reportAboutSales($_SESSION['user']->company_id);
      foreach ($salesReport as $idRow=>$row){
        echo "<tr>";
        echo "<td>$idRow</td>";
        echo "<td>".$row['login']."</td>";
        echo "<td>".$row['quantity']."</td>";
        echo "</tr>";
      }
    ?>
    </tbody>
  </table>