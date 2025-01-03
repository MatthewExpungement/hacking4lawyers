<?php
require "../sql.php";


if(!isset($_GET['lastname'])){
    header("Location: index.php");
}
require('../resources/header.html');
?>
<div class='container'>
  <div class="row text-center">
    <div class="col-lg-8 mx-auto">
      <h1 class='text-primary'>Search Results</h1>
      <br>
    </div>
  </div>
</div>
<div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
        <table class="table">
        <thead>
            <tr>
                <th scope="col">Case Number</th>
                <th scope="col">Case Type</th>
                <th scope="col">Plaintiff Name</th>
                <th scope="col">Defendant Name</th>
                <th scope="col">Hearing Date</th>
                <th scope="col">Expunged</th>
            </tr>
        </thead>
        <tbody>
<?php
$sqlquery = "SELECT * FROM casedata WHERE Plaintiff_Name LIKE '%". $_GET['lastname'] . "%' OR Defendant_Name LIKE '%" . $_GET['lastname'] . "%' LIMIT " . $_GET['limit'];

    try{
        $sql = $connection->query($sqlquery);
        if($sql == FALSE){
            printf("Connect failed: %s\n", $connection->error);
        }else{
            
            $fullarray = $sql->fetch_all(MYSQLI_ASSOC);
            foreach($fullarray as $case){
                $expunged_human_readable = $case['Expunged'] ? "True" : "False";

                echo "<tr><th scope='row'><a href='casepage.php?casenumber=" . $case['Case_Number'] ."'>" . $case['Case_Number'] . "</a></th><td>" . $case['Case_Type'] . "</td><td>" . $case['Plaintiff_Name'] 
                . "</td><td>" . $case['Defendant_Name'] . "</td><td>" . $case['Hearing_Date'] . "</td><td>" . $expunged_human_readable . "</td>";
                //echo("<a href='casepage.php?casenumber=" . $case['Case_Number'] . "' target='_blank'>Case " . $case['Case_Number'] . "</a>");
                //print_r($case);
            }
        }
    }catch(Exception $e){
            echo "Error";
            printf("Connect failed: %s\n", $connection->error);
            print_r($e);
    }
?>
</tbody>
</table>
</div>
</div>
</div>
<div class='container'>
  <div class="row text-left">
    <div class="col-lg-12 mx-auto">
        <hr>
      
      <button class='btn btn-primary' data-toggle="collapse" data-target="#hackerhelp">Click For Hacker Help</button>
      <div id="hackerhelp" class="collapse">
        <p>The information below might help you in your hacking</p>
        <span class='text-primary font-weight-bold'>SQL Query Being Used By The Site</span>
        <p><?php echo $sqlquery?></p>
        <?php
        if($sqlerrormessage!== False){
            echo "<span class='text-primary font-weight-bold'>SQL Error:</span>";
            echo "<p>" . $sqlerrormessage . "</p>";
        }else{
          echo "<span class='text-primary font-weight-bold'>Returned Array:</span>";
          echo "<pre>";
          print_r($returnedarray);
          echo "</pre>";
        }
        ?>
      </div>
      </br>
      </br>
    </div>
  </div>
</div>
<?php
require('../resources/footer.html');
?>