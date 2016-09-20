<table class="table table-bordered">
    <thead>
      <tr>
        <th>Commodity</th>
        <th>Number of complaints</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      
      $qualityReport = reportAboutQuality($_SESSION['user']->company_id);
      foreach ($qualityReport as $idRow=>$row){
        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['sum_commodity']."</td>";
        echo "</tr>";
      }
    ?>
    </tbody>
  </table>