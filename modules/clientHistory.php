<table class="table table-striped">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Commodity</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $clientsHistory = getClientHistory($_SESSION['user']->company_id);
        foreach($clientsHistory as $idRow=>$row){
          echo "<tr>";
          echo "<td>".$row['name']."</td>";
           echo "<td>".$row['surname']."</td>";
            echo "<td>".$row['comm_name']."</td>";
            echo "<td>".$row['date']."</td>";
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>