<?php
require('header.html');
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

<?php
require('footer.html');
?>